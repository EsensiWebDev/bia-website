<?php

namespace App\Filament\Resources\SocialActivityResource\Pages;

use App\Filament\Resources\SocialActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSocialActivities extends ListRecords
{
    protected static string $resource = SocialActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
