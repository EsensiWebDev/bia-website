<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticlesResource\Pages;
use App\Filament\Resources\ArticlesResource\RelationManagers;
use App\Models\Articles;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticlesResource extends Resource
{
    protected static ?string $model = Articles::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Toggle::make('is_published')
                ->label('Publish Article')
                ->onColor('success')
                ->offColor('danger')
                ->default(true)
                ->columnSpanFull()
                ->required(),
            Forms\Components\TextInput::make('author')->required(),
            Forms\Components\TextInput::make('category')->required(),
            Forms\Components\FileUpload::make('thumbnail')
                ->image()
                ->disk('public')
                ->directory('article')
                ->columnSpanFull()
                ->visibility('public')
                ->preserveFilenames()
                ->label('Thumbnail')
                ->required(),

            Forms\Components\TextInput::make('thumbnail_alt_text')
                ->label('Thumbnail Alt Text')
                ->placeholder('Enter alt text for the thumbnail')
                ->required()
                ->columnSpanFull()
                ->reactive() // Make this field reactive
                ->hidden(fn($get) => !$get('thumbnail')),

            Forms\Components\Group::make([
                Forms\Components\TextInput::make('slug')->required(),
                Forms\Components\DatePicker::make('publish_date')
                    ->default(now())
                    ->timezone('Asia/Jakarta')
                    ->required()
                    ->label('Publish Date'),
            ])
                ->columns(2),
            Forms\Components\Group::make([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\TextInput::make('meta_title'),
            ])
                ->columns(2),
            Forms\Components\Group::make([
                Forms\Components\TextInput::make('meta_description'),
                Forms\Components\TextInput::make('meta_keywords'),
            ])
                ->columns(2),

            Forms\Components\RichEditor::make('content')->required(),

        ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('publish_date')->sortable()->searchable(),

                Tables\Columns\IconColumn::make('is_published')
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
