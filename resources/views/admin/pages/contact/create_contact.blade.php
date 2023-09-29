<x-admin.index :user="$user" :isAdmin="$isAdmin">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Contact Form</h4>
                        <p class="card-description">Add Contact Info</p>
                        <form action="{{ route('contact.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">First Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="first_name"
                                    name="first_name"
                                    placeholder="Input contact name"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="name">Last Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="last_name"
                                    name="last_name"
                                    placeholder="Input contact name"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="phone_number"
                                    name="phone_number"
                                    placeholder="Enter phone number"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="DOT">Date of Birth</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="DOT"
                                    name="DOT"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="city"
                                    name="city"
                                    placeholder="Enter city"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="departments">Departments</label>
                                <select
                                    id="departments"
                                    name="departments[]"
                                    class="form-control"
                                    multiple
                                >
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                        @if ($isAdmin === true)
                                <button type="submit" class="btn btn-primary mr-2">Add</button>
                            @else
                                <button onclick="alert('Only admin can add contact ')" type="button" class="btn btn-primary mr-2">Add</button>
                            @endif
                            <a href="{{ route("contact.index") }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.index>
