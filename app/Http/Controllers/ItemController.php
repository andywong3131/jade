<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('item.index');
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
        $item = new Item;
        $item->name = $request->input('name');
        $item->upc = $request->input('upc');
        $item->price = $request->input('price');
        $item->with_serial_number = $request->input('with-serial-number');
        $item->active = $request->input('active');
        $item->save();
        return response()->json(['success'=>true, 'message'=>'Item is successfully added']);
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
        $item = Item::find($id);
        $item->name = $request->input('edit-name');
        $item->upc = $request->input('edit-upc');
        $item->price = $request->input('edit-price');
        $item->with_serial_number = $request->input('edit-with-serial-number');
        $item->active = $request->input('edit-active');
        $item->save();
        return response()->json(['success'=>true, 'message'=>'Item is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        return response()->json(['success'=>true, 'message'=>'Item is successfully deleted']);
    }

    public function fetchItemsData() {
        $data = Item::select('items.id', 'items.name', 'upc', 'price', 'items.active')->orderBy('id', 'DESC')->get();

        foreach ($data as $key => $val) {
            $data[$key]->active = ($data[$key]->active === 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';
            $data[$key]->action = '
                <button type="button" class="btn btn-info" onclick="editItem('. $data[$key]->id . ')" data-toggle="modal" data-target="#edit-item-modal"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="removeItem('. $data[$key]->id . ')" data-toggle="modal" data-target="#remove-item-modal"><i class="fa fa-trash"></i></button>';
        }

        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function fetchItemDataById($id) {
        $data = Item::findOrFail($id);
        echo json_encode($data);
    }
}
