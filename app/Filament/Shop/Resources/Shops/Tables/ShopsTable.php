<?php

namespace App\Filament\Shop\Resources\Shops\Tables;

use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShopsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->icon(Heroicon::Envelope)
                    ->iconColor('primary')
                    ->url(fn($record): string => 'mailto:' . $record->email)
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                ImageColumn::make('photo')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('expire_date')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
