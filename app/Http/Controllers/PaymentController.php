<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderTracking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment && $order->payment->status === 'verified') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Pesanan sudah dibayar');
        }

        return view('payments.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Validasi
        $rules = [
            'method' => 'required|in:cash,transfer,qris',
        ];

        // Bukti pembayaran wajib jika bukan cash
        if ($request->method != 'cash') {
            $rules['proof_image'] = 'required|image|mimes:jpg,jpeg,png|max:2048';
        }

        $request->validate($rules);

        // Upload gambar jika ada
        $imagePath = null;

        if ($request->hasFile('proof_image')) {
            $imagePath = $request->file('proof_image')->store('payments', 'public');
        }

        // Status pembayaran
        $paymentStatus = ($request->method == 'cash') ? 'verified' : 'pending';

        // Simpan pembayaran
        Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'method' => $request->method,
            'proof_image' => $imagePath,
            'status' => $paymentStatus,
            'verified_at' => ($request->method == 'cash') ? now() : null,
        ]);

        // Jika cash langsung diproses
        if ($request->method == 'cash') {

            $order->update([
                'status' => 'processing'
            ]);

            OrderTracking::create([
                'order_id' => $order->id,
                'status' => 'processing',
                'description' => 'Pembayaran Cash dipilih. Pesanan langsung diproses.'
            ]);

            return redirect()
                ->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat dengan metode Cash.');
        }

        // Jika transfer / QRIS
        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Bukti pembayaran berhasil diupload dan menunggu verifikasi admin.');
    }

    public function index()
    {
        $this->authorizeAdmin();

        $payments = Payment::with('order.user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function verify(Payment $payment)
    {
        $this->authorizeAdmin();

        $payment->update([
            'status' => 'verified',
            'verified_at' => now()
        ]);

        $payment->order->update([
            'status' => 'processing'
        ]);

        OrderTracking::create([
            'order_id' => $payment->order_id,
            'status' => 'processing',
            'description' => 'Pembayaran diverifikasi, pesanan diproses.'
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject(Payment $payment)
    {
        $this->authorizeAdmin();

        $payment->update([
            'status' => 'rejected'
        ]);

        return redirect()->back()->with('error', 'Pembayaran ditolak.');
    }

    private function authorizeAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
    }
}