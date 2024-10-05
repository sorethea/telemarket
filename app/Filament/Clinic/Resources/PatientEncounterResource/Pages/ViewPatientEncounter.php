<?php

namespace App\Filament\Clinic\Resources\PatientEncounterResource\Pages;

use App\Filament\Clinic\Resources\PatientEncounterResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPatientEncounter extends ViewRecord
{
    protected static string $resource = PatientEncounterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
