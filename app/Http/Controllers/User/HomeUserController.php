<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeUserController extends Controller
{
    public function index()
    {
        $post = Post::paginate(4);
        $product = product::select()->where('count', '>', 0)->get();
        return view('User.HomeView', ['product' => $product, 'post' => $post]);
    }
}
