<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemClass;

class ItemClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('itemclass.index');
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
        $itemClass = new ItemClass;
        $itemClass->name = $request->input('name');
        $itemClass->active = $request->input('active');
        $itemClass->save();
        return response()->json(['success'=>true, 'message'=>'Item class is successfully added']);
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
        $itemClass = ItemClass::find($id);
        $itemClass->name = $request->input('edit-name');
        $itemClass->active = $request->input('edit-active');
        $itemClass->save();
        return response()->json(['success'=>true, 'message'=>'Item class is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itemClass = ItemClass::find($id);
        $itemClass->delete();
        return response()->json(['success'=>true, 'message'=>'Item class is successfully deleted']);
    }

    public function fetchItemClassesData() {
        $data = ItemClass::select('id', 'name', 'active')->orderBy('id', 'DESC')->get();

        foreach ($data as $key => $val) {
            $data[$key]->active = ($data[$key]->active === 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';
            $data[$key]->action = '
                <button type="button" class="btn btn-info" onclick="editItemClass('. $data[$key]->id . ')" data-toggle="modal" data-target="#edit-item-class-modal"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="removeItemClass('. $data[$key]->id . ')" data-toggle="modal" data-target="#remove-item-class-modal"><i class="fa fa-trash"></i></button>';
        }

        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function fetchItemClassDataById($id) {
        $data = ItemClass::findOrFail($id);
        echo json_encode($data);
    }
}
