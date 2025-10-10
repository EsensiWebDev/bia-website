<?php

namespace App\Filament\Resources\CategoryArticleResource\Pages;

use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CategoryArticleResource;

class EditCategoryArticle extends EditRecord
{
    protected static string $resource = CategoryArticleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // → /admin/category-articles
    }
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->disabled(fn($record) => $record->articles()->exists())
                ->before(function ($record) {
                    if ($record->thumbnail && Storage::disk('public')->exists($record->thumbnail)) {
                        Storage::disk('public')->delete($record->thumbnail);
                    }
                }),
        ];
    }
}
