<?php

namespace App\Http\Controllers;


use DataTables;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Requests\ProductAddRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\RepoInterface\ProductInterfaceRepo;
use Illuminate\Support\Str;
class ProductController extends Controller
{

    public function __construct(
        public ProductInterfaceRepo $productInterfaceRepo
    ){

    }


    public function index(Request $request) {
     if ($request->ajax()) {
       $where =[];
       if(auth()->user()->is_admin  != 1){
         $where = [
          ['products.created_by',auth()->user()->id]
        ];
       }
        
        
        $data = $this->productInterfaceRepo->getProducts($where);
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function(Product $product) {
          $btn = '<a href="javascript:void(0)" data-product_id="'.$product->id.'"  class="btn btn-primary product-edit btn-sm">Edit</a>
                  <a href="javascript:void(0)" data-product_id="'.$product->id.'" class="btn btn-danger product-delete btn-sm ">Delete</a>';
          return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
     }
     $categories = Category::all();
      return view('products.product-listing',['categories' => $categories]);
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create() {}

    /**
    * Store a newly created resource in storage.
    */
    public function store(ProductAddRequest $request) {

      $data = [
        'name' => $request->name,
        'slug' => Str::slug($request->slug),
        'price' => $request->price ?? 0,
        'discount' => $request->discount ?? 0,
        'category_id' => $request->category ,
        'description' => $request->description ?? null ,
        'created_by' => auth()->user()->id ,
      ];
      
    
      $product = $this->productInterfaceRepo->createProduct($data);

      $productImages =  $request->image;
      if($request->has('image') && !blank($productImages)){
        foreach($productImages as $image){
            $imageName = storeFile('product-images/',$image, 'product');
            ProductImage::create(['product_id' => $product->id,'image' => $imageName]);
        }
      }
      return response()->json(['status' => 200, 'message' => 'Product Add Successfully']);
    }

    /**
    * Display the specified resource.
    */
    public function show(string $id) {
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $id) {
      $result = $this->productInterfaceRepo->getProduct([
        ['id',$id]
      ],['images','category']);
      if ($result) {
        return response()->json(['status' => 200, 'message' => 'Product Get Successfully', 'result' => $result]);
      } else {
        return response()->json(['status' => 101, 'message' => 'Something Went Wrong']);
      }
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(ProductUpdateRequest $request, string $id) {
      

$data = [
        'name' => $request->name,
        'slug' => Str::slug($request->slug),
        'price' => $request->price ?? 0,
        'discount' => $request->discount ?? 0,
        'category_id' => $request->category ,
        'description' => $request->description ?? null ,
        'created_by' => auth()->user()->id ,
      ];


      $this->productInterfaceRepo->updateProduct([
        ['id', $id]
      ], $data);

      $productImages =  $request->image;
      if($request->has('image') && !blank($productImages)){
        ProductImage::where('product_id',$id)->delete();
        foreach($productImages as $image){
            $imageName = storeFile('product-images/',$image, 'product');
            ProductImage::create(['product_id' => $id,'image' => $imageName]);
        }
      }

      return response()->json(['status' => 200, 'message' => 'Product Edit Successfully']);
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(string $id) {
      $result = $this->productInterfaceRepo->deleteProduct([['id', $id]]);
      if ($result) {
        return response()->json(['status' => 200, 'message' => 'Product Delete Successfully']);
      } else {
        return response()->json(['status' => 101, 'message' => 'Something Went Wrong']);
      }
    }

    // public function productImage =


}
