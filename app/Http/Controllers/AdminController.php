<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;


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

    public function exportContacts()
    {
        $contacts = Contact::all();

        $csvData = [];
        $csvData[] = ['first_name', 'last_name', 'phone_number', 'birthdate', 'city','department_id'];

        foreach ($contacts as $contact) {
            $departmentIds = $contact->departments->pluck('id')->implode(', ');

            $csvData[] = [
                $contact->first_name,
                $contact->last_name,
                $contact->phone_number,
                $contact->DOT,
                $contact->city,
                $departmentIds,
            ];
        }
        $fileDate = new \DateTime(date('Y/m/d H:i:s'));
        $fileDate = $fileDate->format('Y-m-d-H-i-s');
        $csvFileName = "contacts_$fileDate.csv";

        $csvFilePath = storage_path('app/public/' . $csvFileName);
        $csvFile = fopen($csvFilePath, 'w');

        foreach ($csvData as $row) {
            fputcsv($csvFile, $row);
        }


        fclose($csvFile);

        return Response::download($csvFilePath, $csvFileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ]);
    }

    public function importContacts(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $csvFile = $request->file('csv_file');

        $csvData = array_map('str_getcsv', file($csvFile));

        array_shift($csvData);


        foreach ($csvData as $row) {
            $contact = Contact::create([
                'first_name' => $row[0],
                'last_name' => $row[1],
                'phone_number' => $row[2],
                'DOT' => $row[3],
                'city' => $row[4],
            ]);
            if (!empty($row[5])) {
                $departmentIds = explode(',', $row[5]);
                $contact->departments()->sync($departmentIds);
            }
        }

        return redirect()->route('admin.index')->with('success', 'Contacts imported successfully.');
    }

}
