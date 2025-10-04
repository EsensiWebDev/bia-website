<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Articles;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\CategoryArticle;
use Filament\Resources\Resource;
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
use App\Filament\Resources\ArticlesResource\Pages;

class ArticlesResource extends Resource
{
    protected static ?string $model = Articles::class;

    protected static ?string $navigationGroup = 'Articles';
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationLabel = 'Articles List';

    public static function form(Form $form): Form
    {
        return $form->schema([

            // Publish Toggle
            Toggle::make('is_published')
                ->label('Publish Article')
                ->onColor('success')
                ->offColor('danger')
                ->default(true)
                ->columnSpanFull()
                ->required(),

            Group::make([
                TextInput::make('author')
                    ->default(fn() => Auth::user()?->name)
                    ->disabled()
                    ->dehydrated(true) // tetap disimpan ke DB walau disabled
                    ->required(),

                DatePicker::make('publish_date')
                    ->default(now())
                    ->timezone('Asia/Jakarta')
                    ->required()
                    ->label('Publish Date'),
            ])->columns(2),

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

            // Category (dropdown dari CategoryArticle)
            Select::make('category_article_id')
                ->label('Category *')
                ->options(CategoryArticle::pluck('title', 'id')->toArray())
                ->searchable()
                ->required(),

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
                ->reactive()
                ->hidden(fn($get) => ! $get('thumbnail')),


            // Content
            RichEditor::make('content')
                ->required()
                ->fileAttachmentsDisk('public') // pakai disk public
                ->fileAttachmentsDirectory(fn(Get $get) => 'articles/' . ($get('slug') ?: Str::slug($get('title') ?? 'article'))),

            // Meta Description & Keywords
            Group::make([
                TextInput::make('meta_title'),
                TextInput::make('meta_keywords'),
            ])->columns(2),

            Textarea::make('meta_description')
                ->label('Meta Description')
                ->maxLength(160)
                ->rows(3),

        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('publish_date')->sortable()->searchable(),
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
                Tables\Actions\EditAction::make(),
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
