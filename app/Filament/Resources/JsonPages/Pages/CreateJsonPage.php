<?php

namespace App\Filament\Resources\JsonPages\Pages;

use App\Filament\Resources\JsonPages\JsonPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJsonPage extends CreateRecord
{
    protected static string $resource = JsonPageResource::class;
}
