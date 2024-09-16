<?php

namespace App\Filament\Marketing\Resources;

use App\Filament\Marketing\Resources\MessageResource\Pages;
use App\Filament\Marketing\Resources\MessageResource\RelationManagers;
use App\Models\Customer;
use App\Models\Message;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class MessageResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'gmdi-mail';


    public static function getNavigationGroup(): string
    {
        return trans('market.nav.group');
    }

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

                Tables\Columns\TextColumn::make('customer.name')
                    ->label(trans('market.message.from'))
                    ->searchable(),
                Tables\Columns\TextColumn::make("type")
                    ->label(trans('general.type'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("bot")
                    ->label(trans('general.bot'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make("text")
                    ->label(trans('general.text'))
                    ->icon(function($state):string{
                        $icon = 'heroicon-o-envelope';
                        if(empty($state)) $icon = 'heroicon-o-x-mark';
                        return $icon;
                    })
                    ->tooltip(fn($state)=>$state),
                Tables\Columns\IconColumn::make('reply_to_text')
                    ->label(trans('market.message.reply_to'))
                    ->icon(fn($state):string=>$state?'heroicon-o-envelope':'heroicon-o-x-mark')
                    ->tooltip(fn($state)=>$state),
                Tables\Columns\TextColumn::make("created_at")
                    ->toggleable()
                    ->label(trans('general.created_at'))
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('from')
                    ->relationship('customer','first_name')
                    ->getSearchResultsUsing(function ( string $search):array{
                        return Customer::query()->orWhere("first_name","like","%{$search}%")
                            ->orWhere("last_name","like","%{$search}%")
                            ->limit(50)->pluck('first_name','id')->toArray();
                    })
                    ->searchable(),
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
