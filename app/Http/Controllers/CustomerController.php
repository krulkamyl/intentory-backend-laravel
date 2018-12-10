<?php

namespace App\Http\Controllers;


use App\Customer;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends Controller
{
    public function index() {
        return response(Customer::all()->toArray(),200);
    }

    public function store(Request $request) {
        $validator = $this->validator($request->all());
        if ($validator->fails())
            return response($validator->fails(),406);
        else {
            $customer = new Customer();
            $customer->name = $request->input('name');
            $customer->save();
            return $this->index();
        }
    }

    public function update($id, Request $request) {
        $validator = $this->validator($request->all());
        if ($validator->fails())
            return response($validator->fails(),406);
        else {
            $customer = Customer::find($id);
            if ($customer != null) {
                $customer->name = $request->input('name');
                $customer->update();
                return $this->index();
            } else
                return response('not found', 204);
        }
    }

    public function destroy($id) {
        return (Customer::destroy($id)) ? $this->index() : response('not found',204);
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
            'name' => 'string|min:1|max:255|required'
        ]);
    }
}
