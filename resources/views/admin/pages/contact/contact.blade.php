<x-admin.index :user="$user" :isAdmin="$isAdmin">
    <div class="content-wrapper">
        <a href="{{ route('contact.create') }}" class="btn btn-primary mx-2">Add New Contact</a>
    </div>

    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Contact Data-Table</h4>
                    <p class="card-description">
                        Contact information table
                    </p>

                    @if(session()->has('msg'))
                        <p class="alert alert-info">{{ session()->get('msg') }}</p>
                    @endif

                    <table class="table table-hover overflow-auto block">
                        <thead>
                        <tr class="bg-slate-800">
                            @foreach(["Name" , "Created At","Updated At", "Action"] as $heading)
                                <th class="font-bold text-white">{{$heading}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $data)
                            <tr>
                                <td>{{$data->first_name}}</td>
                                <td>{{$data->created_at}}</td>
                                <td>{{$data->updated_at}}</td>
                                <td>
                                    <a
                                        href="{{ route('contact.edit', $data->id) }}"
                                        class="badge badge-primary cursor-pointer"
                                    >Edit</a
                                    >
                                </td>
                                <td>
                                    @if ($isAdmin === true)
                                        <form method="POST" action="{{ route('contact.destroy', $data->id) }}">
                                            @method('DELETE')
                                            @csrf

                                            <button
                                                type="submit"
                                                class="badge badge-danger cursor-pointer"
                                                onclick="return confirmDeleteContact({{ $data->id }} , '{{ $data->name }}');"
                                            >Delete</button>
                                        </form>
                                    @else
                                        <button
                                            onclick="alert('Only admin can delete food menu')"
                                            class="badge badge-danger cursor-pointer"
                                        >Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDeleteContact(id, name) {
            if(!confirm("Are You Sure to delete this contact , Named: " + name + ", Id: " + id + "." ))
                event.preventDefault();
        }
    </script>
</x-admin.index>
