<?php

namespace App\Http\Controllers;


use App\Parameter;
use Illuminate\Http\Request;
use Validator;

class ParameterController extends Controller
{
    public function index() {
        return response(Parameter::all()->toArray(),200);
    }

    public function store(Request $request) {
        $validator = $this->validator($request->all());
        if ($validator->fails())
            return response($validator->fails(),406);
        else {
            $parameter = new Parameter();
            $parameter->name = $request->input('name');
            $parameter->save();
            return $this->index();
        }
    }

    public function update($id, Request $request) {
        $validator = $this->validator($request->all());
        if ($validator->fails())
            return response($validator->fails(),406);
        else {
            $parameter = Parameter::find($id);
            if ($parameter != null) {
                $parameter->name = $request->input('name');
                $parameter->update();
                return $this->index();
            } else
                return response('not found', 204);
        }
    }

    public function destroy($id) {
        return (Parameter::destroy($id)) ? $this->index() : response('not found',204);
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
