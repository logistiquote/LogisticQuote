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
            <h1 class="h3 mb-0 text-gray-800">Locations</h1>
            <a href="{{ route('location.import.view') }}"
               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Import Location
            </a>
        </div>
        <p class="mb-4"> View all your locations</p>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Locations</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="locations_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Country</th>
                            <th>Country Code</th>
                            <th>Title</th>
                            <th>Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($locations as $key => $location)
                            <tr>
                                <td><b> {{ $key }} </b></td>
                                <td> {{ $location->country }} </td>
                                <td> {{ $location->country_code }} </td>
                                <td> {{ $location->name }} </td>
                                <td> {{ ucfirst($location->type) }} </td>
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
            $('#locations_table').DataTable();
        });
    </script>
@endsection
