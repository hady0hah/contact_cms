<table class="table table-hover overflow-auto block">
    <thead>
    <tr class="bg-slate-800">
        <th class="font-bold text-white">First Name</th>
        <th class="font-bold text-white">Last Name</th>
        <th class="font-bold text-white">Phone Number</th>
        <th class="font-bold text-white">Birth Date</th>
        <th class="font-bold text-white">City</th>
        <th class="font-bold text-white">Department</th>
        <th class="font-bold text-white">Created At</th>
        <th class="font-bold text-white">Updated At</th>
    </tr>
    </thead>c
    <tbody>
    @if ($filteredContacts->count() > 0)
        @foreach ($filteredContacts as $contact)
            <tr>
                <td>{{ $contact->first_name }}</td>
                <td>{{ $contact->last_name }}</td>
                <td>{{ $contact->phone_number }}</td>
                <td>{{ $contact->DOT }}</td>
                <td>{{ $contact->city }}</td>
                <td>
                    @foreach($contact->departments as $department)
                        {{ $department->name }}
                        @unless($loop->last)
                            ,
                        @endunless
                    @endforeach
                </td>
                <td>{{ $contact->created_at }}</td>
                <td>{{ $contact->updated_at }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">No data available</td>
        </tr>
    @endif
    </tbody>
</table>

<div class="pagination">
    {{ $filteredContacts->links() }}
{{--    {{ $filteredContacts->links('pagination::bootstrap-4') }}--}}
</div>
