<?php

namespace App\Services\Inventory;

use App\Models\InventoryBalance;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class ReleaseStockAction
{
    public function execute(int $variantId, int $qty, string $refType, int $refId)
    {
        return DB::transaction(function () use ($variantId, $qty, $refType, $refId) {

            $balance = InventoryBalance::where('product_variant_id', $variantId)
                ->lockForUpdate()
                ->firstOrFail();

            StockMovement::create([
                'product_variant_id' => $variantId,
                'movement_type' => 'release',
                'quantity' => -$qty,
                'reason' => 'Order cancelled',
                'ref_type' => $refType,
                'ref_id' => $refId,
            ]);

            $balance->decrement('stock_reserved', $qty);

            return true;
        });
    }
}
