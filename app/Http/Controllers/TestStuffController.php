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


    /**
     * @param Request $request
     * @return mixed
     */
    public function pricingLampsWallets(Request $request)
    {
        $productJson = $request->all();
        $products = collect($productJson['products']);

        return $products->filter(function ($product) {
            return collect(['Lamp', 'Wallet'])->contains($product['product_type']);
        })->flatMap(function($product) {
            return $product['variants'];
        })->sum('price');
    }

    public function csvSurgery()
    {
        $shifts = [
            'Shipping_Steve_A7',
            'Sales_B9',
            'Support_Tara_K11',
            'J15',
            'Warehouse_B2',
            'Shipping_Dave_A6',
        ];
        $shiftIds = collect($shifts)->map(function($shift) {
            return collect(explode('_', $shift))->last();
            // Collections are a great tool for a lot of string processing situations
//            $parts = explode('_', $shift);
            // explode just gives you the string back if doesn't contain the delimiter you specify
//            return end($parts);
        });
        return response([
            'shiftIds' => $shiftIds
        ]);
/*
       Instead of keeping track of character offsets and dealing with substrings
            we just want the last part
                instead of looking for the last underscore,
                    lets just split the substring into its parts using explode

            $shiftIds = collect($shifts)->map(function($shift) {
                if (strrpos($shift, '_') !== false) {
                    $underscorePosition = strrpos($shift, '_');
                    $substringOffset = $underscorePosition + 1;
                    return substr($shift, $substringOffset);
                } else {
                    return $shift;
                }
            });
*/

    }
}
