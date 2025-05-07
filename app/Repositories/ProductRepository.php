<?php

namespace App\Repositories;

use App\Repositories\Interface\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use App\Models\ImageProduct;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function find($id) {}
    public function all()
    {
        $products = Product::with('ImageProduct')
            ->orderBy('idPro', 'desc')
            ->paginate(5);
        return $products;
    }
    public function getListProductInUserView() {}
    /**
     * @param string $id
     * @return array|null
     */
    public function getDetailProductToUpdateRepository(string $id): ?array
    {
        $product = Product::with('ImageProduct')
            ->where('idPro', $id)
            ->first();
        $category = Cache::remember('list_category', 1440, function () {
            return Category::all();
        });
        $nameCat = Category::where('idCat', $product->idCat)
            ->select(
                'name',
                'idCat'
            )
            ->first();
        return [
            'category' => $category,
            'product' => $product,
            'nameCat' => $nameCat->name
        ];
    }
    /**
     * @param $request
     * @return bool
     */
    public function create($request): bool
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
    /**
     * @param string $id
     * @param $request
     * @return string
     */
    public function update($id, $request): string
    {
        try {
            DB::beginTransaction();
            $product = Product::find($id);
            if (!$product) {
                return 'Not Found';
            }
            $product->namePro = $request->namepro;
            $product->description = $request->mota;
            $product->count = (int)$request->countpro;
            $product->hot = 0;
            $product->cost = (int)$request->giabanpro;
            $product->discount = (int)$request->discount ? (int)$request->discount : 0;
            $product->idCat = (int)$request->danhmucAddpro;
            $product->save();
            // If request send file image, delete old image
            if ($request->UpdateImage === 'true' && $request->file('imagepro')) {
                $files = $request->file('imagepro');
                $indexImg = 0;
                foreach ($files as $value) {
                    $indexImg++;
                    $extension = $value->getClientOriginalExtension(); //get extension of file
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
            return 'success';
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return 'error';
        }
    }
    /**
     * @param $request
     * @return bool
     */
    public function delete($idPro): bool
    {
        try {
            DB::beginTransaction();
            $imageProduct = ImageProduct::where('idPro', $idPro)
                ->select('id', 'idPro', 'image')
                ->get();
            foreach ($imageProduct as $row) {
                if (File::exists('assets/img-add-pro/' . $row->image)) {
                    File::delete('assets/img-add-pro/' . $row->image);
                }
            }
            Product::where('idPro', $idPro)->delete();
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return false;
        }
    }
    /**
     * @param string $id
     * @return string
     */
    public function getImgProductRepository($id): string
    {
        $img = DB::table('image_products')
            ->select('image')
            ->where('idPro', $id)
            ->first();
        return $img->image;
    }
    /**
     * @param $request
     * @return bool
     */
    public function deleteImageProductRepository($id): bool
    {
        try {
            DB::beginTransaction();
            $image = ImageProduct::find($id);
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
    /**
     * @param int $id 
     * @return \App\Models\Product|null 
     */
    public function getDetailProductRepository($id): ?Product
    {
        $product = Product::with("ImageProduct")
            ->where("idPro", $id)
            ->first();
        return $product ?? null;
    }
    /**
     *
     * @param int $id 
     * @return \Illuminate\Support\Collection|null 
     */
    public function getRelatedProductRepository($id): ?Collection
    {
        $product = Product::find($id);
        $idCat = $product->idCat;
        $product = Product::with("ImageProduct")
            ->where("idCat", $idCat)
            ->where("idPro", '!=', $id)
            ->get();
        return $product ?? null;
    }
    /**
     * @param string $text
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null 
     */
    // Find product by name
    public function getListProductByNameRepository(string $text): ?LengthAwarePaginator
    {
        $product = Product::with('ImageProduct')
            ->where(
                'namePro',
                'LIKE',
                '%' . $text . '%'
            )
            ->orderBy('idPro', 'desc')
            ->paginate(5);
        return $product ?? null;
    }
    /**
     *
     * @param int $idCat 
     * @return \Illuminate\Support\Collection|null 
     */
    public function getListProductByCategoryRepository($idCat): ?Collection
    {
        $product = Product::with('ImageProduct')->where('idCat', $idCat)->get();
        return $product ?? null;
    }
    /**
     *
     * @param int $idCat 
     * @param string $field
     * @param string $sort 
     * @return \Illuminate\Support\Collection|null 
     */
    public function getListProductBySortRepository($idCat, $field, $sort): ?Collection
    {
        $product = Product::with('ImageProduct')->where('idCat', $idCat)->orderBy($field, $sort)->get();
        return $product ?? null;
    }
    /**
     * @param string $idPro
     * @return int|null
     */
    public function getDiscountProductRepository(string $idPro): ?int
    {
        $product = Product::find($idPro);
        return $product->discount ?? null;
    }
}
