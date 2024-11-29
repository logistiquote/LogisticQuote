<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> {{ isset($page_title) ? $page_title : 'LogistiQuote' }} </title>

    @include('panels.includes.top_includes')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('index') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fal fa-shipping-fast"></i>
                </div>
                <div class="sidebar-brand-text mx-3">LogistiQuote</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Sidebar Settings -->

            @if(Auth::user()->role == 'vendor')
            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo ($page_name == 'dashboard') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('vendor') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Quotations
            </div>

            <!-- Nav Item - My Quotations -->
            <li
                class="nav-item <?php echo ($page_name == 'quotations' || $page_name == 'add_quotation' || $page_name == 'edit_quotation' || $page_name == 'create_quotation') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('quotations.view_all') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quotations</span></a>
            </li>

            <!-- Nav Item - My proposals -->
            <li class="nav-item <?php echo ($page_name == 'proposals') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('proposal.index') }}">
                    <i class="fad fa-file-signature"></i>
                    <span>Proposals</span></a>
            </li>

            <!-- Nav Item - Profile -->
            <li class="nav-item <?php echo ($page_name == 'profile') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('vendor.profile') }}">
                    <i class="fad fa-user-alt"></i>
                    <span>Profile</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                OTHER
            </div>
            @elseif(Auth::user()->role == 'user')

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo ($page_name == 'dashboard') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('user') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Quotations
            </div>

            <!-- Nav Item - My Quotations -->
            <li
                class="nav-item <?php echo ($page_name == 'quotations' || $page_name == 'add_quotation' || $page_name == 'edit_quotation' || $page_name == 'create_quotation') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('quotation.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quotations</span></a>
            </li>

            <!-- Nav Item - proposals -->
            <li class="nav-item <?php echo ($page_name == 'proposals') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('proposals.received') }}">
                    <i class="fad fa-file-signature"></i>
                    <span>Proposals Received</span>
                </a>
            </li>

            <!-- Nav Item - Profile -->
            <li class="nav-item <?php echo ($page_name == 'profile') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('user.profile') }}">
                    <i class="fad fa-user-alt"></i>
                    <span>Profile</span></a>
            </li>
            
            @elseif(Auth::user()->role == 'admin')

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo ($page_name == 'dashboard') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('admin') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Quotations
            </div>

            <!-- Nav Item - My Quotations -->
            <li
                class="nav-item <?php echo ($page_name == 'quotations' || $page_name == 'add_quotation' || $page_name == 'edit_quotation' || $page_name == 'create_quotation') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('quotations.view_all') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quotations</span></a>
            </li>
            
            <!-- Nav Item - My proposals -->
            <li class="nav-item <?php echo ($page_name == 'proposals') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('proposals.view_all') }}">
                    <i class="fad fa-file-signature"></i>
                    <span>Proposals</span></a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Customers
            </div>

            <!-- Nav Item - My Quotations -->
            <li
                class="nav-item <?php echo ($page_name == 'all_users' || $page_name == 'add_user' || $page_name == 'edit_user' || $page_name == 'admin.view_user') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('admin.all_users') }}">
                    <i class="far fa-users"></i>
                    <span>Users</span></a>
            </li>

            <!-- Nav Item - My Quotations -->
            <li
                class="nav-item <?php echo ($page_name == 'all_vendors' || $page_name == 'add_vendor' || $page_name == 'edit_vendor' ) ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('admin.all_vendors') }}">
                    <i class="far fa-users-crown"></i>
                    <span>Vendors</span></a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                OTHER
            </div>

            <!-- Nav Item - Profile -->
            <li class="nav-item <?php echo ($page_name == 'profile') ? 'active' : ''; ?>">
                <a class="nav-link" href="{{ route('admin.profile') }}">
                    <i class="fad fa-user-alt"></i>
                    <span>Profile</span></a>
            </li>

            @endif



            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); 
            document.getElementById('logout-form').submit();">
                    <i class="fal fa-sign-out"></i>
                    <span>Logout</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('public/uploads/profile_pic/avatar.png') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                @if(Auth::user()->role == 'vendor')
                                <a class="dropdown-item" href="{{ route('vendor.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                @elseif(Auth::user()->role == 'user')
                                <a class="dropdown-item" href="{{ route('user.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                @elseif(Auth::user()->role == 'admin')
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                @endif

                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; LogictiQuote 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('panels.includes.bottom_includes')

    @yield('bottom_scripts')

</body>

</html>
