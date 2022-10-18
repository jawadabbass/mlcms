<form name="edit_contact_request_form" id="edit_contact_request_form" class="contact-form">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" class="form-control" id="id" value="">
        <div class="col-sm-12 mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value=""> 
        </div>
        <div class="col-sm-12 mb-3">
            <label class="form-label">Email</label>
            <input type="text" name="email" id="email" class="form-control" value=""> 
        </div>
        <div class="col-sm-12 mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value=""> 
        </div>
        <div class="col-sm-12 mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control" value=""> 
        </div>
        <div class="col-sm-12 mb-3">
            <label class="form-label">Price</label>
            <input type="text" name="price" id="price" class="form-control" value=""> 
        </div>
        <div class="col-sm-12 mb-3">
            <label class="form-label">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" value=""> 
        </div>
        <div class="col-sm-12 mb-3">
            <label class="form-label">Comments</label>
            <textarea class="form-control" name="comments" id="comments"></textarea>
        </div>
        <div class="col-sm-12 mb-3">
            <label class="form-label">Dated</label>
            <input type="date" name="dated" id="dated" class="form-control" value=""> 
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateContactRequest();">Update</button>
    </div>
</form>