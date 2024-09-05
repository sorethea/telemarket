<?php

namespace App\Filament\Marketing\Resources\CustomerResource\Pages;

use App\Filament\Marketing\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
