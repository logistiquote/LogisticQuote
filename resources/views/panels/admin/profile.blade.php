@extends('panels.layouts.master')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <!-- User profile header -->
        <div class="col-md-12 mt-3">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">

                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="profile-header-cover">
                    <!-- Cover Photo Refer to profil-header CSS internal CSS -->
                </div>

                <!-- <div class="widget-user-image">
                        <img class="img-circle" alt="User Avatar">
                    </div> -->

                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">Phone</h5>
                                <span class="text">{{ $profile->phone }}</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header"> Name </h5>
                                <span class="description-text"> {{ $profile->name }} </span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">Email</h5>
                                <span class="text">{{ $profile->email }}</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->

        </div>
    </div>


    <!-- User Profile Settings -->
    <div class="row justify-content-center">
        <div class="col-md-12 mt-3">

            <div class="card mt-5">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Profile
                                Settings</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="#myRoute" data-toggle="tab"> My Route </a></li>
                  <li class="nav-item"><a class="nav-link" href="#preferences" data-toggle="tab">Preferences</a></li> -->
                    </ul>
                </div><!-- /.card-header -->

                <div class="card-body">

                    <div class="tab-content">

                        <!-- /.tab-pane -->

                        <div class="tab-pane active show" id="settings">

                            <form action="{{ route('admin.update_profile') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body col-8 offset-md-2">


                                    <div class="form-group">

                                        <input type="text" name="name" placeholder="Name" value="{{ $profile->name }}"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="email" placeholder="Email"
                                            value="{{ $profile->email }}"
                                            class="form-control @error('email') is-invalid @enderror" disabled>
                                        @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="phone" placeholder="Phone"
                                            value="{{ $profile->phone }}"
                                            class="form-control @error('phone') is-invalid @enderror">
                                        @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="password" placeholder="Password"
                                            valuea="{{ $profile->password }}"
                                            class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>

                                <div class="modal-footer col-10">
                                    <button type="submit" class="btn btn-primary"> Update </button>
                                </div>

                            </form>

                        </div>
                        <!-- /.tab-pane -->

                        <div style="display:none;" class="tab-pane" id="myRoute">
                            <!-- myRoute -->

                            <h4 class="text-center"> Enter your route info </h4>

                            <div class="form-group">
                                <label for="StartingPoint"> Starting point: </label>
                                <input type="text">
                            </div>

                            <div class="form-group">
                                <label for="EndingPoint"> Ending point: </label>
                                <input type="text">
                            </div>

                            <button @click.prevent="showMyRoute" type="submit" class="btn btn-primary my-2"> Show Route
                            </button>
                            <input type="text">

                            <!-- Form values to enter in database -->
                            <form id="routeForm" enctype="multipart/form-data">
                                <!-- @csrf  -->
                                <h3 class="text-center my-5"> Route Info </h3>

                                <div class="form-group">
                                    <label for="startAddr"> Start Address: </label>
                                    <input type="text" id="startAddr" class="form-control"
                                        class="{ 'is-invalid': form.errors.has('startAddr')}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="endAddr"> End Address: </label>
                                    <input type="text" id="endAddr" class="form-control"
                                        class="{ 'is-invalid': form.errors.has('endAddr')}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="distance"> Distance (km): </label>
                                    <input type="text" id="distance" class="form-control"
                                        class="{ 'is-invalid': form.errors.has('distance')}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="duration"> Duration (minutes): </label>
                                    <input type="text" id="duration" class="form-control"
                                        class="{ 'is-invalid': form.errors.has('duration')}" disabled>
                                </div>

                                <div class="form-group">
                                    <input type="text" id="origin" name="origin" class="form-control"
                                        class="{ 'is-invalid': form.errors.has('origin')}" hidden>
                                </div>

                                <div class="form-group">
                                    <input type="text" id="destination" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('destination')}" hidden>
                                </div>

                                <div class="form-group">
                                    <input type="text" id="wayPoints" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('wayPoints')}" hidden>
                                </div>

                                <div class="form-group">
                                    <input type="text" id="stops" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('stops')}" hidden>
                                </div>

                                <button type="submit" class="btn btn-primary"> Update Directions </button>
                            </form>
                            <!-- /.myRoute -->
                        </div>

                        <!-- /.tab-pane -->
                        <div style="display:none;" class="tab-pane" id="preferences">
                            <!-- The preferences -->

                            <form enctype="multipart/form-data">

                                <h4 class="text-center"> Timing </h4>

                                <div class="form-group">
                                    <label for="departure_time"> Departure Time: </label>
                                    <input type="time" name="departure_time" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('departure_time') }">
                                </div>

                                <div class="form-group">
                                    <label for="arrival_time"> Arrival Time: </label>
                                    <input type="time" name="arrival_time" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('arrival_time') }">
                                </div>


                                <h4 class="text-center"> Other </h4>

                                <div class="form-group">
                                    <select name="v_type" value="Select Vehicle Type" class="form-control"
                                        class="{ 'is-invalid': form.errors.has('v_type') }">
                                        <option value="car">Car</option>
                                        <option value="van">Van</option>
                                        <option value="bus">Bus</option>
                                    </select>
                                    <has-error form="form" field="v_type"></has-error>
                                </div>


                                <button type="submit" class="btn btn-primary"> Set Preferences </button>

                            </form>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>

        </div>
    </div>

</div>

@endsection
