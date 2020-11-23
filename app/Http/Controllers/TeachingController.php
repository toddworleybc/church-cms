<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTeaching;
use App\Models\Teaching;

class TeachingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $teachings = Teaching::all();

        return view('admin.teachings.index', compact('teachings') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.teachings.create');
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

        if($request->hasFile('ft_image'))
            $input['ft_image'] = $this->storeImage($request->file("ft_image"));


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

        return view('admin.teachings.edit', compact('teaching'));

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


        $teaching = Teaching::find($id);

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
    }

    // returns file name for database storage

    private function storeImage($imageFile) {


        if($imageFile->isValid()) {

          $path = $imageFile->store('images');

          return $path;

        }

        return false;

    }

}
