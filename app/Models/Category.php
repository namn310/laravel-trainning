<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Throwable;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    public $primaryKey = 'idCat';
    public $timestamp = true;
    protected $fillable = ['name'];
}
