<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $order->load('trackings');
        return view('trackings.show', compact('order'));
    }
}