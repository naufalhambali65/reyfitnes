  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('dashboard') }}" class="brand-link">
          <img src="{{ asset('homepage_assets/img/logo/logo.png') }}" alt="ReyFitnes Logo"
              style="width:80%; height:auto; object-fit:contain;">
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="/homepage_assets/img/default-profil.png" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block text-decoration-none">{{ auth()->user()->name }}</a>
              </div>
          </div>
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item">
                      <a href="{{ route('dashboard') }}"
                          class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-bars"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>
                  <li class="nav-header">Menu</li>
                  @if ($role == 'admin' || $role == 'super_admin')
                      <li class="nav-item">
                          <a href="{{ route('members.index') }}"
                              class="nav-link  {{ Request::is('dashboard/memberships*') ? '' : (Request::is('dashboard/members*') ? 'active' : '') }}">
                              <i class="nav-icon fas fa-user-friends"></i>
                              <p>
                                  Anggota
                              </p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('memberships.index') }}"
                              class="nav-link {{ Request::is('dashboard/memberships*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-tags"></i>
                              <p>
                                  Paket Membership
                              </p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('payments.index') }}"
                              class="nav-link {{ Request::is('dashboard/payments*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-credit-card"></i>
                              <p>
                                  Pembayaran
                              </p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('attendances.index') }}"
                              class="nav-link {{ Request::is('dashboard/attendances*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-user-check"></i>
                              <p>
                                  Kehadiran
                              </p>
                          </a>
                      </li>
                  @endif
                  @if ($role = 'super_admin')
                      <li class="nav-item">
                          <a href="{{ route('banks.index') }}"
                              class="nav-link {{ Request::is('dashboard/banks*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-university"></i>
                              <p>
                                  Rekening Bank
                              </p>
                          </a>
                      </li>
                  @endif
                  <li class="nav-item">
                      <a href="#" class="nav-link {{ Request::is('dashboard/projects/*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-pencil-ruler"></i>
                          <p>
                              Projects
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link {{ Request::is('dashboard/clients*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-briefcase"></i>
                          <p>
                              Clients
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link {{ Request::is('dashboard/teams*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-users"></i>
                          <p>
                              Teams
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link {{ Request::is('dashboard/messages*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-envelope"></i>
                          <p>
                              Messages
                              {{-- @if ($newMessage)
                                  <span class="badge badge-danger right">{{ $newMessage }}</span>
                              @endif --}}
                          </p>
                      </a>
                  </li>
                  <li class="nav-header">User Setting</li>
                  <li class="nav-item">
                      <a href="#"
                          class="nav-link {{ Request::is('dashboard/changePassword*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-user-lock"></i>
                          <p>
                              Change Password
                          </p>
                      </a>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
