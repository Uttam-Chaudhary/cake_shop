<?php

namespace App\Filament\Shop\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'title')
                    ->required(),
                Select::make('flavours')
                    ->multiple()                     // allows multiple selections
                    ->relationship('flavours', 'names')
                    ->label('Flavours')
                    ->preload(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rs'),
                TextInput::make('discount_percentage')
                    ->required()
                    ->numeric()
                    ->suffix('%')
                    ->default(0),
                TextInput::make('note'),
                Repeater::make('weights')
                    ->label('Weights (pounds)')
                    ->schema([
                        TextInput::make('weight')
                            ->numeric()
                            ->required(),
                    ])
                    ->columns(1)
                    ->addActionLabel('Add weight')
                    ->minItems(1),
                RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('images')
                    ->required()
                    ->multiple(),
            ]);
    }
}
