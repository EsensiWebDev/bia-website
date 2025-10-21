<?php

namespace App\Filament\Resources;



use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\Career;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Split;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\CareerResource\Pages;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Tables\Actions\{Action, ActionGroup, EditAction, DeleteAction, BulkActionGroup, DeleteBulkAction};

class CareerResource extends Resource
{
    protected static ?string $model = Career::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1) // 1 kolom → semua field full width
                    ->schema([
                        Split::make([
                            Card::make('Career Details')
                                ->description('Basic information, content, and the main description.')
                                ->schema([
                                    // Publish Toggle
                                    Toggle::make('is_published')
                                        ->label('Publish Activity')
                                        ->onColor('success')
                                        ->offColor('danger')
                                        ->default(true)
                                        ->columnSpanFull()
                                        ->required(),

                                    Group::make([

                                        DatePicker::make('publish_date')
                                            ->default(now())
                                            ->timezone('Asia/Jakarta')
                                            ->required()
                                            ->label('Publish Date'),

                                        TextInput::make('author')
                                            ->default(fn() => Auth::user()?->name)
                                            ->disabled()
                                            ->dehydrated(true) // tetap disimpan ke DB walau disabled
                                            ->required(),
                                    ])->columns(2),

                                    TextInput::make('career_title')
                                        ->label('Career Position')
                                        ->required()
                                        ->maxLength(255)
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, Set $set, $get) {
                                            if (blank($get('slug'))) {
                                                $set('slug', Str::slug($state));
                                            }
                                        }),

                                    TextInput::make('slug')
                                        ->label('Slug')
                                        ->required()
                                        ->unique(ignoreRecord: true)
                                        ->maxLength(255)
                                        ->placeholder('Auto-generated from Position')
                                        ->reactive()
                                        ->suffixAction(
                                            FormAction::make('generateSlug')
                                                ->label('Generate')
                                                ->icon('heroicon-o-arrow-path') // ganti icon kalau mau
                                                ->action(function (Forms\Get $get, Forms\Set $set) {
                                                    $title = $get('career_title') ?? '';
                                                    $set('slug', Str::slug($title));
                                                })
                                        )
                                        ->afterStateUpdated(function ($state, Set $set) {
                                            if (! blank($state)) {
                                                $set('slug', Str::slug($state));
                                            }
                                        }),

                                    // Excerpts
                                    Textarea::make('short_desc')
                                        ->label('Short Description')
                                        ->maxLength(250)
                                        ->rows(3)
                                        ->required(),

                                    // Content
                                    RichEditor::make('content')
                                        ->required()->disableToolbarButtons([
                                            'h3',
                                        ])
                                        ->fileAttachmentsDisk('public') // pakai disk public
                                        ->disabled(fn(Get $get) => blank($get('slug')))
                                        ->helperText(fn(Get $get) => blank($get('slug'))
                                            ? 'Please fill in the slug first before editing content.'
                                            : null)
                                        ->fileAttachmentsDirectory(fn(Get $get) => 'career/' . ($get('slug') ?: Str::slug($get('career_title') ?? 'temporary-upload'))),

                                ])
                                ->columns(1)
                                ->grow(),

                            Card::make('How to Apply Details')
                                ->description('Rule Apply and SEO settings.')
                                ->schema([
                                    Group::make([

                                        DatePicker::make('start_date')
                                            ->default(null)
                                            ->timezone('Asia/Jakarta')
                                            ->label('Start Recruitment'),

                                        DatePicker::make('end_date')
                                            ->default(null)
                                            ->timezone('Asia/Jakarta')
                                            ->label('End Recruitment'),
                                    ])->columns(2),

                                    // How to apply
                                    TextInput::make('email_send')->email()->label('Send Email To')->placeholder('hrm@biadentalcenter.com '),
                                    TextInput::make('subject_send')->label('Subject')->placeholder(' [Position] – Your Name'),
                                    TextInput::make('exsubject_send')->label('Extra Subject')->placeholder('Dental Technician – Satria Wijaya'),

                                    // Meta Description & Keywords
                                    Section::make('Search Engine Optimization (SEO)')
                                        ->collapsed(0)
                                        ->schema([
                                            TextInput::make('meta_title')->maxLength(100)
                                                ->extraInputAttributes(['maxlength' => 100]),
                                            TextInput::make('meta_keywords')->maxLength(100)
                                                ->extraInputAttributes(['maxlength' => 100]),

                                            Textarea::make('meta_description')
                                                ->label('Meta Description')
                                                ->maxLength(160)
                                                ->extraInputAttributes(['maxlength' => 160])
                                                ->rows(3),
                                        ])->compact(), // Menggunakan compact untuk tampilan yang lebih kecil
                                ])
                                ->collapsible(false)->grow(false),
                        ])->from('md')
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('career_title')
                    ->searchable(),
                TextColumn::make('publish_date')->label('Publish Date')->dateTime()->sortable()
                    ->formatStateUsing(
                        fn($state) =>
                        $state
                            ? Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y')
                            : '-'
                    )->toggleable(),
                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                TextColumn::make('recruitment_range')
                    ->label('Range Recruitment')
                    ->getStateUsing(function ($record) {
                        $start = !empty($record->start_date)
                            ? Carbon::parse($record->start_date)
                            ->locale('id')
                            ->translatedFormat('d F Y')
                            : null;

                        $end = !empty($record->end_date)
                            ? Carbon::parse($record->end_date)
                            ->locale('id')
                            ->translatedFormat('d F Y')
                            : null;

                        if ($start && $end) {
                            return "Recruitment Period: {$start} – {$end}";
                        } elseif ($start) {
                            return "Recruitment Starts From: {$start}";
                        } elseif ($end) {
                            return "Recruitment Open Until: {$end}";
                        } else {
                            return "Recruitment Period: Not Specified";
                        }
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\Action::make('preview')
                        ->label('Preview')
                        ->icon('heroicon-o-eye')
                        ->url(function ($record) {
                            // Pastikan hanya tampil kalau sudah publish dan punya category
                            if (! $record->is_published || ! $record->slug) {
                                return null;
                            }

                            return route(
                                'career.show',
                                $record->slug,
                            );
                        })
                        ->openUrlInNewTab()
                        ->disabled(fn($record) => ! $record->is_published || ! filled($record->slug))
                        ->color('info'),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
                    ->button()
                    ->label('Actions'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCareers::route('/'),
            'create' => Pages\CreateCareer::route('/create'),
            'edit' => Pages\EditCareer::route('/{record}/edit'),
        ];
    }
}
