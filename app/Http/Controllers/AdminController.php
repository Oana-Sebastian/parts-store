<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function orders(Request $request)
    {
        $query = Order::with(['user', 'part']);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orders = $query->paginate(20);
        $users = User::where('role', 'user')->get();

        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
        ];

        return view('admin.orders', compact('orders', 'users', 'stats'));
    }

    public function updateOrderStatus(Request $request, int $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $validated['status'];

        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            $order->part->increaseStock($order->quantity);
        }

        $order->status = $newStatus;
        $order->save();

        return back()->with('success', "Order status #{$order->id} updated successfully!");
    }

    public function deleteOrder(int $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'cancelled') {
            $order->part->increaseStock($order->quantity);
        }

        $order->delete();

        return back()->with('success', 'Order deleted successfully!');
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_parts' => Part::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'low_stock_parts' => Part::where('stock', '<=', 5)->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
            'recent_orders' => Order::with(['user', 'part'])
                ->latest()
                ->limit(5)
                ->get(),
            'low_stock' => Part::where('stock', '<=', 10)
                ->orderBy('stock', 'asc')
                ->limit(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}