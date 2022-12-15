<?php

namespace App\Http\Controllers;
use App\Models\Products;
use Validator;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Http\Request;

class ProductController extends BaseController {

    public function index() {

        $product = Products::all();

        return $this->sendResponse(ProductResource::collection($product), "OK");
    }

    public function show($id) {
        $product = Products::find($id);

        if(is_null($product)) {
            return $this->sendError("Post nem létezik");
        }
        return $this->sendResponse(new ProductResource($product), "Post betöltve");
    }

    public function update(Request $request, $id) {

        $input = $request->all();

        $validator = Validator::make($input, [
            "name" => "required",
            "price" => "required"
        ]);

        if($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $product = Products::find($id);
        $product->update($request->all());

        return $this->sendResponse(new ProductResource($product), "Post frissítve");
    }

    public function store(Request $request) {
        $input = $request->all();
        $validator = validator::make($input, [
            "name" => "required",
            "price" => "required"
        ]);

        if($validator->fails() ){
            print_r("error");
            return $this->sendError($validator->errors());
        }

        $product = Products::create($input);

        print_r("Post létrehozva");
        return $this->sendResponse(new ProductResource($product), "Post létrehozva");
    }
}
