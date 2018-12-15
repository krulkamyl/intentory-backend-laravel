<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        if (\App\Parameter::get()->isEmpty()) {
            $parameter = new \App\Parameter();
            $parameter->name = 'RAM (Gb)';
            $parameter->save();
        }

        if (\App\Product::get()->isEmpty()) {
            $product = new \App\Product();
            $product->name = 'Computer';
            $product->price = 50;
            $product->save();

            $lastParameter = \App\Parameter::orderBy('id','DESC')->first();

            $productHasParam = new \App\ProductHasParam();
            $productHasParam->id_product = $product->id;
            $productHasParam->id_param = $lastParameter->id;
            $productHasParam->value = '8';
            $productHasParam->save();
        }

        if (\App\Customer::get()->isEmpty()) {
            $customer = new \App\Customer();
            $customer->name = 'Jan Kowalsky';
            $customer->save();
        }

        if (\App\ProductHasRented::get()->isEmpty()) {
            $productHasRented = new \App\ProductHasRented();
            $productHasRented->id_customer = \App\Customer::orderBy('id','DESC')->first()->id;
            $productHasRented->id_product = \App\Product::orderBy('id','DESC')->first()->id;
            $productHasRented->rented_time = \Carbon\Carbon::now()->format(\App\Classes\Constant::DATEFORMAT);
            $productHasRented->duration_time = 30;
            $productHasRented->save();
        }

    }
}
