<?php

namespace App\Filament\Marketing\Resources;

use App\Filament\Marketing\Resources\MessageResource\Pages;
use App\Filament\Marketing\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MessageResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'gmdi-mail';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("id")
                    ->label(trans('general.id'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("type")
                    ->label(trans('general.type'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("bot")
                    ->label(trans('general.bot'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("text")
                    ->label(trans('general.text'))
                    ->limit(50)
                    ->tooltip(fn($stage)=>$stage)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make("created_at")
                    ->label(trans('general.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }
}
