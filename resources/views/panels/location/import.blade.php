@extends('panels.layouts.master')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
                <div class="card mt-5">
                    <div class="tab-content">
                        <form action="{{ route('location.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body col-8 offset-md-2">
                                <!-- Type Field -->
                                <div class="form-group">
                                    <label for="type">Select Type*</label>
                                    <select name="type" id="type"
                                            class="form-control @error('type') is-invalid @enderror" required>
                                        <option value="">Select Type</option>
                                        <option value="water" {{ old('type') === 'water' ? 'selected' : '' }}>Water
                                        </option>
                                    </select>
                                    @error('type')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- File Upload Field -->
                                <div class="form-group">
                                    <label for="file">Upload CSV File*</label>
                                    <input type="file" name="file" id="file" accept=".csv, .txt"
                                           class="form-control @error('file') is-invalid @enderror" required>
                                    @error('file')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-footer col-10">
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
