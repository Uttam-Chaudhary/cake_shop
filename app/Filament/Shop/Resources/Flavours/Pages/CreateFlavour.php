<?php

namespace App\Filament\Shop\Resources\Flavours\Pages;

use App\Filament\Shop\Resources\Flavours\FlavourResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateFlavour extends CreateRecord
{
    protected static string $resource = FlavourResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['shop_id'] = Auth::guard('shop')->user()->id;
        return $data;
    }
}
