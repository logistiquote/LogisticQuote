@extends('panels.layouts.master')
@section('content')
    <div class="container-fluid">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Activity Logs</h1>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quotations</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="activity_table" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Log Name</th>
                            <th>Event</th>
                            <th>Affected Model</th>
                            <th>User</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activities as $index => $activity)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $activity->log_name ?? 'N/A' }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($activity->event ?? 'unknown') }}</span></td>
                                <td>{{ class_basename($activity->subject_type) ?? 'N/A' }}</td>
                                <td>{{ $activity->causer ? $activity->causer->name : 'System' }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
