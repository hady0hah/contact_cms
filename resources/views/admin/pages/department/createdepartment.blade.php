<x-admin.index :user="$user" :isAdmin="$isAdmin">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Department Form</h4>
                        <p class="card-description">Add Department Info</p>
                        <form action="{{ route('department.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="name"
                                    name="name"
                                    placeholder="Input department name"
                                    required
                                />
                            </div>

                                                        @if ($isAdmin === true)
                                <button type="submit" class="btn btn-primary mr-2">Add</button>
                            @else
                                <button onclick="alert('Only admin can add department ')" type="button" class="btn btn-primary mr-2">Add</button>
                            @endif
                            <a href="{{ route("department.index") }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.index>
