@extends('panels.layouts.master')
@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Customers</h1>
        </div>

        @if(Auth::user()->role === 'admin')
            <form method="GET" action="{{ route('users.list') }}" id="filter-form" class="mb-2">
                <div class="row">
                    <div class="col-md-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Filter by Name" value="{{ request('name') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Filter by Email" value="{{ request('email') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" id="date_from" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" id="date_to" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary mr-2">Filter</button>
                        <button type="button" class="btn btn-success" id="export-btn">Export</button>
                    </div>
                </div>
            </form>
        @endif

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    @if($page_name == 'all_users')
                        Users
                    @endif
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="users_table" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Company</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><b>{{ $user->id }} </b></td>
                                <td><b>{{ $user->name }} </b></td>
                                <td><b>{{ $user->email }} </b></td>
                                <td><b>{{ $user->phone }} </b></td>
                                <td><b>{{ $user->company_name }} </b></td>
                                <td>
                                    <div class="dropdown">
                                        <a class=" btn btn-primary fa-2x"
                                           href="{{ route('admin.view_user', $user->id) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('bottom_scripts')
    <script>
        document.getElementById('export-btn').addEventListener('click', function() {
            let form = document.getElementById('filter-form');
            form.action = "{{ route('export.users') }}";
            form.submit();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#users_table').DataTable();
        });
    </script>
@endsection
