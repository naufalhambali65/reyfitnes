  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ route('home') }}" class="nav-link">Homepage</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block @if (Request::is('dashboard')) active @endif">
              <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
          </li>
          @if ($role == 'admin' || $role == 'super_admin')
              <li
                  class="nav-item d-none d-sm-inline-block {{ Request::is('dashboard/memberships*') ? '' : (Request::is('dashboard/members*') ? 'active' : '') }}">
                  <a href="{{ route('members.index') }}" class="nav-link">Anggota</a>
              </li>
              <li class="nav-item d-none d-sm-inline-block @if (Request::is('dashboard/memberships*')) active @endif">
                  <a href="{{ route('memberships.index') }}" class="nav-link">Paket Membership</a>
              </li>
          @endif
          {{-- <li class="nav-item d-none d-sm-inline-block @if (Request::is('dashboard/banks*')) active @endif">
              <a href="" class="nav-link">Rekening Bank</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block @if (Request::is('dashboard/clients*')) active @endif">
              <a href="" class="nav-link">Clients</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block @if (Request::is('dashboard/teams*')) active @endif">
              <a href="" class="nav-link">Teams</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block @if (Request::is('dashboard/messages*')) active @endif">
              <a href="" class="nav-link">Messages</a>
          </li> --}}

      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
          <li class="nav-item">
              <form action="{{ route('logout') }}" method="post">
                  @csrf
                  <button type="input" class="nav-link border-0 bg-transparent btn-logout">Logout</button>
              </form>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                  <i class="fas fa-expand-arrows-alt"></i>
              </a>
          </li>
      </ul>
  </nav>
  <!-- /.navbar -->
