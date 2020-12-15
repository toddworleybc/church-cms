<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStaff;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
         Paginator::useBootstrap();


        $staffMembers = "";
        $statusType = "position";
        $filter = $request->query('filter') !== 'all' ? $request->query('filter')  : "";
        $orderBy = $request->query('order_by') ?? "created_at";
        $direction = $request->query('direction') ?? "desc";
        $perPage = $this->perPage;


        if($filter) {

            $staffMembers = Staff::where($statusType, $filter)->orderBy($orderBy, $direction)->paginate($perPage);

        } else {
             $staffMembers = Staff::orderBy($orderBy, $direction)->paginate($perPage);
        }


        $staffPositions = Staff::pluck('position')->unique();


        $staffMembers->withQueryString();

        return view('admin.staff.index', compact('staffMembers', 'staffPositions', 'filter', 'orderBy', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        $submittedValues = $request->old();



        return view('admin.staff.create', compact('submittedValues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStaff $request)
    {
        //
        $input = $request->validated();


        // store image and set image path for db
        if($request->hasFile('image'))
            $input['image'] = $this->storeImage($request->file('image'));


        $createdStaffMemeber = Staff::create($input);


       if($createdStaffMemeber) {
            // return redirect()->route('staff.index')->with('success', 'New staff member created');
             return redirect()->back()->with('danger', 'Staff member could not be created');
       } else {
           return redirect()->back()->with('danger', 'Staff member could not be created');
       }

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
    public function edit($id, Request $request)
    {
        //
        $staffMember = Staff::find($id);

        return view('admin.staff.edit', compact('staffMember'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreStaff $request, $id)
    {
        //

        $input = $request->validated();


        $staffMember = Staff::find($id);


        if ($request->hasFile('image'))
                $input['image'] = $this->editStoreImage($staffMember->image, $request->file('image'));


        $staffMemberUpdated = $staffMember->update($input);

        if($staffMemberUpdated) {
           return redirect()->back()->with('success', 'Staff member updated!');
        } else {
            return redirect()->back()-with('danger', 'Failed to update staff member!');
        }

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
        $staffMember = Staff::find($id);


        $deletedStaffMember = $staffMember->delete();


        if($deletedStaffMember) {

            if(Storage::exists($staffMember->image))
                Storage::delete($staffMember->image);

            return redirect()->route('staff.index')->with('success', 'Staff member has been deleted!');

        } else {

            return redirect()->back()->with('danger', 'Failed to delete staff member');

        }

    }
}
