<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('branch.index');
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
        $branch = new Branch;
        $branch->address = $request->input('address');
        $branch->contact_number = $request->input('contact-number');
        $branch->active = $request->input('active');
        $branch->save();
        return response()->json(['success'=>true, 'message'=>'Branch is successfully added']);
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
        $branch = Branch::find($id);
        $branch->address = $request->input('edit-address');
        $branch->contact_number = $request->input('edit-contact-number');
        $branch->active = $request->input('edit-active');
        $branch->save();
        return response()->json(['success'=>true, 'message'=>'Branch is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();
        return response()->json(['success'=>true, 'message'=>'Branch is successfully deleted']);
    }

    public function fetchBranchesData() {
        $data = Branch::select('id', 'address', 'contact_number', 'active')->orderBy('id', 'DESC')->get();

        foreach ($data as $key => $val) {
            $data[$key]->active = ($data[$key]->active === 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';
            $data[$key]->action = '
                <button type="button" class="btn btn-info" onclick="editBranch('. $data[$key]->id . ')" data-toggle="modal" data-target="#edit-branch-modal"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="removeBranch('. $data[$key]->id . ')" data-toggle="modal" data-target="#remove-branch-modal"><i class="fa fa-trash"></i></button>';
        }

        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function fetchBranchDataById($id) {
        $branch = Branch::findOrFail($id);
        echo json_encode($branch);
    }
}
