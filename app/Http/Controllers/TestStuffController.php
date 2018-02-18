<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    }
}
