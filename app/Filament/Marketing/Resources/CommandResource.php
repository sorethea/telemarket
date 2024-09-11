<?php

namespace App\Filament\Marketing\Resources;

use App\Filament\Marketing\Resources\CommandResource\Pages;
use App\Filament\Marketing\Resources\CommandResource\RelationManagers;
use App\Models\Command;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Novadaemon\FilamentPrettyJson\PrettyJson;
use PepperFM\FilamentJson\Columns\JsonColumn;

class CommandResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Command::class;

    protected static ?string $navigationIcon = 'heroicon-o-command-line';

    public static function getNavigationGroup(): string
    {
        return trans('market.nav.group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make("name")
                        ->label(trans('market.command.name'))
                        ->required(),
                    Forms\Components\TextInput::make("bot")
                        ->label(trans('market.command.bot'))
                        ->required(),
                    Forms\Components\MarkdownEditor::make('text')
                        ->label(trans('market.command.text'))
                        ->required(fn($get)=>!$get('photos')),
                    Forms\Components\FileUpload::make('photos')
                        ->label(trans('market.command.photos'))
                        ->multiple()
                        ->image()
                        ->required(fn($get)=>!$get('text')),
                    PrettyJson::make("reply_markup")
                        ->label(trans("market.command.reply_markup"))
                        ->nullable(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        $buttonConfig = [
            'color' => 'warning',
            'size' => 'xs',
        ];
        $modalConfig = literal(
            icon: 'heroicon-m-sparkles',
            alignment: 'start',
            width: 'xl',
            closedButton: false,
        );
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('market.command.name'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('text')
                    ->label(trans('market.command.text'))
                    ->tooltip(fn($state)=>$state)
                    ->icon(fn($state)=>$state?'heroicon-o-document-text':''),
                JsonColumn::make("reply_markup")
                    ->button($buttonConfig)
                    ->modal($modalConfig),
                Tables\Columns\ImageColumn::make('photos')
                    ->label(trans('market.telegram.photos'))
                    ->circular()
                    ->stacked(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListCommands::route('/'),
            'create' => Pages\CreateCommand::route('/create'),
            'view' => Pages\ViewCommand::route('/{record}'),
            'edit' => Pages\EditCommand::route('/{record}/edit'),
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
