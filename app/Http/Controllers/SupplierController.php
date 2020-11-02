<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier.index');
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
        $supplier = new Supplier;
        $supplier->name = $request->input('name');
        $supplier->address = $request->input('address');
        $supplier->contact_number = $request->input('contact-number');
        $supplier->active = $request->input('active');
        $supplier->save();
        return response()->json(['success'=>true, 'message'=>'Supplier is successfully added']);
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
        $supplier = Supplier::find($id);
        $supplier->name = $request->input('edit-name');
        $supplier->address = $request->input('edit-address');
        $supplier->contact_number = $request->input('edit-contact-number');
        $supplier->active = $request->input('edit-active');
        $supplier->save();
        return response()->json(['success'=>true, 'message'=>'Supplier is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        return response()->json(['success'=>true, 'message'=>'Supplier is successfully deleted']);
    }

    public function fetchSuppliersData() {
        $data = Supplier::select('id', 'name', 'address', 'contact_number', 'active')->orderBy('id', 'DESC')->get();

        foreach ($data as $key => $val) {
            $data[$key]->active = ($data[$key]->active === 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';
            $data[$key]->action = '
                <button type="button" class="btn btn-info" onclick="editSupplier('. $data[$key]->id . ')" data-toggle="modal" data-target="#edit-supplier-modal"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="removeSupplier('. $data[$key]->id . ')" data-toggle="modal" data-target="#remove-supplier-modal"><i class="fa fa-trash"></i></button>';
        }

        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function fetchSupplierDataById($id) {
        $data = Supplier::findOrFail($id);
        echo json_encode($data);
    }
}
