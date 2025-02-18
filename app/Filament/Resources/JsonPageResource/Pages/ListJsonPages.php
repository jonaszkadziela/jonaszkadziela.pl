<?php

namespace App\Filament\Resources\JsonPageResource\Pages;

use App\Filament\Resources\JsonPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJsonPages extends ListRecords
{
    protected static string $resource = JsonPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
