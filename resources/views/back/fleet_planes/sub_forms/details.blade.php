<div class="row">
    <div class="col-lg-12 mb-3">
        <label class="form-label">Fleet Category:*</label>
        <select class="form-control" name="fleet_category_id" id="fleet_category_id">
            {!! generateFleetCategoriesDropDown($fleetPlaneObj->fleet_category_id, false) !!}
        </select>
    </div>
    <div class="col-lg-12 mb-3">
        <label class="form-label">Plane Name:*</label>
        <input id="plane_name" name="plane_name" value="{{ old('plane_name', $fleetPlaneObj->plane_name) }}"
            type="text" class="form-control {{ hasError($errors, 'plane_name') }}"
            placeholder="Plane Name">
        {!! showErrors($errors, 'plane_name') !!}
    </div>
    <div class="col-lg-12 mb-3">
        <label class="form-label">Description:*</label>
        <textarea name="description" id="description" class="form-control {{ hasError($errors, 'description') }}"
            placeholder="Description">{{ old('description', $fleetPlaneObj->description) }}</textarea>
        {!! showErrors($errors, 'description') !!}
    </div>
    <div class="col-lg-12 mb-3">
        <label>Status:*</label>
        <select class="form-control" name="status" id="status">
            {!! generateFleetPlaneStatusDropDown($fleetPlaneObj->status, false) !!}
        </select>
    </div>
</div>