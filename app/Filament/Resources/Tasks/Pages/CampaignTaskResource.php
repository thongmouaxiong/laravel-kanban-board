<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Enums\TaskStatus;
use App\Filament\Resources\Tasks\TaskResource;
use App\Models\Task;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Schema;
use Filament\Tables\Filters\SelectFilter;
use Relaticle\Flowforge\Board;
use Relaticle\Flowforge\BoardResourcePage;
use Relaticle\Flowforge\Column;
use Relaticle\Flowforge\Components\CardFlex;

class CampaignTaskResource extends BoardResourcePage
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->schema([
                    TextInput::make('title')
                        ->label('Title')
                        ->required(),
                    Select::make('status')
                        ->label('Status')
                        ->required()
                        ->options(TaskStatus::options()),
                ])
                ->model(Task::class),
        ];
    }

    public function board(Board $board): Board
    {
        return $board
            ->query(
                Task::query()
            )
            ->searchable(['title'])
            ->filters([
                SelectFilter::make('priority')->options([]),
            ])
            ->columnIdentifier('status')
            ->positionIdentifier('position')
            // ->collapseEmptyColumns()
            ->pluralCardLabel('Tasks eiei')   // -> "No Tasks in this column" (change to whatever noun you want)
            ->cardLabel('Task')
            ->cardsPerColumn(50)
            ->columns([
                Column::make('todo')->label('Todo')->color('gray'),
                Column::make('in_progress')->label('In Progress')->color('blue'),
                Column::make('done')->label('Completed')->color('green'),
                Column::make('block')->label('Blocked')->color('red'),
                Column::make('reject')->label('Rejected')->color('red'),
            ])
            ->cardSchema(fn(Schema $schema) => $schema->components([
                ViewEntry::make('card')
                    ->view('components.task-card')
                    ->viewData([]), // record is available via $getRecord() automatically
            ]))
            // ->cardSchema(fn(Schema $schema) => $schema->components([
            //     TextEntry::make('priority')->badge()->color(fn($state) => match ($state) {
            //         'high' => 'danger',
            //         'medium' => 'warning',
            //         'low' => 'success',
            //         default => 'gray'
            //     }),
            //     TextEntry::make('due_date')->date()->icon('heroicon-o-calendar'),
            //     TextEntry::make('status')->icon('heroicon-o-user'),

            //     CardFlex::make([
            //         TextEntry::make('priority')->badge(),
            //         TextEntry::make('due_date')->icon('heroicon-o-calendar'),
            //         TextEntry::make('status')->icon('heroicon-o-user'),
            //     ])
            //         ->wrap()
            //         ->justify('between')
            //         ->align('center'),

            //     ViewEntry::make('assignee')
            //         ->view('components.task-assignee'),
            // ]))
            ->columnActions([])
            ->cardActions([
                EditAction::make()->model(Task::class),
                DeleteAction::make()->model(Task::class),
            ])
            ->cardAction('edit');
    }
}
