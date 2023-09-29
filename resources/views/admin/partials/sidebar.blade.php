<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a class="nav-link" href="{{ route('admin.index') }}">
        @if ($user !== null)
        <div class="profile-image">
          @if ($user->img)
          <img
            class="img-xs rounded-circle ml-2 cursor-pointer"
            src="{{ $user->img }}"
            alt="Profile image"
          />
          @else
          <i class="fa-solid fa-user pr-2 rounded-circle text-4xl text-black-50 text-white-50"></i>
          @endif
        </div>
        <div class="text-wrapper">
          <p class="profile-name">{{ $user->name }}</p>
          @if ($isAdmin === true)
            <p class="designation">Administrator</p>
          @else
            <p class="designation">General User</p>
          @endif
        </div>
        @else
        <i class="fa-solid fa-user pr-2 rounded-circle text-4xl text-black-50 text-white-50"></i>
        <div class="text-wrapper">
          <p class="profile-name">Guest User</p>
          <p class="designation">Guest</p>
        </div>
        @endif
      </a>
    </li>
    <li class="nav-item nav-category">
      <span class="nav-link">Tables</span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('user.index') }}">
        <span class="menu-title">Users</span>
        <i class="fa-solid fa-users menu-icon"></i>
      </a>
    </li>
      <li class="nav-item">
          <a class="nav-link" href="{{route('department.index')}}">
              <span class="menu-title">Department</span>
              <i class="fa-solid fa fa-building-o menu-icon"></i>
          </a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="{{route('contact.index')}}">
              <span class="menu-title">Contact</span>
              <i class="fa-solid fa fa-address-book menu-icon"></i>
          </a>
      </li>
  </ul>
</nav>
