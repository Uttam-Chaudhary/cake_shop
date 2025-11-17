<?php

namespace App\Filament\Shop\Resources\Banners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;

class BannersTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->deferLoading()
            ->heading('Banners')
            ->description('Manage your Banners here.')
            ->columns([
                TextInputColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('url')
                    ->copyable()
                    ->copyMessage('URL address copied')
                    ->copyMessageDuration(1500)
                    ->searchable(),
                ImageColumn::make('image'),
                IconColumn::make('status')
                    ->sortable()
                    ->tooltip(fn($record) => $record->status ? 'Active' : 'Inactive')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
