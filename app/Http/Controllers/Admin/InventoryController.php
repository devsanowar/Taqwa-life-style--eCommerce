<?php

namespace App\Http\Controllers;

use App\Services\Inventory\ReserveStockAction;
use App\Services\Inventory\CommitStockAction;
use App\Services\Inventory\ReleaseStockAction;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function reserve(Request $request, ReserveStockAction $action)
    {
        $action->execute(
            $request->variant_id,
            $request->quantity,
            'order',
            $request->order_id
        );

        return response()->json(['message' => 'Stock reserved']);
    }

    public function commit(Request $request, CommitStockAction $action)
    {
        $action->execute(
            $request->variant_id,
            $request->quantity,
            'order',
            $request->order_id
        );

        return response()->json(['message' => 'Stock committed']);
    }

    public function release(Request $request, ReleaseStockAction $action)
    {
        $action->execute(
            $request->variant_id,
            $request->quantity,
            'order',
            $request->order_id
        );

        return response()->json(['message' => 'Stock released']);
    }
}