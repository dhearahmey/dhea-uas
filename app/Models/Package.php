<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'type', 'price', 'duration', 'description', 'image', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'integer',
        'duration' => 'integer'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}