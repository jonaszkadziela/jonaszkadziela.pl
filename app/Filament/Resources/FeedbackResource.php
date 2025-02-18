<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackResource\Pages;
use App\Models\Feedback;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label(Lang::get('admin.feedbacks.labels.type'))
                    ->options(collect(Feedback::SUPPORTED_TYPES)->mapWithKeys(fn (string $type) => [$type => Lang::get('admin.feedbacks.types.' . $type)]))
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('body')
                    ->label(Lang::get('admin.feedbacks.labels.body'))
                    ->required()
                    ->autosize()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('data')
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
                Tables\Columns\TextColumn::make('type')
                    ->label(Lang::get('admin.feedbacks.labels.type'))
                    ->sortable()
                    ->formatStateUsing(fn (string $state) => Lang::get('admin.feedbacks.types.' . $state))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('body')
                    ->label(Lang::get('admin.feedbacks.labels.body'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(Lang::get('admin.feedbacks.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(Lang::get('admin.feedbacks.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label(Lang::get('admin.feedbacks.labels.type'))
                    ->options(collect(Feedback::SUPPORTED_TYPES)->mapWithKeys(fn (string $type) => [$type => Lang::get('admin.feedbacks.types.' . $type)]))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeedback::route('/'),
            'create' => Pages\CreateFeedback::route('/create'),
            'edit' => Pages\EditFeedback::route('/{record}/edit'),
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
