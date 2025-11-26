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
                  <li class="nav-item">
                      <a href="{{ route('notifications.index') }}"
                          class="nav-link {{ Request::is('dashboard/notifications*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-bell"></i>
                          <p>Notifikasi</p>
                      </a>
                  </li>
                  <li class="nav-item
                        @if (Request::is('dashboard/classes*') |
                                Request::is('dashboard/trainers*') |
                                Request::is('dashboard/class-categories*') |
                                Request::is('dashboard/class-bookings*')) menu-open @endif">
                      <a href="#"
                          class="nav-link
                            @if (Request::is('dashboard/classes*') |
                                    Request::is('dashboard/trainers*') |
                                    Request::is('dashboard/class-categories*') |
                                    Request::is('dashboard/class-bookings*')) active @endif">
                          <i class="nav-icon fas fa-dumbbell"></i>
                          <p>Management Kelas</p>
                          <i class="fas fa-angle-left right"></i>
                      </a>

                      <ul class="nav nav-treeview">

                          <li class="nav-item">
                              <a href="{{ route('classes.index') }}"
                                  class="nav-link {{ Request::is('dashboard/classes*') ? 'active' : '' }}  ps-5 ">
                                  <i class="nav-icon fas fa-dumbbell"></i>
                                  <p>Kelas</p>
                              </a>
                          </li>

                          {{-- Tambahan: Instruktur --}}
                          <li class="nav-item">
                              <a href="{{ route('trainers.index') }}"
                                  class="nav-link {{ Request::is('dashboard/trainers*') ? 'active' : '' }} ps-5">
                                  <i class="far fa-user nav-icon"></i>
                                  <p>Instruktur</p>
                              </a>
                          </li>

                          {{-- Tambahan: Kategori Kelas --}}
                          <li class="nav-item">
                              <a href="{{ route('class-categories.index') }}"
                                  class="nav-link {{ Request::is('dashboard/class-categories*') ? 'active' : '' }} ps-5">
                                  <i class="far fa-list-alt nav-icon"></i>
                                  <p>Kategori Kelas</p>
                              </a>
                          </li>

                          {{-- Tambahan: Booking Kelas --}}
                          <li class="nav-item">
                              <a href="{{ route('class-bookings.index') }}"
                                  class="nav-link {{ Request::is('dashboard/class-bookings*') ? 'active' : '' }} ps-5">
                                  <i class="far fa-calendar-check nav-icon"></i>
                                  <p>Booking Kelas</p>
                              </a>
                          </li>

                      </ul>
                  </li>

                  {{-- <li class="nav-item">
                      <a href="{{ route('classes.index') }}"
                          class="nav-link {{ Request::is('dashboard/classes*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-dumbbell"></i>
                          <p>Kelas</p>
                      </a>
                  </li> --}}
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
                      <a href="#" class="nav-link {{ Request::is('dashboard/messages*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-envelope"></i>
                          <p>
                              Pesan
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
