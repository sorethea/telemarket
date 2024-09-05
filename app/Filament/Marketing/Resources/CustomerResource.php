<?php

namespace App\Filament\Marketing\Resources;

use App\Filament\Marketing\Resources\CustomerResource\Pages;
use App\Filament\Marketing\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'gmdi-face';

    public static function getNavigationGroup(): string
    {
        return trans('market.nav.group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make("id")
                        ->label(trans('market.customer.channel_id'))
                        ->required(),
                    Forms\Components\TextInput::make("channel")
                        ->label(trans('market.customer.channel'))
                        ->required(),
                    Forms\Components\TextInput::make("first_name")
                        ->label(trans('market.customer.first_name'))
                        ->required(),
                    Forms\Components\TextInput::make("last_name")
                        ->label(trans('market.customer.last_name'))
                        ->required(),
                    Forms\Components\TextInput::make("phone_number")
                        ->label(trans('market.customer.phone_number'))
                        ->required(),
                    Forms\Components\Toggle::make("is_subscribed")
                        ->label(trans('market.customer.is_subscribed')),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("id")
                    ->label(trans('market.customer.channel_id'))
                    ->searchable(),
                Tables\Columns\TextColumn::make("channel")
                    ->label(trans('market.customer.channel'))
                    ->searchable(),
                Tables\Columns\TextColumn::make("first_name")
                    ->label(trans('market.customer.first_name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make("last_name")
                    ->label(trans('market.customer.last_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make("phone_number")
                    ->label(trans('market.customer.phone_number'))
                    ->searchable(),
                Tables\Columns\IconColumn::make("is_subscribed")
                    ->label(trans('market.customer.is_subscribed'))
                    ->boolean(),
                Tables\Columns\TextColumn::make("created_at")
                    ->label(trans('general.created_at'))
                    ->sortable('desc')
                    ->since()
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\MessagesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
            'view' => Pages\ViewCustomer::route('/{record}'),
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
