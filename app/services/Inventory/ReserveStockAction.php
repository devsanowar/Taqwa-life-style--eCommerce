<?php

namespace App\Services\Inventory;

use App\Models\InventoryBalance;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Exception;

class ReserveStockAction
{
    public function execute(int $variantId, int $qty, string $refType, int $refId)
    {
        return DB::transaction(function () use ($variantId, $qty, $refType, $refId) {

            $balance = InventoryBalance::where('product_variant_id', $variantId)
                ->lockForUpdate()
                ->firstOrFail();

            $available = $balance->stock_on_hand - $balance->stock_reserved;

            if ($available < $qty) {
                throw new Exception('Insufficient stock');
            }

            // Ledger entry
            StockMovement::create([
                'product_variant_id' => $variantId,
                'movement_type' => 'reserve',
                'quantity' => $qty,
                'reason' => 'Order reservation',
                'ref_type' => $refType,
                'ref_id' => $refId,
            ]);

            // Update balance
            $balance->increment('stock_reserved', $qty);

            return true;
        });
    }
}
