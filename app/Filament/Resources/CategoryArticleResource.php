<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryArticleResource\Pages;
use App\Models\CategoryArticle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Tables\Columns\ImageColumn;

class CategoryArticleResource extends Resource
{
    protected static ?string $model = CategoryArticle::class;

    // Navigasi
    protected static ?string $navigationGroup = 'Articles';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Category Article';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Category Title')
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

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3),

                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('cat-articles')
                    ->visibility('public')
                    ->multiple(false) // single file
                    ->getUploadedFileNameForStorageUsing(function ($file, $get) {
                        $slug = Str::slug($get('title') ?? 'thumbnail');
                        $extension = $file->getClientOriginalExtension();
                        return $slug . '.' . $extension;
                    })
                    ->formatStateUsing(fn($state) => $state ? [$state] : []) // untuk preview saat edit
                    ->dehydrateStateUsing(fn($state) => is_array($state) && array_is_list($state) ? array_shift($state) : $state),

                TextInput::make('thumbnail_alt_text')
                    ->label('Thumbnail Alt Text')
                    ->placeholder('Enter alt text for the thumbnail')
                    ->required(false)
                    ->reactive()
                    ->hidden(fn($get) => !$get('thumbnail')),
            ])
            ->columns(1);
    }




    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->circular() // tampilkan sebagai lingkaran
                    ->height(40) // ukuran gambar
                    ->width(40)
                    ->disk('public'), // sesuaikan dengan direktori upload
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
                TextColumn::make('created_at')->label('Created')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }


    // Relasi jika ada (misal ArticleResource sebagai child)
    public static function getRelations(): array
    {
        return [
            // bisa ditambahkan RelationManagers untuk articles
        ];
    }

    // Halaman CRUD
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategoryArticles::route('/'),
            'create' => Pages\CreateCategoryArticle::route('/create'),
            'edit' => Pages\EditCategoryArticle::route('/{record}/edit'),
        ];
    }
}
