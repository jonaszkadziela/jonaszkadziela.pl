<?php

namespace App\Filament\Resources\JsonPages\Pages;

use App\Filament\Resources\JsonPages\JsonPageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJsonPage extends EditRecord
{
    protected static string $resource = JsonPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
