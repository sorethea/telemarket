<?php

namespace App\Filament\Marketing\Resources\CustomerResource\RelationManagers;

use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReplyMessageRelationManager extends RelationManager
{
    protected static string $relationship = 'replyMessages';
    protected static ?string $title = "Sent Messages";
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MarkdownEditor::make('text')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('file'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('text')
            ->columns([
                Tables\Columns\TextColumn::make("type")
                    ->searchable(),
                Tables\Columns\TextColumn::make('text')
                    ->label(trans("market.message.content"))
                    ->searchable(),
                //Tables\Columns\TextColumn::make("file"),
                Tables\Columns\TextColumn::make("created_at")->since(),

            ])
            ->defaultSort('created_at','desc')
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
