<?php

namespace App\Filament\Resources\TreatmentResource\Pages;

use Filament\Actions;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TreatmentResource;

class CreateTreatment extends CreateRecord
{
    protected static string $resource = TreatmentResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // → /admin/articles
    }
}
