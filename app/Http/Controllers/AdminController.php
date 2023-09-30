<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;


class AdminController extends Controller
{
    /**
     * Check if current user is admin.
     *
     * @return Boolean true/false
     */
    private function GetIsAdmin()
    {
        return Auth::id() && Auth::user()->usertype = "1" ? true : false;
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::id() ? Auth::user() : null;
        $isAdmin = $this->GetIsAdmin();
        $departments = Department::all();
        return view("admin.index", compact("user", "isAdmin","departments"));
    }

    public function boot()
    {
        Paginator::useBootstrap();
    }

    public function search(Request $request)
    {
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $phone = $request->input('phone_number');
        $department = $request->input('department');

        $contacts = Contact::query();

        if ($firstName) {
            $contacts->where('first_name', 'like', "%$firstName%");
        }

        if ($lastName) {
            $contacts->where('last_name', 'like', "%$lastName%");
        }

        if ($phone) {
            $contacts->where('phone_number', 'like', "%$phone%");
        }

        if ($department) {
            $contacts->whereHas('departments', function ($query) use ($department) {
                $query->select('department.id')
                    ->where('department.id', $department);
            });
        }

//        $filteredContacts = $contacts->get();
        $filteredContacts = $contacts->paginate(5);

        return view('admin.pages.contact.filtered_results', compact('filteredContacts'));
    }


}
