<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json(['purchase' => $this->purchase(), 'product' => $this->product()]);
    }

    public function purchase()
    {
        $purchase = Purchase::join('products', 'products.id', '=', 'purchases.product_id')
            ->join('clients', 'clients.id', '=', 'purchases.client_id')
            ->join('items', 'items.id', '=', 'products.item_id')
            ->select('clients.*')
            ->whereDate('purchases.date', '<=', now()->toDateString())
            ->get();

        return $purchase;
    }

    public function product()
    {
        $product = Product::join('items', 'items.id', '=', 'products.item_id')
                ->select('items.name','products.*')
                ->where('quantity', '<=', 10)->get();
        return $product;
    }
}
