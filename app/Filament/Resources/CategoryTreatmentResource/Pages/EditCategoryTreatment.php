<?php

namespace App\Filament\Resources\CategoryTreatmentResource\Pages;

use App\Filament\Resources\CategoryTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Storage;

class EditCategoryTreatment extends EditRecord
{
    protected static string $resource = CategoryTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->disabled(fn($record) => $record->treatments()->exists())
                ->before(function ($record) {
                    if ($record->thumbnail && Storage::disk('public')->exists($record->thumbnail)) {
                        Storage::disk('public')->delete($record->thumbnail);
                    }
                }),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // → /admin/articles
    }
}
