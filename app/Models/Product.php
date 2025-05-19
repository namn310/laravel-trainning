<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\ImageProduct;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Throwable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    public $primaryKey = 'idPro';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamp = true;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            do {
                $randomId = Str::upper(Str::random(10));
            } while (self::where('idPro', $randomId)->exists());
            $product->idPro = $randomId;
        });
    }
    public function ImageProduct()
    {
        return $this->hasMany(ImageProduct::class, 'idPro', 'idPro');
    }
}
