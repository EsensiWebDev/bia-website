<?php

namespace App\Filament\Resources\SocialActivityResource\Pages;

use App\Filament\Resources\SocialActivityResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Storage;

class EditSocialActivity extends EditRecord
{
    protected static string $resource = SocialActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // → /admin/articles
    }
}
