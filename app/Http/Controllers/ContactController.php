<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Department;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends  Controller
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
     * Display Contact Entry
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Contact::all();
        $user = Auth::id() ? Auth::user() : null;
        $isAdmin = $this->GetIsAdmin();
        return view("admin.pages.contact.contact", compact("data", "isAdmin", "user"));
    }

    /**
     * Show the form for creating a new contact entry.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::id() ? Auth::user() : null;
        $isAdmin = $this->GetIsAdmin();
        $departments = Department::all();
        return view("admin.pages.contact.create_contact", compact("user", "isAdmin","departments"));
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

            $data = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:255',
                'DOT' => 'required|date',
                'city' => 'required|string|max:255',
                'departments' => 'array',
            ]);

            // Create the contact
            $contact = Contact::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone_number' => $data['phone_number'],
                'DOT' => $data['DOT'],
                'city' => $data['city'],
            ]);

            // Attach departments to the contact
            $contact->departments()->attach($data['departments']);

            return redirect()->route('contact.index')->with('msg', 'New entry created');
        }
        return redirect()->route('contact.index')->with('msg', "Can't create entry" );
    }


    /**
     * Show the form for editing the specified contact entry.
     *
     * @param  $contact->id
     * @return \Illuminate\Http\Response
     */
    public function edit($contact)
    {
        $data = Contact::findOrFail($contact);
        $user = Auth::id() ? Auth::user() : null;
        $isAdmin = $this->GetIsAdmin();
        $departments = Department::all();
        return view("admin.pages.contact.edit_contact", compact("data", "user", "isAdmin","departments"));
    }


    /**
     * Update the specified entry in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $contact->id
     * @return \Illuminate\Http\Response
     */
    public function update($contactId, Request $request)
    {
        $isAdmin = $this->GetIsAdmin();

        if ($isAdmin === true) {
            $data = Contact::findOrFail($contactId);

            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->phone_number = $request->phone_number;
            $data->DOT = $request->DOT;
            $data->city = $request->city;
            $data->save();

            // Sync the associated departments
            $data->departments()->sync($request->departments);

            return redirect()->route('contact.index')->with('msg', 'Contact entry was edited!');
        }

        return redirect()->route('contact.index')->with('msg', "Can't edit Contact!");
    }

    /**
     * Remove the specified contact entry from storage.
     *
     * @param  $contact->id
     * @return \Illuminate\Http\Response
     */
    public function destroy($contact)
    {
        $isAdmin = $this->GetIsAdmin();
        if($isAdmin === true){
            $data = Contact::findOrFail($contact);
            $data -> delete();
            return redirect() -> back()->with('msg', 'Contact entry deleted successfully');
        }
        return redirect()->route('contact.index')->with('msg', "Can't Contact entry" );
    }
}
