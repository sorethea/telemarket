<?php

namespace App\Filament\Clinic\Resources;

use App\Filament\Clinic\Resources\PatientEncounterResource\Pages;
use App\Filament\Clinic\Resources\PatientEncounterResource\RelationManagers;
use App\Models\PatientEncounter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientEncounterResource extends Resource
{
    protected static ?string $model = PatientEncounter::class;

    protected static ?string $navigationIcon = 'healthicons-o-stethoscope';

    public static function getNavigationLabel(): string
    {
        return trans("clinic/patient.patient_encounters");
    }

    public static function getLabel(): ?string
    {
        return trans("clinic/patient.patient_encounters");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\Select::make('patient_id')
                        ->relationship('patient', 'id')
                        ->required(),
                    Forms\Components\Select::make('provider_id')
                        ->relationship('provider', 'id')
                        ->required(),
                    Forms\Components\DateTimePicker::make('encounter_date')
                        ->required(),
                    Forms\Components\Textarea::make('symptoms')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('diagnosis')
                        ->columnSpanFull(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('provider.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('encounter_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPatientEncounters::route('/'),
            'create' => Pages\CreatePatientEncounter::route('/create'),
            'view' => Pages\ViewPatientEncounter::route('/{record}'),
            'edit' => Pages\EditPatientEncounter::route('/{record}/edit'),
        ];
    }
}
