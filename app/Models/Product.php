<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\ImageProduct;
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
            } while (self::where('idPro', $randomId)->exists()); // Kiểm tra trùng lặp
            $product->idPro = $randomId;
        });
    }
    public function getListproduct()
    {
        try {
            $GetPage = $_GET['page'];
            $page = $GetPage ?? 1;
            $products = Cache::remember("List_product_page_" . $page, 1440, function () {
                return Product::with('ImageProduct')->orderBy('idPro', 'desc')->paginate(10);
            });
            return $products;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    public function editModel($id, $name)
    {
        try {
            $product = Product::with('ImageProduct')->where('idPro', $id)->first();
            $category = Cache::remember('list_category', 1440, function () {
                return Category::all();
            });
            $nameCat = Category::where('idCat', $product->idCat)->select('name', 'idCat')->first();
            return [
                'category' => $category,
                'product' => $product,
                'nameCat' => $nameCat->name
            ];
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    public function updateModel($id, $request)
    {
        try {
            DB::beginTransaction();
            $product = Product::find($id);
            Log::error($product);
            if ($product) {
                $product->namePro = $request->namepro;
                $product->description = $request->mota;
                $product->count = (int)$request->countpro;
                $product->hot = 0;
                $product->cost = (int)$request->giabanpro;
                $product->discount = (int)$request->discount ? (int)$request->discount : 0;
                $product->idCat = (int)$request->danhmucAddpro;
                $product->save();
                // xóa ảnh cũ
                $ListImageProduct = ImageProduct::where('idPro', $id)->select('idPro', 'image')->get();
                foreach ($ListImageProduct as $row) {
                    if (File::exists('assets/img-add-pro/' . $row->image)) {
                        File::delete('assets/img-add-pro/' . $row->image);
                    }
                }
                ImageProduct::where('idPro', $id)->delete();
                $indexImg = 0;
                if ($files = $request->file('imagepro')) {
                    foreach ($files as $value) {
                        $indexImg++;
                        $extension = $value->getClientOriginalExtension(); //lay tep mo rong cua file
                        $filename =    $indexImg . time() . '.' . $extension;
                        $value->move('assets/img-add-pro/', $filename);
                        $imageProduct = ImageProduct::create([
                            'idPro' => $product->idPro,
                            'image' => $filename
                        ]);
                        $imageProduct->save();
                    }
                }
                DB::commit();
                return true;
            } else {
                return 'Not Found';
            }
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return false;
        }
    }
    public function getImgProduct($id)
    {
        $img = DB::table('image_products')->select('image')->where('idPro', $id)->limit(1)->get();
        foreach ($img as $result) {
            return $result->image;
        }
    }
    public function ImageProduct()
    {
        return $this->hasMany(ImageProduct::class, 'idPro', 'idPro');
    }
    public function getListCategory()
    {
        try {
            // $cat = DB::table("categories")->select("name", "idCat")->get();
            $cat = Cache::remember('list_category', 1440, function () {
                return DB::table("categories")->select("name", "idCat")->get();
            });
            return $cat;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    public function StoreProductModel($request)
    {
        try {
            DB::beginTransaction();
            $product = new Product();
            $product->namePro = $request->namepro;
            $product->description = $request->mota;
            $product->count = (int)$request->countpro;
            $product->hot = 0;
            $product->cost = (int)$request->giabanpro;
            $product->discount = (int)$request->discount ? (int)$request->discount : 0;
            $product->idCat = (int)$request->danhmucAddpro;
            $product->save();
            $indexImg = 0;
            if ($files = $request->file('imagepro')) {
                foreach ($files as $value) {
                    $indexImg++;
                    $extension = $value->getClientOriginalExtension(); //lay tep mo rong cua file
                    $filename =    $indexImg . time() . '.' . $extension;
                    $value->move('assets/img-add-pro/', $filename);
                    $imageProduct = ImageProduct::create([
                        'idPro' => $product->idPro,
                        'image' => $filename
                    ]);
                    $imageProduct->save();
                }
            }
            DB::commit();
            return true;
        } catch (Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }
    public function deleteModel($request)
    {
        try {
            DB::beginTransaction();
            $imageProduct = ImageProduct::where('idPro', $request->idPro)->select('id', 'idPro', 'image')->get();
            foreach ($imageProduct as $row) {
                if (File::exists('assets/img-add-pro/' . $row->image)) {
                    File::delete('assets/img-add-pro/' . $row->image);
                }
            }
            $product = Product::where('idPro', $request->idPro)->delete();
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return false;
        }
    }
    public function deleteImageProductModel($request)
    {
        try {
            DB::beginTransaction();
            $image = ImageProduct::find($request->id);
            if (File::exists('assets/img-add-pro/' . $image->image)) {
                File::delete('assets/img-add-pro/' . $image->image);
            }
            $image->delete();
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return false;
        }
    }
    public function getDetailProductModel($id, $name)
    {
        try {
            $product = Product::with("ImageProduct")->where("idPro", $id)->first();
            return $product;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    public function getRelatedProduct($id)
    {
        try {
            $product = Product::find($id);
            $idCat = $product->idCat;
            $product = Product::with("ImageProduct")->where("idCat", $idCat)->where("idPro", '!=', $id)->get();
            return $product;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
}
