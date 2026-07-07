<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return $this->adminDashboard();
        }
        return $this->userDashboard();
    }

    public function admin()
    {
        return $this->adminDashboard();
    }

    private function adminDashboard()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $readyOrders = Order::where('status', 'ready')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $todayOrders = Order::whereDate('created_at', today())->count();

        // Chart data (7 hari terakhir)
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartData[] = [
                'date' => $date->format('d/m'),
                'total' => Order::whereDate('created_at', $date)->count()
            ];
        }

        return view('admin.dashboard', compact(
            'totalOrders', 'pendingOrders', 'processingOrders', 'readyOrders',
            'totalRevenue', 'todayOrders', 'chartData'
        ));
    }

    private function userDashboard()
    {
        $orders = Order::where('user_id', auth()->id())
                    ->with('package')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();

        $totalOrders = Order::where('user_id', auth()->id())->count();
        $activeOrders = Order::where('user_id', auth()->id())
                            ->whereIn('status', ['pending', 'processing', 'ready'])
                            ->count();

        return view('user.dashboard', compact('orders', 'totalOrders', 'activeOrders'));
    }
}