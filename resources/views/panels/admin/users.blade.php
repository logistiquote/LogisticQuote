@extends('panels.layouts.master')
@section('content')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Customers</h1>
    </div>
    <!-- <p class="mb-4"> View status of your users.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                @if($page_name == 'all_users')
                    Users 
                @else
                    Vendors
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
                            @if($page_name == 'all_vendors')
                            <th>Additional Email</th>
                            @endif
                            <th>Phone</th>
                            <th>Company</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td> <b>{{ $user->id }} </b> </td>
                            <td> <b>{{ $user->name }} </b> </td>
                            <td> <b>{{ $user->email }} </b> </td>
                            @if($page_name == 'all_vendors')
                            <td> <b>{{ $user->additional_email }} </b> </td>
                            @endif
                            <td> <b>{{ $user->phone }} </b> </td>
                            <td> <b>{{ $user->company_name }} </b> </td>
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
    $(document).ready( function () {
        $('#users_table').DataTable();
    });
</script>
@endsection