<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\CategoryArticle;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Collection;
// use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Tables\Actions\{Action, ActionGroup, EditAction, DeleteAction, BulkActionGroup, DeleteBulkAction};
use App\Filament\Resources\CategoryArticleResource\Pages;

class CategoryArticleResource extends Resource
{
    protected static ?string $model = CategoryArticle::class;

    // Navigasi
    protected static ?string $navigationGroup = 'Articles';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = null; // hapus icon
    protected static ?string $navigationLabel = 'Category Articles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make('Category Details')
                    ->description('Basic information, content, and the main description.')
                    ->schema([
                        Grid::make(2)
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
                                        FormAction::make('generateSlug')
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

                            ]),

                        FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->disk('public')
                            ->maxSize(500)
                            ->directory('cat-articles')
                            ->visibility('public')
                            ->multiple(false)
                            ->getUploadedFileNameForStorageUsing(function ($file, $get) {
                                $slug = Str::slug($get('title') ?? 'thumbnail');
                                $extension = $file->getClientOriginalExtension();
                                return $slug . '.' . $extension;
                            })
                            ->formatStateUsing(fn($state) => $state ? [$state] : [])
                            ->dehydrateStateUsing(function ($state) {
                                if (is_array($state) && !empty($state)) {
                                    return reset($state);
                                }
                                return $state;
                            }),

                        TextInput::make('thumbnail_alt_text')
                            ->label('Thumbnail Alt Text')
                            ->placeholder('Enter alt text for the thumbnail')
                            ->required(false)
                            ->reactive()
                            ->maxLength(100)
                            ->extraInputAttributes(['maxlength' => 100])
                            ->hidden(fn($get) => !$get('thumbnail')),

                        Textarea::make('description')
                            ->label('Description')
                            ->maxLength(450)
                            ->extraInputAttributes(['maxlength' => 450])
                            ->rows(3),

                    ])->columns(1)
                    ->grow(),
            ]);
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
                ActionGroup::make([
                    Action::make('preview')
                        ->label('Preview')
                        ->icon('heroicon-o-eye')
                        ->url(fn(CategoryArticle $record) => route('blog.category', [
                            'category' => $record->slug,
                        ]))
                        ->openUrlInNewTab()
                        ->visible(fn(CategoryArticle $record) => filled($record->slug))
                        ->color('info'),
                    EditAction::make(),
                    DeleteAction::make()
                        ->disabled(
                            fn(CategoryArticle $record): bool =>
                            $record->articles()->exists()
                        )
                ])
                    ->button()
                    ->label('Actions'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        // 🔥 Gunakan action() untuk memfilter record yang boleh dihapus
                        ->action(function (Collection $records) {

                            // Filter record yang tidak memiliki artikel (boleh dihapus)
                            $recordsToDelete = $records->filter(
                                fn(CategoryArticle $record) =>
                                $record->articles()->doesntExist()
                            );

                            $failedCount = $records->count() - $recordsToDelete->count();

                            if ($failedCount > 0) {
                                Notification::make()
                                    ->title('Penghapusan Sebagian Dibatalkan')
                                    ->body("{$failedCount} kategori tidak dapat dihapus karena masih memiliki artikel terkait.")
                                    ->danger()
                                    ->send();
                            }

                            // Hapus hanya record yang lolos filter
                            $recordsToDelete->each->delete();
                        }),
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
