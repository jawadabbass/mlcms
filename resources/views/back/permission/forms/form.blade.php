    @csrf
    <input type="hidden" name="id" value="{{ old('id', $permission->id) }}" />
    <div class="form-group">
        <label for="title">Permission Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $permission->title) }}"
            class="form-control @error('title') is-invalid @enderror" />
        @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="title">Permission Group</label>
        <select name="permission_group_id" id="permission_group_id" class="form-control @error('permission_group_id') is-invalid @enderror">
            {!! generatePermissionGroupsDropDown(old('permission_group_id', $permission->permission_group_id), true) !!}
        </select>
        @error('permission_group_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

