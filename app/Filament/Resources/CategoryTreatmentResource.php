<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Models\CategoryTreatment;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
// use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Tables\Actions\{Action, ActionGroup, EditAction, DeleteAction, BulkActionGroup, DeleteBulkAction};
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryTreatmentResource\Pages;
use App\Filament\Resources\CategoryTreatmentResource\RelationManagers;

class CategoryTreatmentResource extends Resource
{
    protected static ?string $model = CategoryTreatment::class;
    protected static ?string $navigationGroup = 'Treatments';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = null; // hapus icon
    protected static ?string $navigationLabel = 'Category Treatments';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make('Treatment Details')
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
                            ->directory('cat-treatments')
                            ->visibility('public')
                            ->maxSize(500) // max 500 KB
                            ->multiple(false)
                            ->getUploadedFileNameForStorageUsing(function ($file, $get) {
                                // Menggunakan slug dari field 'title'
                                $slug = Str::slug($get('title') ?? 'thumbnail');
                                $extension = $file->getClientOriginalExtension();
                                return $slug . '.' . $extension;
                            })
                            ->formatStateUsing(fn($state) => $state ? [$state] : [])
                            ->dehydrateStateUsing(fn($state) => is_array($state) && array_is_list($state) ? array_shift($state) : $state),

                        RichEditor::make('desc')
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'codeBlock',
                                'italic',
                                'link',
                                'underline',
                                'undo',
                                'redo',
                            ])
                            ->label('Description')
                            ->maxLength(450)
                            ->extraInputAttributes(['maxlength' => 450])
                            ->required()
                            ->columnSpanFull(),


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
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
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
                    Action::make('preview')
                        ->label('Preview')
                        ->icon('heroicon-o-eye')
                        ->url(fn(CategoryTreatment $record) => route('treatments.treatments', [
                            'category' => $record->slug,
                        ]))
                        ->openUrlInNewTab()
                        ->visible(fn(CategoryTreatment $record) => filled($record->slug))
                        ->color('info'),
                    EditAction::make(),
                    DeleteAction::make()
                        ->disabled(
                            fn(CategoryTreatment $record): bool =>
                            $record->treatments()->exists()
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
                                fn(CategoryTreatment $record) =>
                                $record->treatments()->doesntExist()
                            );

                            $failedCount = $records->count() - $recordsToDelete->count();

                            if ($failedCount > 0) {
                                Notification::make()
                                    ->title('Penghapusan Sebagian Dibatalkan')
                                    ->body("{$failedCount} kategori tidak dapat dihapus karena masih memiliki treatment terkait.")
                                    ->danger()
                                    ->send();
                            }

                            // Hapus hanya record yang lolos filter
                            $recordsToDelete->each->delete();
                        }),
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
            'index' => Pages\ListCategoryTreatments::route('/'),
            'create' => Pages\CreateCategoryTreatment::route('/create'),
            'edit' => Pages\EditCategoryTreatment::route('/{record}/edit'),
        ];
    }
}
