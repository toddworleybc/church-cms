<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTeaching;
use App\Models\Teaching;
use App\Models\Staff;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;

class TeachingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Paginator::useBootstrap();



        $teachings = "";
        $statusType = "";
        $filter = $request->query('filter') !== 'all' ? $request->query('filter')  : "";
        $orderBy = $request->query('order_by') ?? "publish_date";
        $direction = $request->query('direction') ?? "desc";
        $perPage = $this->perPage;


        if($filter) {

                if($filter === 'teaching') {
                    $statusType = 'type';

                } elseif ($filter === 'topical') {

                    $statusType = 'type';

                } else {
                    $statusType = 'status';
                }

            $teachings = Teaching::where($statusType, $filter)->orderBy($orderBy, $direction)->paginate($perPage);

        } else {
             $teachings = Teaching::orderBy($orderBy, $direction)->paginate($perPage);
        }


        $teachings->withQueryString();

        return view('admin.teachings.index', compact('teachings', 'filter', 'orderBy', 'direction') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

        $staffMembers = Staff::all();

         // submitted values for form errors to repopulate form
        $submittedValues = $request->old();

        return view('admin.teachings.create', compact('staffMembers', 'submittedValues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeaching $request)
    {




        $input = $request->validated();



// set staff id or speaker for database
        if ($request->has('checkbox_speaker')) {
            $input['staff_id'] = null;
            $request->except('checkbox_speaker');
        } else {
            $input['speaker'] = null;
        }
// set file value
        if($request->hasFile('ft_image'))
            $input['ft_image'] = $this->storeImage($request->file("ft_image"));


// set before and after text values
        if(!$request->has('before_text'))
            $input['before_text'] = null;


        if(!$request->has('after_text'))
            $input['after_text'] = null;


// CREATE TEACHING
       $createdTeaching = Teaching::create($input);

        if($createdTeaching) {

        // Check status to see where to redirect after creating teaching
            if($input['status'] === 'Draft') {

                $url = "admin/teachings/" . $createdTeaching->id . "/edit";

                return redirect($url)->with('success', 'Teaching has been saved');

            } else {

               return redirect()->route('teachings.index')->with('success', 'Teaching has been published');
            }

        } else {
            return redirect()->back()->with('danger', 'Teaching could not be created!');
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
    public function edit($id)
    {

        $teaching = Teaching::find($id);
        $staffMembers = Staff::all();

        return view('admin.teachings.edit', compact('teaching', 'staffMembers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTeaching $request, $id)
    {
        //

        $input = $request->validated();


// set staff id or speaker for database
        if ($request->has('checkbox_speaker')) {
            $input['staff_id'] = null;
            $request->except('checkbox_speaker');
        } else {
            $input['speaker'] = null;
        }


        $teaching = Teaching::find($id);

        if($request->hasFile('ft_image'))
            $input['ft_image'] = $this->editStoreImage($teaching->ft_image, $request->file('ft_image'));


// set before and after text values
        if(!$request->has('before_text'))
            $input['before_text'] = null;


        if(!$request->has('after_text'))
            $input['after_text'] = null;


        $updatedTeaching = $teaching->update($input);

        if($updatedTeaching) {
            return redirect()->back()->with('success', 'Teaching has been updated!');
        } else {
            return redirect()->back()->with('danger', 'Teaching has failed to update!');
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

       $teaching = Teaching::find($id);
       $imagePath = $teaching->ft_image;

        $teachingDestroyed = $teaching->delete();


        if($teachingDestroyed) {

            if(Storage::exists($imagePath))
                Storage::delete($imagePath);

          return redirect()->route('teachings.index')->with('success', 'Teaching has been deleted!');

        } else {

           return redirect()->back()->with('danger', 'Error: Teaching could not be deleted!');

        }

    }



}
