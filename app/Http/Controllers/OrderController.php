<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Package;
use App\Models\OrderTracking;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                    ->with('package')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $packages = Package::where('is_active', true)->get();
        return view('orders.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'weight' => 'required|numeric|min:0.5',
            'pickup_date' => 'required|date|after:today',
            'note' => 'nullable|string'
        ]);

        $package = Package::find($request->package_id);
        $totalPrice = $package->price * $request->weight;

        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());

        $order = Order::create([
            'user_id' => auth()->id(),
            'package_id' => $request->package_id,
            'order_number' => $orderNumber,
            'weight' => $request->weight,
            'total_price' => $totalPrice,
            'pickup_date' => $request->pickup_date,
            'delivery_date' => \Carbon\Carbon::parse($request->pickup_date)->addDays(1),
            'note' => $request->note,
            'status' => 'pending'
        ]);

        // Add tracking
        OrderTracking::create([
            'order_id' => $order->id,
            'status' => 'pending',
            'description' => 'Pesanan dibuat, menunggu pembayaran'
        ]);

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $order->load('package', 'payment', 'trackings');
        return view('orders.show', compact('order'));
    }

    public function adminIndex()
    {
        $this->authorizeAdmin();
        $orders = Order::with('user', 'package')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorizeAdmin();

        $request->validate([
            'status' => 'required|in:pending,processing,ready,delivered,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        OrderTracking::create([
            'order_id' => $order->id,
            'status' => $request->status,
            'description' => 'Status diupdate menjadi ' . $order->status_label
        ]);

        return redirect()->back()->with('success', 'Status berhasil diupdate');
    }

    public function destroy(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            abort(403, 'Hanya bisa membatalkan pesanan yang pending');
        }

        $order->update(['status' => 'cancelled']);

        OrderTracking::create([
            'order_id' => $order->id,
            'status' => 'cancelled',
            'description' => 'Pesanan dibatalkan oleh customer'
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibatalkan');
    }

    private function authorizeAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
    }
}