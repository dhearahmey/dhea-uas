<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'amount', 'method', 'proof_image', 'status', 'verified_at', 'note'
    ];

    protected $casts = [
        'amount' => 'integer',
        'verified_at' => 'datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Diverifikasi',
            'rejected' => 'Ditolak'
        ];
        return $labels[$this->status] ?? $this->status;
    }
}