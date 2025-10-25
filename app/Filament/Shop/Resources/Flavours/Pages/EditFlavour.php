<?php

namespace App\Filament\Shop\Resources\Flavours\Pages;

use App\Filament\Shop\Resources\Flavours\FlavourResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFlavour extends EditRecord
{
    protected static string $resource = FlavourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
