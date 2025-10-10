<?php

namespace App\Filament\Resources\CategoryTreatmentResource\Pages;

use App\Filament\Resources\CategoryTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryTreatments extends ListRecords
{
    protected static string $resource = CategoryTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
