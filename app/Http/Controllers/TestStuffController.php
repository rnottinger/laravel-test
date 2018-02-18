<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;  // composer require illuminate/support

class TestStuffController extends Controller
{
    //
    public function blam()
    {
//        $collection = collect();
        $employees = new Collection([
            ['name' => 'Mary', 'email' => 'mary@example.com', 'salaried' => true],
            ['name' => 'John', 'email' => 'john@example.com', 'salaried' => false],
            ['name' => 'Kelly', 'email' => 'kelly@example.com', 'salaried' => true],
        ]);

//        Output an item in the collection to the browser
        var_dump($employees[2]);

//        insert an item into collection
        $employees[] = ['name' => 'Richard', 'email' => 'richard@example.com', 'salaried' => true];

        $richardTest = isset($employees[3]);

//        delete an item in the collection
        unset($employees[0]);

        $salariedEmployees = $employees->filter( function($employee) {
            return $employee['salaried'];
        });

//        function version of count ... use when have to count a collection or an array
        $countCollectionOfEmployees = count($salariedEmployees);

        $numberOfSalariedEmployees = $employees->filter(function ($employee) {
            return $employee['salaried'];
        })->count();

        return response([
            "employees"                     => $employees,
            "richardTest"                   => $richardTest,
            "salariedEmployees"             => $salariedEmployees,
            "countCollectionOfEmployees"    => $countCollectionOfEmployees,
            "numberOfSalariedEmployees"     => $numberOfSalariedEmployees,
        ]);

//        NEVER use a foreach loop outside of a collection
//        Instead of doing things with the items in a collection, you do things to the collection itself
//        map       it
//        filter    it
//        reduce    it
//        sum       it
//        zip       it
//        reverse   it
//        transpose it
//        flatten   it
//        group     it
//        count     it
//        chunk     it
//        sort      it
//        slice     it
//        search    it

//        3 ways to create a new collection
//        $collection = new Collection($items);
//        $collection = Collection::make($items);
//        $collection = collect($items);

    }


    public function pricingLampsWallets(Request $request)
    {
        $productJson = $request->all();
//        return $productJson;

//        Reduce to Sum
//        1. Getting the price of each product variant
//        2. Summing the prices to get a total cost <-- we can use reduce to replace this step

        $lampsAndWallets = $products->filter(function ($product) {
            return collect(['Lamp', 'Wallet'])->contains($product['product_type']);
        });

        // Get all of the product variant prices
        $prices = collect();

//        $totalCost = 0;
        // Loop over every product
        foreach ($lampsAndWallets as $product) {
            foreach ($product['variants'] as $productVariant) {
//                $totalCost += $productVariant['price'];
                $prices[] = $productVariant['price'];
            }
        }

        // Sum the prices to get a total cost
//        $totalCost = $prices->reduce(function($total, $price) {
//            return $total + $price;
//        }, 0);
//        return $totalCost;

        // you can often replace reduce with a more expressive operation
        return $prices->sum();
    }
}
