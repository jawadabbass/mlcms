@php
$state_id = $clientObj->state_id > 0 ? $clientObj->state_id : 0;
$city_id = $clientObj->city_id > 0 ? $clientObj->city_id : 0;

$state_id = old('state_id', $state_id);
$city_id = old('city_id', $city_id);
@endphp

@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-tachometer-alt"></i> Home </a></li>
                        <li><a href="{{ admin_url() }}manage_clients">Clients</a></li>
                        <li class="active">Edit Client</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="card p-2">
                        <div class="card-header">
                            <div class="row" style="width: 100%;">
                                <div class="col-md-6">
                                    <h3> Edit Client</h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ url('adminmedia/record-update-history/Client/' . $clientObj->id) }}" target="_blank" class=" mr-4"><i
                                            class="fas fa-bars" aria-hidden="true"></i> History </a>
                                    <a href="{{ url('adminmedia/manage_clients') }}" class=""><i class="fas fa-angle-double-left"
                                            aria-hidden="true"></i> Back </a>
                                </div>
                            </div>
                        </div>
                        <div class=" card-body">
                            <form role="form" method="POST" id="register_action"
                                action="{{ route('client_update_record_store', $clientObj->id) }}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <input type="text" name="first_name" class="form-control"
                                                placeholder="First Name" id="first_name" value="{{ $clientObj->name }}">
                                        </div>
                                        @if ($errors->has('first_name'))
                                            <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <input type="text" name="last_name" class="form-control"
                                                placeholder="Last Name" id="last_name" value="{{ $clientObj->last_name }}">
                                        </div>
                                        @if ($errors->has('last_name'))
                                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <input type="text" name="phone" class="form-control phone_mask" placeholder="Phone"
                                                id="phone_number" value="{{ $clientObj->phone }}">
                                        </div>
                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control" placeholder="Email"
                                                value="{{ $clientObj->email }}" id="email">
                                        </div>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <input type="password" name="password" placeholder="Password*"
                                                class="form-control">
                                        </div>

                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation"
                                                placeholder="Confirm Password*" class="form-control">
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group">
                                            <input type="text" name="address" placeholder="Address" class="form-control"
                                                rows="2" id="address" value="{{ $clientObj->address }}" />
                                        </div>
                                        @if ($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>




                                    <div class="col-md-6 mb-3">
                                        <div id="states_dd_div">
                                            <select class="form-control select2 {{ hasError($errors, 'state_id') }}"
                                                name="state_id" id="state_id" onchange="filterCitiesAjax();">
                                                {!! generateStatesDropDown($state_id, true) !!}
                                            </select>
                                        </div>
                                        @if ($errors->has('state_id'))
                                            <span class="text-danger">{{ $errors->first('state_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div id="cities_dd_div">
                                            <select class="form-control select2 {{ hasError($errors, 'city_id') }}"
                                                name="city_id">
                                                {!! generateCitiesDropDown($city_id, $state_id, true) !!}
                                            </select>
                                        </div>
                                        @if ($errors->has('city_id'))
                                            <span class="text-danger">{{ $errors->first('city_id') }}</span>
                                        @endif
                                    </div>


                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group">
                                            <input type="text" name="zip" placeholder="Zip Code" class="form-control"
                                                rows="2" id="zip" value="{{ $clientObj->zip }}" />
                                        </div>
                                        @if ($errors->has('zip'))
                                            <span class="text-danger">{{ $errors->first('zip') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <label style="margin-top:5px !important;">Date of Birth</label>
                                        <div class="form-group" style="margin-top:-2px !important;">

                                            <input type="date" name="dob" placeholder="Date of Birth"
                                                class="form-control" id="dob" value="{{ $clientObj->dob }}" />
                                        </div>
                                        @if ($errors->has('dob'))
                                            <span class="text-danger">{{ $errors->first('dob') }}</span>
                                        @endif
                                    </div>
                                    <br>


                                    @php
                                        $client_conditions = json_decode($clientObj->conditions);
                                        
                                    @endphp

                                    <div class="col-lg-12 mb-3">
                                        <div class="form-group">

                                            <button type="submit"  id="btnSave" class="btn btn-primary">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('beforeBodyClose')
    <script>
        $(document).ready(function() {
            filterCitiesAjax();
        });
    </script>
@endsection
