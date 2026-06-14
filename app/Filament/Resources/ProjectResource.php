<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages\CreateProject;
use App\Filament\Resources\ProjectResource\Pages\EditProject;
use App\Filament\Resources\ProjectResource\Pages\ListProjects;
use App\Filament\Resources\ProjectResource\RelationManagers\FilesRelationManager;
use App\Filament\Resources\ProjectResource\RelationManagers\TagsRelationManager;
use App\Models\Project;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Lang;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Schema $schema): Schema
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->label(Lang::get('admin.projects.labels.slug'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('title')
                    ->label(Lang::get('admin.projects.labels.title'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('body')
                    ->label(Lang::get('admin.projects.labels.body'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('link')
                    ->label(Lang::get('admin.projects.labels.link'))
                    ->limit(40)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('is_pro_bono')
                    ->label(Lang::get('admin.projects.labels.is_pro_bono'))
                    ->sortable()
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('started_at')
                    ->label(Lang::get('admin.projects.labels.started_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('finished_at')
                    ->label(Lang::get('admin.projects.labels.finished_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.projects.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.projects.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_pro_bono')
                    ->label(Lang::get('admin.projects.labels.is_pro_bono')),
                SelectFilter::make('finished_at')
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            FilesRelationManager::class,
            TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
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
