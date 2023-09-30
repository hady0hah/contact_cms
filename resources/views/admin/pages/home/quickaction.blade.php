<div class="row quick-action-toolbar">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-header d-block d-md-flex">
        <h5 class="mb-0">Quick Actions<i class="fas fa-tasks"></i></h5>
      </div>
      <div class="d-md-flex row m-0 quick-action-btns" role="group" aria-label="Quick action buttons">
        <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
          <a class="btn px-0" href="{{ route('department.create')}}"> <i class="fa-solid fa fa-building-o mr-2"></i> Add Department</a>
        </div>
        <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
          <a class="btn px-0" href="{{ route('contact.create')}}"><i class="fa-solid fa-users mr-2"></i>Add Contact</a>
        </div>
      </div>
    </div>

      <div class="card">
          <div class="card-header d-block d-md-flex">
              <h5 class="mb-0">Search Contacts <i class="fa fa-search" aria-hidden="true"></i></h5>

              <form id="search-form" class="d-flex justify-content-between align-items-center flex-wrap pl-2">
                  <div class="form-row">
                      <div class="col-md-3">
                          <input type="text" class="form-control" id="first-name-input" placeholder="Search by First Name">
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control" id="last-name-input" placeholder="Search by Last Name">
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control" id="phone-input" placeholder="Search by Phone Number">
                      </div>
                      <div class="col-md-3">
                          <select id="department-filter" class="form-control">
                              <option value="">Filter by Department</option>
                              @foreach ($departments as $department)
                                  <option value="{{ $department->id }}">{{ $department->name }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <button type="button" id="search-button" class="btn btn-primary ml-2">
                      Search <i class="fa fa-search" aria-hidden="true"></i>
                  </button>
              </form>
          </div>
      </div>


      <div class="card">
          <div id="filtered-results">

          </div>
      </div>

  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        jQuery(document).ready(function () {
        $('#search-button').click(function () {
            var firstName = $('#first-name-input').val();
            var lastName = $('#last-name-input').val();
            var phone = $('#phone-input').val();
            var department = $('#department-filter').val();
            console.log(firstName,lastName,phone,department)

            $.ajax({
                url: '{{ route("contacts.search") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    first_name: firstName,
                    last_name: lastName,
                    phone_number: phone,
                    department: department
                },
                success: function (data) {
                    $('#filtered-results').html(data);
                },
                error: function (xhr, status, error) {
                    $('#filtered-results').html('<h5>No Data</h5>');
                }
            });
        });
    });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#filtered-results').html(data);
                },
                error: function(xhr, status, error) {
                    $('#filtered-results').html('<h5>No Data</h5>');
                }
            });
        });

</script>
