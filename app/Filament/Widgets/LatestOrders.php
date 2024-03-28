<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Tables\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    //To show full width
    protected int | string | array $columnSpan = 'full';

    //for sorting
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                ->label('Order ID')
                ->searchable(),

                TextColumn::make('user.name')
                ->searchable(),

                TextColumn::make('grand_total')
                ->money('PKR'),

                TextColumn::make('status')
                ->badge()
                ->color(fn (string $state):string => match($state){
                    'new' => 'info',
                    'procesing' => 'warning',
                    'shipped' => 'success',
                    'delivered' => 'success',
                    'cancelled' => 'danger'
                })
                ->icon(fn (string $state):string => match($state){
                    'new' => 'heroicon-m-sparkles',
                    'procesing' => 'heroicon-m-arrow-path',
                    'shipped' => 'heroicon-m-truck',
                    'delivered' => 'heroicon-m-check-badge',
                    'cancelled' => 'heroicon-m-x-circle'
                })
                ->sortable(),

                TextColumn::make('payment_method')
                ->sortable()
                ->searchable(),

                TextColumn::make('payment_status')
                ->badge()
                ->sortable()
                ->searchable(),

                TextColumn::make('created_at')
                ->label('Order Date')
                ->dateTime()
            ])
            ->actions([
                Action::make('View Order')
                ->url(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
                ->icon('heroicon-m-eye'),
            ]);
    }
}
