<?php

namespace App\Filament\Clinic\Resources\PatientEncounterResource\Pages;

use App\Filament\Clinic\Resources\PatientEncounterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatientEncounter extends EditRecord
{
    protected static string $resource = PatientEncounterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
