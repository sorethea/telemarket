<?php

namespace App\Filament\Clinic\Resources;

use App\Filament\Clinic\Resources\PatientResource\Pages;
use App\Filament\Clinic\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use App\Options\BloodGroup;
use App\Options\Gender;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make("patient")
                    ->tabs([
                        Forms\Components\Tabs\Tab::make("general")
                            ->label(trans("clinic/patient.general"))
                            ->schema([

                                Forms\Components\TextInput::make('first_name')
                                    ->required(),
                                Forms\Components\TextInput::make('last_name')
                                    ->required(),
                                Forms\Components\TextInput::make('phone_number')
                                    ->tel()
                                    ->required(),
                                Forms\Components\DatePicker::make('date_of_birth')
                                    ->required(),
                                Forms\Components\Select::make('gender')
                                    ->options(Gender::class)
                                    ->required(),
                                Forms\Components\Select::make('blood_group')
                                    ->options(BloodGroup::class)
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->email(),
                                Forms\Components\TextInput::make('address'),
                                Forms\Components\TextInput::make('city'),
                                Forms\Components\TextInput::make('country'),

                            ])->columns(2),
                        Forms\Components\Tabs\tab::make('personal_history')
                            ->label(trans("clinic/patient.personal_history")),
                        Forms\Components\Tabs\tab::make('medical_history')
                            ->label(trans("clinic/patient.medical_history")),
                        Forms\Components\Tabs\tab::make('other')
                            ->label(trans("clinic/patient.other")),
                    ])->activeTab(1),


            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('blood_group')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
