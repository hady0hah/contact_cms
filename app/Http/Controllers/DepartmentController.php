<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends  Controller
{
    /**
     * Check if current user is admin.
     *
     * @return Boolean true/false
     */
    public function GetIsAdmin()
    {
        return Auth::id() && Auth::user()->usertype = "1" ? true : false;
    }

    /**
     * Display Department Entry
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Department::all();
        $user = Auth::id() ? Auth::user() : null;
        $isAdmin = $this->GetIsAdmin();
        return view("admin.pages.department.department", compact("data", "isAdmin", "user"));
    }

    /**
     * Show the form for creating a new department entry.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::id() ? Auth::user() : null;
        $isAdmin = $this->GetIsAdmin();
        return view("admin.pages.department.createdepartment", compact("user", "isAdmin"));
    }

    /**
     * Store a newly created testimonial entry in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isAdmin = $this->GetIsAdmin();
        if($isAdmin === true){

            $data = new Department();
            $data->name = $request->name;

            $data->save();

            return redirect()->route('department.index')->with('msg', 'New entry created');
        }
        return redirect()->route('department.index')->with('msg', "Can't create entry" );
    }


    /**
     * Show the form for editing the specified department entry.
     *
     * @param  $department->id
     * @return \Illuminate\Http\Response
     */
    public function edit($department)
    {
        $data = Department::findOrFail($department);
        $user = Auth::id() ? Auth::user() : null;
        $isAdmin = $this->GetIsAdmin();
        return view("admin.pages.department.editdepartment", compact("data", "user", "isAdmin"));
    }


    /**
     * Update the specified entry in storage.
     *
     * @param  \Illuminate\Http\Request  $request
         * @param  $department->id
     * @return \Illuminate\Http\Response
     */
    public function update($department ,Request $request)
    {
        $isAdmin = $this->GetIsAdmin();
        if($isAdmin === true){
            $data = Department::findOrFail($department);

            $data->name = $request->name;

            $data->save();

            return redirect()->route('department.index')->with('msg', 'Department entry was edited !');
        }
        return redirect()->route('department.index')->with('msg', "Can't edit Department !" );
    }

    /**
     * Remove the specified department entry from storage.
     *
     * @param  $department->id
     * @return \Illuminate\Http\Response
     */
    public function destroy($department)
    {
        $isAdmin = $this->GetIsAdmin();
        if($isAdmin === true){
            $data = Department::findOrFail($department);
            $data -> delete();
            return redirect() -> back()->with('msg', 'Department entry deleted successfully');
        }
        return redirect()->route('department.index')->with('msg', "Can't Department entry" );
    }
}
