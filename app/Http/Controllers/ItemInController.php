<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemIn;
use Illuminate\Support\Facades\DB;

class ItemInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::select('items.id', 'name', 'upc', 'with_serial_number', DB::raw("(SELECT cost_price FROM item_ins WHERE item_ins.item_id = items.id ORDER BY id DESC LIMIT 1) as cost_price"))->get();
        $controlNumber = $this->fetchControlNumber();
        return view('itemin.index', compact('items', 'controlNumber'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $itemIn = [];
        $f = 0;

        foreach ($request->input('item') as $item) {
            for ($i = 0; $i < $item['qty']; $i++) {
                $itemIn[$f]['item_id'] = $item['id'];
                $itemIn[$f]['branch_id'] = $request->input('branch-id');
                $itemIn[$f]['supplier_id'] = $request->input('supplier-id');
                $itemIn[$f]['date'] = $request->input('date');
                $itemIn[$f]['purchase_number'] = $request->input('purchase-number');
                $itemIn[$f]['cost_price'] = $item['cost-price'];
                $itemIn[$f]['created_at'] = date('Y-m-d H:i:s');
                $itemIn[$f]['updated_at'] = date('Y-m-d H:i:s');
                
                if ($item['with-serial-number'] == 0) {
                    for ($x = 0; $x < $item['qty']; $x++) {
                        $itemIn[$f]['serial_number'] = null;
                    }
                }
                else {
                    $itemIn[$f]['serial_number'] = $item['serial-numbers'][$i];
                }
                $f++;
            }
        }

        ItemIn::insert($itemIn);
        return response()->json(['success'=>true, 'message'=>'Item In is successfully added']);
        // return $itemIn;
        // return $request->input();
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

    public function search(Request $request) {
        // $items = Item::where(DB::raw('concat(name, " ", upc)'), 'LIKE', '%' . $request->input('term') . '%')->get(['id', 'name AS text']);
        $items = Item::where('upc', 'LIKE', '%' . $request->input('term', '') . '%')->get(['id', 'name AS text']);
        // $items = [['id'=>1, 'text'=>'Kingston Flashdrive'], ['id'=>2, 'text'=>'Generic Mousepad (UPC: 8801643718572)'], ['id'=>3, 'text'=>'Radeon RX501']];
        return ['results' => $items];
    }

    public function fetchControlNumber() {
        $query = ItemIn::select(DB::raw("MAX(CASE WHEN purchase_number IS NOT NULL THEN purchase_number END) AS control_number"))->where('branch_id', 1)->get();
        $controlNumber = $query[0]->control_number;

        if (is_null($controlNumber) || empty($controlNumber)) {
            $controlNumber = 'In-00001';
        }
        else {
            $number = substr($controlNumber, 3);
            $increaseNumber = str_pad($number+=1, 5, 0, STR_PAD_LEFT);
            $controlNumber = substr_replace($controlNumber, $increaseNumber, 3);
        }

        return $controlNumber;
    }

    public function a() {
        $query = ItemIn::select();
//         SELECT A.purchase_number, names, GROUP_CONCAT(count)
// FROM
//    (SELECT purchase_number, GROUP_CONCAT(DISTINCT items.name SEPARATOR '\n') AS names, COUNT(items.name) AS count     
//     FROM item_ins
//     JOIN items ON items.id = item_ins.item_id
//    GROUP BY purchase_number) A
// GROUP BY A.purchase_number
    }
    
    public function fetchItemInsData() {
        $data = DB::select(DB::raw("SELECT A.purchase_number, GROUP_CONCAT(CONCAT(count, ' ', names)) AS item FROM
            (SELECT purchase_number, GROUP_CONCAT(DISTINCT items.name ORDER BY item_ins.id DESC SEPARATOR '<br><br>' ) AS names, COUNT(items.name) AS count     
            FROM item_ins
            JOIN items ON items.id = item_ins.item_id 
            GROUP BY purchase_number) A GROUP BY purchase_number"));

        foreach ($data as $key => $val) {
            $data[$key]->action = '
                <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#edit-branch-modal"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="removeItemIn('. $data[$key]->purchase_number . ')" data-toggle="modal" data-target="#remove-branch-modal"><i class="fa fa-trash"></i></button>';
        }

        $itemInData = array('data' => $data);
        echo json_encode($itemInData);
    }
}
