<div class="content-wrapper pl-3 pr-2">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-md-5 col-sm-12">
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ base_url() . 'adminmedia' }}">
                            <i class="fas fa-tachometer-alt"></i> Home
                        </a>
                    </li>
                    <li class="active">Tasks List</li>
                </ol>
            </div>
            <div class="col-md-7 col-sm-12">
                @include('back.common_views.quicklinks')
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tasks List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        @php
                            $message = session()->get('message', '');
                        @endphp
                        @if (!empty($message))
                            <div class="alert alert-success">
                                {{ $message }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" class="btn btn-info" wire:click="showFilters"
                                    style="display: {{ $show_filter ? 'none' : 'block' }};">Show
                                    Filters</button>
                                <button type="button" class="btn btn-warning" wire:click="hideFilters"
                                    style="display: {{ $show_filter ? 'block' : 'none' }};">Hide
                                    Filters</button>
                            </div>
                            <div class="col-lg-6 text-right">
                                <a wire:navigate href="{{ route('create.task') }}" class="btn btn-success">
                                    <i class="fa-solid fa-add"></i> Create Task
                                </a>
                                <a wire:navigate href="{{ route('sort.tasks') }}" class="btn btn-warning">
                                    <i class="fa-solid fa-bars"></i> Sort Tasks
                                </a>
                            </div>
                        </div>
                        <div class="row" style="display: {{ $show_filter ? 'flex' : 'none' }};">
                            <div class="col-md-3 form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" placeholder="Title"
                                    wire:model.live="title" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="description">Description</label>
                                <input type="text" name="description" id="description" placeholder="Description"
                                    wire:model.live="description" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" wire:model.live="status" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="offset-lg-10 col-lg-2 form-group">
                                <select class="form-control" name="sort_by" id="sort_by" wire:model="sort_by"
                                    wire:change="setAscDesc">
                                    <option value="title-asc">Title(ASC)</option>
                                    <option value="title-desc">Title(DESC)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped table-bordered" style="width: 100%">
                                    <tr>
                                        <th>No.</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th width="150px">Action</th>
                                    </tr>
                                    @foreach ($taskCollection as $taskObj)
                                        <tr>
                                            <td>{{ $taskObj->id }}</td>
                                            <td>{{ $taskObj->title }}</td>
                                            <td>{{ Str::limit(strip_tags($taskObj->description), 100, '...') }}</td>
                                            <td>
                                                @if ($taskObj->status == 1')
                                                    <button class="btn btn-small btn-success"
                                                        wire:click="setInActive({{ $taskObj->id }})">Active</button>
                                                @else
                                                    <button class="btn btn-small btn-secondary"
                                                        wire:click="setActive({{ $taskObj->id }})">Inactive</button>
                                                @endif
                                            </td>
                                            <td>
                                                <a wire:navigate href="{{ route('edit.task', $taskObj->id) }}" class="btn btn-warning">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </a>
                                                <button wire:click="delete({{ $taskObj->id }})" class="btn btn-danger">
                                                    <i class="fa-solid fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-11">
                                {{ $taskCollection->links() }}
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <select name="per_page" id="per_page" class="form-control" wire:model="per_page"
                                        wire:change="setPerPage">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="500">500</option>
                                        <option value="1000">1000</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /. card-body -->
                </div>
                <!-- /.box -->
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
