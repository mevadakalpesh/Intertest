<?php
namespace App\Http\RepoClass;

use App\Models\Product;
use App\Http\RepoInterface\ProductInterfaceRepo;

class ProductRepo implements ProductInterfaceRepo {
    public function __construct(
        public Product $product
    ){
    }

    public function getProducts(Array $where  = []){
        return $this->product->selectRaw('products.*,categories.name as
        category_name')->where($where)
        ->leftJoin('categories','products.category_id','=','categories.id')->get();
    }

    public function getProduct(Array $where  = [],Array $with = []){
        return $this->product->with($with)->where($where)->first();
    }
    public function createProduct(Array $data){
        return $this->product->create($data);
    }
    public function updateProduct(Array $where ,Array $data){
        return $this->product->where($where)->update($data);
    }
    public function deleteProduct(Array $where){
        return $this->product->where($where)->delete();
    }
}


