<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'package_id', 'order_number', 'weight', 'total_price',
        'pickup_date', 'delivery_date', 'note', 'status'
    ];

    protected $casts = [
        'weight' => 'integer',
        'total_price' => 'integer',
        'pickup_date' => 'date',
        'delivery_date' => 'date'
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function trackings()
    {
        return $this->hasMany(OrderTracking::class);
    }

    // Helper
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Diproses',
            'ready' => 'Siap Diambil',
            'delivered' => 'Sudah Diambil',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'processing' => 'info',
            'ready' => 'success',
            'delivered' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger'
        ];
        return $badges[$this->status] ?? 'secondary';
    }
}