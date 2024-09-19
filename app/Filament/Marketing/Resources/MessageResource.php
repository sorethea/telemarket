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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
                Forms\Components\TextInput::make('customer_name')
                    ->label(trans('market.message.from')),
                Forms\Components\RichEditor::make("text")
                    ->label(trans('market.message.text')),
                Forms\Components\FileUpload::make("file")
                    ->disk("public")
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("id")
                    ->label(trans('general.id'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label(trans('market.message.name'))
                    ->searchable(),
//                Tables\Columns\TextColumn::make("type")
//                    ->label(trans('general.type'))
//                    ->searchable()
//                    ->sortable(),
                Tables\Columns\TextColumn::make("message_type")
                    ->label(trans('general.type'))
                    ->formatStateUsing(fn($state)=>Str::ucfirst($state))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("text")
                    ->label(trans('market.message.content'))
                    ->getStateUsing(function ($record){
                        if(empty($record->text)){
                            return $record->file_name??$record->file;
                        }
                        return $record->text;
                    })
                    ->limit(35)
                    ->icon('heroicon-o-question-mark-circle')
                    ->iconPosition('after')
                    ->tooltip(fn($state)=>$state),
//                Tables\Columns\IconColumn::make('message.reply_to_message.text')
//                    ->toggleable()
//                    ->label(trans('market.message.reply_to'))
//                    ->icon('heroicon-o-question-mark-circle')
//                    ->iconPosition('after')
//                    ->tooltip(fn($state)=>$state),
                Tables\Columns\TextColumn::make("created_at")
                    ->toggleable()
                    ->label(trans('general.created_at'))
                    ->since()
                    ->sortable(),
            ])
            ->poll('10s')
            ->defaultSort('created_at', 'desc')
            ->filters([
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make("reply")
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->form([
                            Forms\Components\RichEditor::make('text')
                                ->required(),
                        ]),
                ]),

                //Tables\Actions\EditAction::make(),
//                \Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction::make('media')
//                    ->visible(fn($record):bool=>$record->is_media)
//                    ->media(fn($record)=>Storage::url($record->file))
//                    ->icon('heroicon-o-eye'),
//                Tables\Actions\Action::make("download")
//                    ->visible(fn($record):bool=>$record->is_download)
//                    ->url(fn($record):string=>Storage::url($record->file))
//                    ->openUrlInNewTab()
//                    ->icon('heroicon-o-arrow-down-tray'),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
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
            //'view' => Pages\ViewMessage::route('/{record}'),
//            'create' => Pages\CreateMessage::route('/create'),
            //'edit' => Pages\EditMessage::route('/{record}/edit'),
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
