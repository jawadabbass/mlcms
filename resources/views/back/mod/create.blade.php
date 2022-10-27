@extends('back.layouts.app', ['title' => $title])
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"><i class="fa-solid fa-gauge"></i> Home</a></li>
                        <li class="active">Manage Admin Users</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (\Session::has('update_action'))
                    <div class="message-container">
                        <div class="callout callout-success">
                            <h4>New admin user has been added successfully.</h4>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Add New Admin User</h3>
                        </div>
                        <form role="form" method="post" action="{{ route('admin.store') }}">
                            @csrf
                            <div class="box-body">
                                <div class="mb-2">
                                    <label for="admin_name">Name</label>
                                    <input type="text" class="form-control" id="admin_name" name="admin_name" required
                                        value="{{ old('admin_name') }}">
                                </div>
                                <div class="mb-2">
                                    <label for="admin_email">Email</label>
                                    <input type="text" class="form-control" id="admin_email" name="admin_email" required
                                        value="{{ old('admin_email') }}">
                                </div>
                                <div class="mb-2">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        value="{{ old('password') }}">
                                </div>
                                <div class="mb-2">
                                    <label for="type">type</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value="super-admin">Super Level</option>
                                        <option value="normal-admin">Mid Level</option>
                                    </select>
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" name="save" value="Add User" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </aside>
@endsection
