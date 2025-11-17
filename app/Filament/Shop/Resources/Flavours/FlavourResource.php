<?php

namespace App\Filament\Shop\Resources\Flavours;

use App\Filament\Shop\Resources\Flavours\Pages\CreateFlavour;
use App\Filament\Shop\Resources\Flavours\Pages\EditFlavour;
use App\Filament\Shop\Resources\Flavours\Pages\ListFlavours;
use App\Filament\Shop\Resources\Flavours\Schemas\FlavourForm;
use App\Filament\Shop\Resources\Flavours\Tables\FlavoursTable;
use App\Models\Flavour;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class FlavourResource extends Resource
{
    protected static ?string $model = Flavour::class;
    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return Flavour::where('shop_id', Auth::guard('shop')->user()->id);
    }

    public static function form(Schema $schema): Schema
    {
        return FlavourForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FlavoursTable::configure($table);
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
            'index' => ListFlavours::route('/'),
            'create' => CreateFlavour::route('/create'),
            'edit' => EditFlavour::route('/{record}/edit'),
        ];
    }
}
