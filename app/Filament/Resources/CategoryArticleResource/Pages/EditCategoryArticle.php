<?php

namespace App\Filament\Resources\CategoryArticleResource\Pages;

use App\Filament\Resources\CategoryArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditCategoryArticle extends EditRecord
{
    protected static string $resource = CategoryArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function ($record) {
                    if ($record->thumbnail && Storage::disk('public')->exists($record->thumbnail)) {
                        Storage::disk('public')->delete($record->thumbnail);
                    }
                }),
        ];
    }
}
