<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Lang;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(Lang::get('admin.projects.labels.title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label(Lang::get('admin.projects.labels.slug'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('link')
                    ->label(Lang::get('admin.projects.labels.link'))
                    ->maxLength(255)
                    ->default(null)
                    ->url()
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('started_at')
                    ->label(Lang::get('admin.projects.labels.started_at'))
                    ->required(),
                Forms\Components\DateTimePicker::make('finished_at')
                    ->label(Lang::get('admin.projects.labels.finished_at')),
                Forms\Components\Textarea::make('body')
                    ->label(Lang::get('admin.projects.labels.body'))
                    ->autosize()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('translations')
                    ->label(Lang::get('admin.projects.labels.translations'))
                    ->formatStateUsing(fn (?Project $record) => $record ? json_encode($record->translations, JSON_PRETTY_PRINT) : '')
                    ->mutateDehydratedStateUsing(fn (string $state) => json_decode($state, true))
                    ->json()
                    ->autosize()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_pro_bono')
                    ->label(Lang::get('admin.projects.labels.is_pro_bono'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->label(Lang::get('admin.projects.labels.slug'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(Lang::get('admin.projects.labels.title'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('body')
                    ->label(Lang::get('admin.projects.labels.body'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('link')
                    ->label(Lang::get('admin.projects.labels.link'))
                    ->limit(40)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_pro_bono')
                    ->label(Lang::get('admin.projects.labels.is_pro_bono'))
                    ->sortable()
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('started_at')
                    ->label(Lang::get('admin.projects.labels.started_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('finished_at')
                    ->label(Lang::get('admin.projects.labels.finished_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(Lang::get('admin.projects.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(Lang::get('admin.projects.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_pro_bono')
                    ->label(Lang::get('admin.projects.labels.is_pro_bono')),
                Tables\Filters\SelectFilter::make('finished_at')
                    ->label(Lang::get('admin.projects.labels.finished_at'))
                    ->options([
                        'only_finished' => Lang::get('admin.projects.labels.only_finished'),
                        'only_unfinished' => Lang::get('admin.projects.labels.only_unfinished'),
                    ])
                    ->modifyQueryUsing(fn (Builder $query, array $state) => match ($state['value']) {
                        'only_finished' => $query->whereNotNull('finished_at'),
                        'only_unfinished' => $query->whereNull('finished_at'),
                        default => $query,
                    }),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return Lang::get('admin.projects.model');
    }

    public static function getPluralModelLabel(): string
    {
        return Lang::get('admin.projects.models');
    }
}
