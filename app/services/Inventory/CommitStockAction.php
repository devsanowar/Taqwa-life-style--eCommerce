<?php

namespace App\Services\Inventory;

use App\Models\InventoryBalance;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Exception;

class CommitStockAction
{
    public function execute(int $variantId, int $qty, string $refType, int $refId)
    {
        return DB::transaction(function () use ($variantId, $qty, $refType, $refId) {

            $balance = InventoryBalance::where('product_variant_id', $variantId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($balance->stock_reserved < $qty) {
                throw new Exception('Invalid reservation');
            }

            // OUT movement
            StockMovement::create([
                'product_variant_id' => $variantId,
                'movement_type' => 'out',
                'quantity' => -$qty,
                'reason' => 'Order shipped',
                'ref_type' => $refType,
                'ref_id' => $refId,
            ]);

            $balance->decrement('stock_reserved', $qty);
            $balance->decrement('stock_on_hand', $qty);

            return true;
        });
    }
}