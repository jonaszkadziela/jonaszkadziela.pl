<?php

namespace App\Filament\Resources\JsonPageResource\Pages;

use App\Filament\Resources\JsonPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJsonPage extends EditRecord
{
    protected static string $resource = JsonPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
