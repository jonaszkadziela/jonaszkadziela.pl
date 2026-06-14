<?php

namespace App\Filament\Resources\Feedbacks\Schemas;

use App\Models\Feedback;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Lang;

class FeedbackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label(Lang::get('admin.feedbacks.labels.type'))
                    ->options(collect(Feedback::SUPPORTED_TYPES)->mapWithKeys(fn (string $type) => [$type => Lang::get('admin.feedbacks.types.' . $type)]))
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('body')
                    ->label(Lang::get('admin.feedbacks.labels.body'))
                    ->required()
                    ->autosize()
                    ->columnSpanFull(),
                Textarea::make('data')
                    ->label(Lang::get('admin.feedbacks.labels.data'))
                    ->formatStateUsing(fn (?Feedback $record) => $record ? json_encode($record->data, JSON_PRETTY_PRINT) : '')
                    ->mutateDehydratedStateUsing(fn (?string $state) => json_decode($state ?? '[]', true))
                    ->json()
                    ->autosize()
                    ->columnSpanFull(),
            ]);
    }
}
