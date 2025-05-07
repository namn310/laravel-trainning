<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetail;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamp = true;
    public $incrementing = false;
    public $keyType = 'string';
    protected $fillable = [
        'idCus',
        'status',
        'address',
        'note',
        'thanhtoan',
        'idVoucher',
    ];
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            do {
                $randomId = Str::upper(Str::random(10));
            } while (self::where('id', $randomId)->exists());
            $order->id = $randomId;
        });
    }
}
