<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemIn;
use App\Models\Sale;
use App\Models\SalesDetails;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $test = SalesDetails::find(1)->sales;
        // $test = Sale::find(1)->salesDetails;
        // return $test;
        // return url()->current();
        $items = Item::select('items.id', 'name', 'upc', 'with_serial_number', DB::raw("(SELECT cost_price FROM item_ins WHERE item_ins.item_id = items.id ORDER BY id DESC LIMIT 1) as cost_price"))->get();
        $salesNumber = $this->fetchSalesNumber();
        return view('sale.index', compact('items'));
        // $controlNumber = $this->fetchControlNumber();
        // return view('sale.index', compact('items', 'controlNumber'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::select(
                                'items.id', 
                                'name', 
                                'upc', 
                                'with_serial_number', 
                                'price AS selling_price',
                                DB::raw("(SELECT COUNT(*) FROM item_ins WHERE item_id = items.id) as total_qty"),
                                DB::raw("(SELECT adjusted_cost_price FROM item_ins WHERE item_ins.item_id = items.id ORDER BY id DESC LIMIT 1) as cost_price"))->get();
        $salesNumber = $this->fetchSalesNumber();
        return view('sale.create', compact('items', 'salesNumber'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function fetchSalesNumber() {
        $query = Sale::select(DB::raw("MAX(CASE WHEN sales_number IS NOT NULL THEN sales_number END) AS sales_number"))->where('branch_id', 1)->get();
        $salesNumber = $query[0]->sales_number;

        if (is_null($salesNumber) || empty($salesNumber)) {
            $salesNumber = 'DR-00001';
        }
        else {
            $number = substr($salesNumber, 3);
            $increaseNumber = str_pad($number+=1, 5, 0, STR_PAD_LEFT);
            $salesNumber = substr_replace($salesNumber, $increaseNumber, 3);
        }

        return $salesNumber;
    }

    public function fetchSerialNumbers($id, $branchId) {
        $query = ItemIn::select('serial_number')->where(['item_id' => $id, 'branch_id' => $branchId])->get();
        echo json_encode($query);
    }
}
