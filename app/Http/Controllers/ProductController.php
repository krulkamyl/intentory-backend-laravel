<?php

namespace App\Http\Controllers;


use App\Parameter;
use App\Product;
use App\ProductHasParam;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    public function index() {
        return response(Product::whereIsDeleted(false)->toArray(),200);
    }

    public function store(Request $request) {
        $validator = $this->validator($request->all());
        if ($validator->fails())
            return response($validator->fails(),406);
        else {
            $product = new Product();
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->save();

            foreach ($request->input('params') as $key => $value) {
                $productHasParam = new ProductHasParam();
                $productHasParam->id_param = $key;
                $productHasParam->id_product = $product->id;
                $productHasParam->value = $value;
                $productHasParam->save();
            }
            return $this->index();
        }
    }

    public function update($id, Request $request) {
        $validator = $this->validator($request->all());
        if ($validator->fails())
            return response($validator->fails(),406);
        else {
            $product = Product::findProduct($id);
            if ($product) {
                $product->name = $request->input('name');
                $product->price = $request->input('price');
                $product->update();

                $params = array();
                foreach ($request->input('params') as $key => $value) {
                    $productHasParam = ProductHasParam::whereIdProduct($product->id)->whereIdParam($key);
                    if ($productHasParam) {
                        $productHasParam->update(['value'=>$value]);
                        array_push($params,$key);
                    }
                }

                $difference = array_diff_key(array_keys($request->input('params')),$params);
                foreach ($difference as $item) {
                    if (!ProductHasParam::whereIdProduct($product->id)->whereIdParam($item)->first()->delete()) {
                        $productHasParam = new ProductHasParam();
                        $productHasParam->id_product = $product->id;
                        $productHasParam->id_param = $item;
                        $productHasParam->value = $request->input('params')[$item];
                        $productHasParam->save();
                    }
                }

                return $this->index();
            } else
                return response('not found', 204);
        }
    }

    public function destroy($id) {
        return (Product::findProduct($id)->update(['is_deleted'=>true])) ? $this->index() : response('not found',204);
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'string|min:1|max:255|required',
            'price' => 'numeric|required',
            'duration_time' => 'date|required',
            'rented_time' => 'string|required',
            'params.id' => 'integer|required|exist:parameter,id' ,
            'params.value' => 'string|required|min:1|max:255'
        ]);
    }
}
