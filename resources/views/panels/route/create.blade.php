@extends('panels.layouts.master')
@section('content')

    <div class="row">
        <div class="col-xl-10 col-md-12 mb-4 offset-md-1">
            <div class="card shadow">
                <h5 class="card-header">Create Route</h5>
                <div class="card-body">
                    <form action="{{ route('route.store') }}" method="POST">
                        @csrf

                        <!-- Route Details -->
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <h5><b>Origin*</b></h5>
                                <select name="origin_id" class="form-control @error('origin_id') is-invalid @enderror"
                                        required>
                                    <option value="" disabled selected>Select Origin</option>
                                    @foreach($locations as $origin)
                                        <option value="{{ $origin->id }}">{{ $origin->full_location }}</option>
                                    @endforeach
                                </select>
                                @error('origin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <h5><b>Destination*</b></h5>
                                <select name="destination_id"
                                        class="form-control @error('destination_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select Destination</option>
                                    @foreach($locations as $destination)
                                        <option
                                            value="{{ $destination->id }}">{{ $destination->full_location }}</option>
                                    @endforeach
                                </select>
                                @error('destination_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <h5><b>Route Type*</b></h5>
                                <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select Route Type</option>
                                    <option value="water">Water</option>
                                </select>
                                @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Containers -->
                        <h5 class="mt-4"><b>Containers</b></h5>
                        <table class="table table-bordered" id="container_table">
                            <thead>
                            <tr>
                                <th>Type*</th>
                                <th>Price*</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary btn-sm mb-3" id="add_container">Add Container
                        </button>

                        <div class="form-row mt-4">
                            <div class="col-md-12 text-left">
                                <button type="submit" class="btn btn-success">Create Route</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_scripts')
    <script>
        let containerIndex = 1;
        const allContainerTypes = @json($containerTypes);
        let availableContainerTypes = [...allContainerTypes];

        // Initialize: Remove pre-selected types from availableContainerTypes
        document.querySelectorAll('.container-type').forEach(select => {
            const selectedValue = select.value;
            if (selectedValue) {
                availableContainerTypes = availableContainerTypes.filter(type => type !== selectedValue);
            }
        });

        // Add new container row
        document.getElementById('add_container').addEventListener('click', function () {
            if (availableContainerTypes.length === 0) {
                alert('No more container types available.');
                return;
            }

            const table = document.getElementById('container_table').querySelector('tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
            <tr>
                <td>
                    <select name="containers[${containerIndex}][type]" class="form-control container-type" required>
                        <option value="" disabled selected>Select Container Type</option>
                        ${availableContainerTypes.map(type => `<option value="${type}">${type}</option>`).join('')}
                    </select>
                </td>
                <td>
                    <input type="number" name="containers[${containerIndex}][price]" class="form-control" placeholder="Price" step="0.01" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-container">Remove</button>
                </td>
            </tr>
        `;
            table.appendChild(newRow);
            containerIndex++;
        });

        // Handle container type selection
        document.getElementById('container_table').addEventListener('change', function (e) {
            if (e.target.classList.contains('container-type')) {
                const selectedType = e.target.value;
                availableContainerTypes = availableContainerTypes.filter(type => type !== selectedType);

                // Disable selected type in all other dropdowns
                document.querySelectorAll('.container-type').forEach(select => {
                    if (select !== e.target) {
                        const option = select.querySelector(`option[value="${selectedType}"]`);
                        if (option) option.disabled = true;
                    }
                });
            }
        });

        // Remove container row and return type to available list
        document.getElementById('container_table').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-container')) {
                const row = e.target.closest('tr');
                const select = row.querySelector('.container-type');
                const removedType = select.value;

                if (removedType) {
                    availableContainerTypes.push(removedType);
                    availableContainerTypes.sort(); // Keep types sorted
                }

                row.remove();

                // Re-enable the removed type in all dropdowns
                document.querySelectorAll('.container-type').forEach(select => {
                    const option = select.querySelector(`option[value="${removedType}"]`);
                    if (option) option.disabled = false;
                });
            }
        });
    </script>
@endsection
