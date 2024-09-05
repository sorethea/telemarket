<?php

namespace App\Filament\Marketing\Resources\CustomerResource\Pages;

use App\Filament\Marketing\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;
}
