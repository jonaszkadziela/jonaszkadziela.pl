<?php

namespace App\Filament\Resources\Feedbacks\Tables;

use App\Models\Feedback;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;

class FeedbackTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label(Lang::get('admin.feedbacks.labels.type'))
                    ->sortable()
                    ->formatStateUsing(fn (string $state) => Lang::get('admin.feedbacks.types.' . $state))
                    ->toggleable(),
                TextColumn::make('body')
                    ->label(Lang::get('admin.feedbacks.labels.body'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.feedbacks.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.feedbacks.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label(Lang::get('admin.feedbacks.labels.type'))
                    ->options(collect(Feedback::SUPPORTED_TYPES)->mapWithKeys(fn (string $type) => [$type => Lang::get('admin.feedbacks.types.' . $type)]))
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
