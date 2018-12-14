<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductHasParam;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    public function index() {
        return response(Product::whereIsDeleted(false)->get()->toArray(),200);
    }

    public function product($id) {
        return ($product = Product::find($id)) ? $product->toArray() : response('not found',204);
    }

    public function search(Request $request) {
        $products = Product::whereHas('parameters', function ($query) use ($request){
            foreach ($request->input('params') as $key => $value) {
                if (strlen($value) >= 1)
                    $query->where([['id_param', '=', $key],
                        ['value', 'like', '%'.$value.'%']]
                    );
            }
        })->where(function ($query) use ($request) {
            if (strlen($request->input('name')) >= 1)
                $query->where('name', 'like', '%'.$request->input('name').'%');
            $query->where('is_deleted','=','0');
        })->get();

        return response($products->toArray(),200);
    }

    public function store(Request $request) {
        $input = json_decode($request->getContent(),true);
        $validator = $this->validator($input);
        if ($validator->fails())
            return response($validator->failed(),406);
        else {
            $product = new Product();
            $product->name = $input['name'];
            $product->price = $input['price'];
            $product->save();

            foreach ($input['params'] as $key => $value) {
                $productHasParam = new ProductHasParam();
                $productHasParam->id_param = $key;
                $productHasParam->id_product = $product->id;
                $productHasParam->value = $value;
                $productHasParam->save();
            }
            return $this->index();
        }
    }

    public function history($id) {
        $product = Product::findProduct($id);
        if ($product) {
            return response($product->rents->toArray(),200);
        } else
            return response('not found', 204);
    }

    public function update($id, Request $request) {
        $validator = $this->validator($request->all());
        if ($validator->fails())
            return response($validator->failed(),406);
        else {
            $product = Product::findProduct($id);
            if ($product) {
                $product->name = $request->input('name');
                $product->price = $request->input('price');
                $product->update();

                $params = array();
                $paramsInput = (is_array($request->input('params'))) ? $request->input('params') : json_decode($request->input('params',false));

                foreach ($paramsInput as $key => $value) {
                    if (strlen($value) >= 1) {
                        $productHasParam = ProductHasParam::whereIdProduct($product->id)->whereIdParam($key)->first();
                        if ($productHasParam) {
                            $productHasParam->update(['value'=>$value]);
                            array_push($params,$key);
                        }
                    }
                }

                $paramsKey = array();
                foreach ($paramsInput as $key => $value) : array_push($paramsKey,$key); endforeach;
                $difference = array_diff_key($paramsKey,$params);
                foreach ($difference as $item) {
                    $exist = ProductHasParam::whereIdProduct($product->id)->whereIdParam($item)->first();
                    if ($exist)  {
                        $exist->delete();
                    }
                    else {
                        if (strlen($value) >= 1) {
                            $productHasParam = new ProductHasParam();
                            $productHasParam->id_product = $product->id;
                            $productHasParam->id_param = $item;
                            $productHasParam->value = $request->input('params')[$item];
                            $productHasParam->save();
                        }
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
            'price' => 'numeric|required'
        ]);
    }
}
