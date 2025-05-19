<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interface\CategoryRepositoryInterface;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryRepository implements CategoryRepositoryInterface
{
    
    public function all()
    {
        $cat = DB::table("categories")
            ->select("name", "idCat")
            ->get();
        return $cat;
    }
    public function allWithPaginate()
    {
        return Category::paginate(10);
    }
    public function find($id) {}
    /**
     * @param $request
     * @return array|string
     */
    public function create($data)
    {
        try {
            $name = $data->name;
            $cat = Category::where('name', $name)->exists();
            if ($cat) {
                return 'Category has existed !';
            }
            DB::beginTransaction();
            $Category = Category::create([
                'name' => $data->name
            ]);
            DB::commit();
            return [
                'idCat' => $Category->idCat,
                'name' => $Category->name,
            ];
        } catch (Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return 'error';
        }
    }
    /**
     * @param $request
     * @return string
     */
    public function update($id, $data)
    {
        try {
            DB::beginTransaction();
            $cat = Category::find($id);
            if (!$cat) {
                return 'Not Found';
            }
            $nameExists = Category::where('name', $data->name)
                ->first();
            // if name was existed return 
            if ($nameExists) {
                Log::error($nameExists ? 'true' : 'false');
                return 'Name has existed';
            }
            $cat->name = $data->name;
            $cat->save();
            DB::commit();
            return 'success';
        } catch (Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return 'error';
        }
    }
    /**
     * @param $request
     * @return string
     */
    public function delete($idCat)
    {
        try {
            DB::beginTransaction();
            $cat = Category::find($idCat);
            if (!$cat) {
                return 'Not Found';
            }
            $cat->delete();
            DB::commit();
            return 'true';
        } catch (Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return 'error';
        }
    }
}
