<?php

namespace App\Filament\Marketing\Resources;

use App\Filament\Marketing\Resources\TelegramResource\Pages;
use App\Filament\Marketing\Resources\TelegramResource\RelationManagers;
use App\Http\Controllers\TelegramController;
use App\Models\Customer;
use App\Models\Telegram;
use App\Options\Status;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TelegramResource extends Resource implements HasShieldPermissions
{
    use \App\Traits\Telegram;

    protected static ?string $model = Telegram::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function getNavigationGroup(): string
    {
        return trans('market.nav.group');
    }


    public static function form(Form $form): Form
    {
        $customers = Customer::select(DB::raw("CASE WHEN phone_number IS NULL THEN id ELSE phone_number END AS label"),'id')
            ->where('bot',Auth::user()->bot)->pluck('label','id');
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make("title")
                        ->label(trans('market.telegram.title'))
                        ->required(),
                Forms\Components\Select::make("status")
                    ->label(trans('market.telegram.status.title'))
                    ->options(Status::class)
                    ->default('draft')
                    ->required(),

                    Forms\Components\MarkdownEditor::make('content')
                        ->label(trans('market.telegram.content'))
                        ->required(fn($get)=>!$get('photos')),
                    Forms\Components\FileUpload::make('photos')
                        ->label(trans('market.telegram.photos'))
                        ->multiple()
                        ->image()
                        ->required(fn($get)=>!$get('content')),
                    Forms\Components\Select::make("send_to")
                        ->label(trans('market.telegram.send_to'))
                        ->options($customers)
                        ->multiple()
                        ->required(),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(trans('market.telegram.title'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('content')
                    ->label(trans('market.telegram.content'))
                    ->tooltip(fn($state)=>$state)
                    ->icon(fn($state)=>$state?'heroicon-o-document-text':''),
                Tables\Columns\ImageColumn::make('photos')
                    ->label(trans('market.telegram.photos'))
                    ->circular()
                    ->stacked(),

                Tables\Columns\TextColumn::make('status')
                    ->label(trans('market.telegram.status.title'))
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('send_to')
                    ->label(trans('market.telegram.send_to')),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\Action::make("send")
                    ->icon('heroicon-o-paper-airplane')
                    //->visible(fn ($record):bool=>$record->status==='draft')
                    ->label(trans("market.telegram.send"))
                    ->action(fn($record)=>static::sendAction($record)),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListTelegrams::route('/'),
            'create' => Pages\CreateTelegram::route('/create'),
            'view' => Pages\ViewTelegram::route('/{record}'),
            'edit' => Pages\EditTelegram::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
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

    public static function sendAction(Telegram $telegram):void{
        static::sendToTelegram($telegram);
    }
}
