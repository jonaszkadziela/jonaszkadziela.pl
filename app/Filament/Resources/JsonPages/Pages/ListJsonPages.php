<?php

namespace App\Filament\Resources\JsonPages\Pages;

use App\Filament\Resources\JsonPages\JsonPageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJsonPages extends ListRecords
{
    protected static string $resource = JsonPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
