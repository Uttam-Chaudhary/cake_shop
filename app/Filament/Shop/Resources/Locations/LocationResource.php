<?php

namespace App\Filament\Shop\Resources\Locations;

use App\Filament\Shop\Resources\Locations\Pages\CreateLocation;
use App\Filament\Shop\Resources\Locations\Pages\EditLocation;
use App\Filament\Shop\Resources\Locations\Pages\ListLocations;
use App\Filament\Shop\Resources\Locations\Schemas\LocationForm;
use App\Filament\Shop\Resources\Locations\Tables\LocationsTable;
use App\Models\Location;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'city';

    public static function getEloquentQuery(): Builder
    {
        return Location::where('shop_id', Auth::guard('shop')->user()->id);
    }

    public static function form(Schema $schema): Schema
    {
        return LocationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LocationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLocations::route('/'),
            'create' => CreateLocation::route('/create'),
            'edit' => EditLocation::route('/{record}/edit'),
        ];
    }
}
