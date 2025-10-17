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
use App\Models\SocialActivity;
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
use App\Filament\Resources\SocialActivityResource\Pages;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Tables\Actions\{Action, ActionGroup, EditAction, DeleteAction, BulkActionGroup, DeleteBulkAction};

class SocialActivityResource extends Resource
{
    protected static ?string $model = SocialActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Social Activities';
    protected static ?string $slug = 'social-activities';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(1) // 1 kolom → semua field full width
                ->schema([
                    Split::make([
                        Card::make('Social Activity Details')
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

                                TextInput::make('title')
                                    ->label('Activity Title')
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
                                    ->placeholder('Auto-generated from title')
                                    ->reactive()
                                    ->suffixAction(
                                        FormAction::make('generateSlug')
                                            ->label('Generate')
                                            ->icon('heroicon-o-arrow-path') // ganti icon kalau mau
                                            ->action(function (Forms\Get $get, Forms\Set $set) {
                                                $title = $get('title') ?? '';
                                                $set('slug', Str::slug($title));
                                            })
                                    )
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        if (! blank($state)) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),

                                // Excerpts
                                Textarea::make('excerpt')
                                    ->label('Excerpts')
                                    ->maxLength(250)
                                    ->extraInputAttributes(['maxlength' => 250])
                                    ->rows(3)
                                    ->required(),

                                // Content
                                RichEditor::make('content')
                                    ->required()
                                    ->fileAttachmentsDisk('public') // pakai disk public
                                    ->disabled(fn(Get $get) => blank($get('slug')))
                                    ->helperText(fn(Get $get) => blank($get('slug'))
                                        ? 'Please fill in the slug first before editing content.'
                                        : null)
                                    ->fileAttachmentsDirectory(fn(Get $get) => 'social_activity/' . ($get('slug') ?: Str::slug($get('title') ?? 'temporary-upload'))),

                            ])
                            ->columns(1)
                            ->grow(),

                        Card::make('SEO Details')
                            ->description('Media and SEO settings.')
                            ->schema([
                                // Thumbnail upload
                                FileUpload::make('thumbnail')
                                    ->label('Thumbnail')
                                    ->image()
                                    ->disk('public')
                                    ->maxSize(500)
                                    ->directory(fn(Get $get) => 'social_activity/' . ($get('slug') ?: Str::slug($get('title') ?? 'social_activities')))
                                    ->visibility('public')
                                    ->multiple(false) // single file
                                    ->getUploadedFileNameForStorageUsing(function ($file, $get) {
                                        $slug = Str::slug($get('title') ?? 'thumbnail');
                                        $extension = $file->getClientOriginalExtension();
                                        return $slug . '.' . $extension; // nama file = slug.ext
                                    })
                                    ->formatStateUsing(fn($state) => $state ? [$state] : []) // preview saat edit
                                    ->dehydrateStateUsing(fn($state) => is_array($state) && array_is_list($state) ? array_shift($state) : $state)
                                    ->required(),

                                // Thumbnail alt text
                                TextInput::make('thumbnail_alt_text')
                                    ->label('Thumbnail Alt Text')
                                    ->placeholder('Enter alt text for the thumbnail')
                                    ->columnSpanFull()
                                    ->maxLength(100)
                                    ->extraInputAttributes(['maxlength' => 100])
                                    ->reactive()
                                    ->hidden(fn($get) => ! $get('thumbnail')),

                                // Meta Description & Keywords
                                Section::make('Search Engine Optimization (SEO)')
                                    ->collapsed(0)
                                    ->schema([
                                        TextInput::make('meta_title')->maxLength(100)
                                            ->extraInputAttributes(['maxlength' => 100])->label('Meta Title'),
                                        TextInput::make('meta_keywords')->maxLength(100)
                                            ->extraInputAttributes(['maxlength' => 100])->label('Meta Keywords'),

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
                TextColumn::make('title')->label('Title')->sortable()->searchable()
                    ->formatStateUsing(function ($state) {
                        return Str::limit($state, 35, '...');
                    }),
                TextColumn::make('updated_at')->label('Updated')->dateTime()->sortable()
                    ->formatStateUsing(
                        fn($state) =>
                        $state
                            ? Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y, H.i')
                            : '-'
                    )->toggleable(),
                IconColumn::make('is_published')
                    ->boolean()  // This will automatically handle true/false values
                    ->label('Published') // Optional: Add a custom label for the column
                    ->trueIcon('heroicon-o-check-circle') // Icon for true value
                    ->falseIcon('heroicon-o-x-circle') // Icon for false value
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('preview')
                        ->label('Preview')
                        ->icon('heroicon-o-eye')
                        ->url(function ($record) {
                            // Pastikan hanya tampil kalau sudah publish
                            if (! $record->is_published || ! $record->slug) {
                                return null;
                            }
                            return route(
                                'social.show',
                                $record->slug,
                            );
                        })
                        ->openUrlInNewTab()
                        ->visible(fn(SocialActivity $record) => filled($record->slug))
                        ->color('info'),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
                    ->button()
                    ->label('Actions'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListSocialActivities::route('/'),
            'create' => Pages\CreateSocialActivity::route('/create'),
            'edit' => Pages\EditSocialActivity::route('/{record}/edit'),
        ];
    }
}
