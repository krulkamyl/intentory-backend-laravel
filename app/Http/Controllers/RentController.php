<?php

namespace App\Http\Controllers;


use App\Classes\Constant;
use App\ProductHasRented;
use Illuminate\Http\Request;
use Validator;

class RentController extends Controller
{
    public function index() {
        return response(ProductHasRented::all()->toArray(),200);
    }

    public function rent($id) {
        return ($rent = ProductHasRented::find($id)) ? $rent->toArray() : response('not found',204);
    }

    public function store(Request $request) {
        $validator = $this->validator($request->all());
        if ($validator->fails())
            return response($validator->failed(),406);
        else {
            $productHasRented = new ProductHasRented();
            $productHasRented->id_product = $request->input('id_product');
            $productHasRented->id_customer = $request->input('id_customer');
            $productHasRented->rented_time = $request->input('rented_time');
            $productHasRented->duration_time = $request->input('duration_time');
            $productHasRented->save();
            return $this->index();
        }
    }

    public function update($id, Request $request) {
        $validator = $this->validator($request->all());
        if ($validator->fails())
            return response($validator->failed(),406);
        else {
            $productHasRented = ProductHasRented::find($id);
            if ($productHasRented) {
                $productHasRented->id_product = $request->input('id_product');
                $productHasRented->id_customer = $request->input('id_customer');
                $productHasRented->rented_time = $request->input('rented_time');
                $productHasRented->duration_time = $request->input('duration_time');
                $productHasRented->update();
                return $this->index();
            } else
                return response('not found', 204);
        }
    }

    public function updateIsRented($id) {
        $productHasRented = ProductHasRented::find($id);
        if ($productHasRented) {
            $productHasRented->is_rented = !$productHasRented->is_rented;
            $productHasRented->update();
            return $this->index();
        } else
            return response('not found', 204);
    }

    public function updateIsDenuncation($id) {
        $productHasRented = ProductHasRented::find($id);
        if ($productHasRented) {
            $productHasRented->is_denuncation = !$productHasRented->is_denuncation;
            $productHasRented->update();
            return $this->index();
        } else
            return response('not found', 204);
    }

    public function destroy($id) {
        return (ProductHasRented::destroy($id)) ? $this->index() : response('not found',204);
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
            'rented_time' => 'date_format:"'.Constant::DATEFORMAT.'"|required',
            'duration_time' => 'string|required',
            'id_customer' => 'integer|required',
            'id_product' => 'integer|required'
        ]);
    }
}
