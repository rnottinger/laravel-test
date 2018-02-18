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

//        Replace Nested Loop with FlatMap

        $lampsAndWallets = $products->filter(function ($product) {
            return collect(['Lamp', 'Wallet'])->contains($product['product_type']);
        });

        // Get all of the product variant prices
        $prices = collect();

//        it looks like we are trying to map product variants into their prices
//        but we are starting with a collection of products, not a collection of variants
//        One thing that gets us a little bit closer is to map each product into just its variants
        $variants = $lampsAndWallets->map(function(product) {
           return $product['variants'];
        })->flatten(1);
//        the issue we have now is we have a collection of arrays of variants, not just one big list of variants
//        flatten is a collection operation that flattens a deep collection to a single level
//        using map and flatten together like this is so common that
//              there is a single method called flatMap that combines them

        [
// ...
//  { "title": "Blue", "price": 29.33 },
//  { "title": "Turquoise", "price": 18.50 },
//  { "title": "Sky Blue", "price": 20.00 },
//  { "title": "White", "price": 17.97 },
//  { "title": "Azure", "price": 65.99 },
//  { "title": "Salmon", "price": 1.66 },
//  // ...
//]
        foreach ($lampsAndWallets as $product) {
            foreach ($product['variants'] as $productVariant) {
                $prices[] = $productVariant['price'];
            }
        }

        return $prices->sum();
    }
}
