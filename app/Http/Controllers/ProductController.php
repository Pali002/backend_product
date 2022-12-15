<?php

namespace App\Http\Controllers;
use App\Models\Products;
use Validator;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Http\Request;

class ProductController extends BaseController {

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
