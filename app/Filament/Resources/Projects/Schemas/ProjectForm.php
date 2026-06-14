<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Lang;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(Lang::get('admin.projects.labels.title'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label(Lang::get('admin.projects.labels.slug'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('link')
                    ->label(Lang::get('admin.projects.labels.link'))
                    ->maxLength(255)
                    ->default(null)
                    ->url()
                    ->columnSpanFull(),
                DateTimePicker::make('started_at')
                    ->label(Lang::get('admin.projects.labels.started_at'))
                    ->required(),
                DateTimePicker::make('finished_at')
                    ->label(Lang::get('admin.projects.labels.finished_at')),
                Textarea::make('body')
                    ->label(Lang::get('admin.projects.labels.body'))
                    ->autosize()
                    ->columnSpanFull(),
                Textarea::make('translations')
                    ->label(Lang::get('admin.projects.labels.translations'))
                    ->formatStateUsing(fn (?Project $record) => $record ? json_encode($record->translations, JSON_PRETTY_PRINT) : '')
                    ->mutateDehydratedStateUsing(fn (?string $state) => json_decode($state ?? '[]', true))
                    ->json()
                    ->autosize()
                    ->columnSpanFull(),
                Toggle::make('is_pro_bono')
                    ->label(Lang::get('admin.projects.labels.is_pro_bono'))
                    ->required(),
            ]);
    }
}
