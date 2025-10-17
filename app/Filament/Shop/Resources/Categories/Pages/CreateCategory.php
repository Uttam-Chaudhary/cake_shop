<?php

namespace App\Filament\Shop\Resources\Categories\Pages;

use App\Filament\Shop\Resources\Categories\CategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;


     protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['shop_id'] = Auth::guard('shop')->user()->id;
        return $data;
    }
}
