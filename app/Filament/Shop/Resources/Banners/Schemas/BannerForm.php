<?php

namespace App\Filament\Shop\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('url')
                    ->url()
                    ->required(),
                FileUpload::make('image')
                    ->image()
                    ->required(),
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
