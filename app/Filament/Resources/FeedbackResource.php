<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackResource\Pages\CreateFeedback;
use App\Filament\Resources\FeedbackResource\Pages\EditFeedback;
use App\Filament\Resources\FeedbackResource\Pages\ListFeedback;
use App\Models\Feedback;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    public static function form(Schema $schema): Schema
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

    public static function table(Table $table): Table
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

    public static function getPages(): array
    {
        return [
            'index' => ListFeedback::route('/'),
            'create' => CreateFeedback::route('/create'),
            'edit' => EditFeedback::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return Lang::get('admin.feedbacks.model');
    }

    public static function getPluralModelLabel(): string
    {
        return Lang::get('admin.feedbacks.models');
    }
}
