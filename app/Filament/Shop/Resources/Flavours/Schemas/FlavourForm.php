<?php

namespace App\Filament\Shop\Resources\Flavours\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FlavourForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('names')
                    ->required(),
            ]);
    }
}
