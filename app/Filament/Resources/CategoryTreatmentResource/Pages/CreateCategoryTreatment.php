<?php

namespace App\Filament\Resources\CategoryTreatmentResource\Pages;

use App\Filament\Resources\CategoryTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryTreatment extends CreateRecord
{
    protected static string $resource = CategoryTreatmentResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // → /admin/articles
    }
}
