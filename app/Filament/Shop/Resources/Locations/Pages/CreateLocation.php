<?php

namespace App\Filament\Shop\Resources\Locations\Pages;

use App\Filament\Shop\Resources\Locations\LocationResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateLocation extends CreateRecord
{
    protected static string $resource = LocationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['shop_id'] = Auth::guard('shop')->user()->id;
        return $data;
    }
}
