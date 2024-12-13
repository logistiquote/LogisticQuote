@extends('panels.layouts.master')
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Routes</h1>
            <a href="{{ route('route.create') }}"
               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add route
            </a>
        </div>
        <p class="mb-4"> View all your routes</p>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Routes</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="routes_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($routes as $key => $route)
                            <tr>
                                <td><b>{{ $key }}</b></td>
                                <td><b>{{ $route['origin'] }}</b></td>
                                <td><b>{{ $route['destination'] }}</b></td>
                                <td>{{ $route['type'] }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success fa-2x" data-toggle="dropdown">
                                            <i class="fad fa-ellipsis-v-alt"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('route.edit', $route['id']) }}">Edit</a>
                                        </div>
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

@endsection

@section('bottom_scripts')
    <script>
        $(document).ready(function () {
            $('#routes_table').DataTable();
        });
    </script>
@endsection
