<x-admin.index :user="$user" :isAdmin="$isAdmin">
    <div class="content-wrapper">
        <a href="{{ route('department.create') }}" class="btn btn-primary mx-2">Add New Department</a>
    </div>

    <div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Department Data-Table</h4>
                    <p class="card-description">
                        Department information table
                    </p>

                    @if(session()->has('msg'))
                        <p class="alert alert-info">{{ session()->get('msg') }}</p>
                    @endif

                    <table class="table table-hover overflow-auto block">
                        <thead>
                        <tr class="bg-slate-800">
                            @foreach(["Name"] as $heading)
                                <th class="font-bold text-white">{{$heading}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $data)
                            <tr>
                                <td>{{$data->name}}</td>
                                <td>
                                    <a
                                        href="{{ route('department.edit', $data->id) }}"
                                        class="badge badge-primary cursor-pointer"
                                    >Edit</a
                                    >
                                </td>
                                <td>
                                    @if ($isAdmin === true)
                                        <form method="POST" action="{{ route('department.destroy', $data->id) }}">
                                            @method('DELETE')
                                            @csrf

                                            <button
                                                type="submit"
                                                class="badge badge-danger cursor-pointer"
                                                onclick="return confirmDeleteDepartment({{ $data->id }} , '{{ $data->name }}');"
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
        function confirmDeleteDepartment(id, name) {
            if(!confirm("Are You Sure to delete this department , Named: " + name + ", Id: " + id + "." ))
                event.preventDefault();
        }
    </script>
</x-admin.index>
