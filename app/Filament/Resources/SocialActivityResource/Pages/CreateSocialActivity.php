<?php

namespace App\Filament\Resources\SocialActivityResource\Pages;

use App\Filament\Resources\SocialActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSocialActivity extends CreateRecord
{
    protected static string $resource = SocialActivityResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // → /admin/articles
    }
}
