<?php

namespace App\Filament\Marketing\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('chat_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    protected function applyDefaultSortingToTableQuery(Builder $query): Builder
    {
        return $query->latest('created_at');
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('chat_id')
            ->columns([
                Tables\Columns\TextColumn::make("message_type")
                    ->label(trans('general.type'))
                    ->formatStateUsing(fn($state)=>Str::ucfirst($state))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('text')
                    ->getStateUsing(function ($record){
                        if(empty($record->text)){
                            return $record->file_name??$record->file;
                        }
                        return $record->text;
                    })
                    ->hidden(fn($state)=>empty($state))
                    ->limit(35)
                    ->icon('heroicon-o-question-mark-circle')
                    ->iconPosition('after')
                    ->tooltip(fn($state)=>$state),
//                Tables\Columns\ImageColumn::make('file'),
//                Tables\Columns\ImageColumn::make('file_type'),
//                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('created_at')->since(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                //Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
