<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Order;
use App\Exceptions\PartNotFoundException;
use App\Exceptions\InsufficientStockException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class OrderController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = auth()->user()->orders()->with('part')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'part_id' => 'required|exists:parts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $part = Part::find($validated['part_id']);

        if (!$part) {
            throw new PartNotFoundException();
        }

        if (!$part->isInStock($validated['quantity'])) {
            throw new InsufficientStockException(
                "Only {$part->stock} items available",
                $part->stock
            );
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'part_id' => $part->id,
            'quantity' => $validated['quantity'],
            'total_price' => $part->price * $validated['quantity'],
            'status' => 'pending'
        ]);

        $part->decreaseStock($validated['quantity']);

        return redirect()->route('orders.index')
            ->with('success', 'Order placed successfully!');
    }

    public function cancel(int $id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Forbidden action');
        }

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'This order cannot be cancelled');
        }

        $order->markAsCancelled();

        return back()->with('success', 'Order cancelled successfully!');
    }
}