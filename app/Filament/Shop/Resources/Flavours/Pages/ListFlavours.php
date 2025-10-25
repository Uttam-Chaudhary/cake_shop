<?php

namespace App\Filament\Shop\Resources\Flavours\Pages;

use App\Filament\Shop\Resources\Flavours\FlavourResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFlavours extends ListRecords
{
    protected static string $resource = FlavourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
