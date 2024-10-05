<?php

namespace App\Filament\Clinic\Resources\PatientEncounterResource\Pages;

use App\Filament\Clinic\Resources\PatientEncounterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatientEncounters extends ListRecords
{
    protected static string $resource = PatientEncounterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
