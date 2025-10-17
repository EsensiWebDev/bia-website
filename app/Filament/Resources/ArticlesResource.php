<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Articles;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\CategoryArticle;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Actions\Action;
use Filament\Tables\Actions\{EditAction, DeleteAction, ActionGroup};
use App\Filament\Resources\ArticlesResource\Pages;

class ArticlesResource extends Resource
{
    protected static ?string $model = Articles::class;

    protected static ?string $navigationGroup = 'Articles';
    protected static ?string $navigationIcon = null;
    protected static ?string $navigationLabel = 'Article List';
    protected static ?string $pluralLabel = 'Articles';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make('Article Details')
                ->description('Basic information, content, and the main description.')
                ->schema([
                    // Publish Toggle
                    Toggle::make('is_published')
                        ->label('Publish Article')
                        ->onColor('success')
                        ->offColor('danger')
                        ->default(true)
                        ->columnSpanFull()
                        ->required(),

                    Group::make([

                        // Category (dropdown dari CategoryArticle)
                        Select::make('category_article_id')
                            ->label('Category *')
                            ->options(CategoryArticle::pluck('title', 'id')->toArray())
                            ->searchable()
                            ->required(),

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
                    ])->columns(3),

                    TextInput::make('title')
                        ->label('Article Title')
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
                            Action::make('generateSlug')
                                ->label('Generate')
                                ->icon('heroicon-o-arrow-path') // ganti icon kalau mau
                                ->action(function (Forms\Get $get, Forms\Set $set) {
                                    $title = $get('title') ?? '';
                                    $set('slug', Str::slug($title));
                                })
                        )
                        // jika user mengedit slug manual, kita normalisasi isian jadi slug-safe
                        ->afterStateUpdated(function ($state, Set $set) {
                            if (! blank($state)) {
                                $set('slug', Str::slug($state));
                            }
                        }),


                    // Thumbnail upload
                    FileUpload::make('thumbnail')
                        ->label('Thumbnail')
                        ->image()
                        ->disk('public')
                        ->directory(fn(Get $get) => 'articles/' . ($get('slug') ?: Str::slug($get('title') ?? 'article')))
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


                    // Content
                    RichEditor::make('content')
                        ->required()
                        ->fileAttachmentsDisk('public') // pakai disk public
                        ->disabled(fn(Get $get) => blank($get('slug')))
                        ->helperText(fn(Get $get) => blank($get('slug'))
                            ? 'Please fill in the slug first before editing content.'
                            : null)
                        ->fileAttachmentsDirectory(fn(Get $get) => 'articles/' . ($get('slug') ?: Str::slug($get('title') ?? 'temporary-upload'))),

                ]),

            Card::make('Article Details')
                ->description('Basic information, content, and the main description.')
                ->schema([
                    // Meta Description & Keywords
                    Group::make([
                        TextInput::make('meta_title')->maxLength(100)
                            ->extraInputAttributes(['maxlength' => 100])->label('Meta Title'),
                        TextInput::make('meta_keywords')->maxLength(100)
                            ->extraInputAttributes(['maxlength' => 100])->label('Meta Keywords'),
                    ])->columns(2),

                    Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->maxLength(160)
                        ->rows(3),
                ]),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('category.title')->label('Category')->sortable(),
                TextColumn::make('slug')->label('Slug')->toggleable(isToggledHiddenByDefault: true),
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
                    Tables\Actions\Action::make('preview')
                        ->label('Preview')
                        ->icon('heroicon-o-eye')
                        ->url(function ($record) {
                            // Pastikan hanya tampil kalau sudah publish dan punya category
                            if (! $record->is_published || ! $record->category?->slug || ! $record->slug) {
                                return null;
                            }

                            return route('blog.show', [
                                'category' => $record->category->slug,
                                'slug' => $record->slug,
                            ]);
                        })
                        ->openUrlInNewTab()
                        ->disabled(fn($record) => ! $record->is_published || ! filled($record->category?->slug) || ! filled($record->slug))
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticles::route('/create'),
            'edit' => Pages\EditArticles::route('/{record}/edit'),
        ];
    }
}
