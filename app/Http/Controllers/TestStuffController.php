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
        });
        return response([
            'shiftIds' => $shiftIds
        ]);
    }

    public function binaryToDecimal($binary)
    {
        return collect(str_split($binary))
            ->reverse()
            ->values()
            ->map(function ($column, $exponent) {
                return $column * (2 ** $exponent);
            })->sum();
    }

    public function whatsYourGithubScore(Request $request)
    {
        return $this->githubScore($request->all());
    }

    public function githubScore($events)
    {
        return $this->fetchEvents($events)
            ->pluck('type')
            ->map(function ($eventType){
                return $this->lookupEventScore($eventType);
            })
            ->sum();
    }

    public function fetchEvents($events)
    {
        $eventsCollection = collect($events);
        $lastPhpstormOff = $eventsCollection->pop();
        return $eventsCollection;
    }

    public function lookupEventScore($eventType)
    {
        return collect([
            'PushEvent' => 5,
            'CreateEvent' => 4,
            'IssuesEvent' => 3,
            'CommitCommentEvent' => 2,
        ])->get($eventType,1);
    }

    public function formattingPullRequestComment()
    {
        $messages = [
            'Opening brace must be the last content on the line',
            'Closing brace must be on a line by itself',
            'Each PHP statement must be on a line by itself',
        ];

        $this->buildComment($messages);
    }

    public function buildComment($messages)
    {
        $comment = '';

        foreach ($messages as $message) {
            $comment .= "- {$message}\n";
        }
        return $comment;
    }
}
