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
                    <li class="active">Create Task</li>
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
            <div class="col-xs-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-9">
                                <h3 class="">Create Task</h3>
                            </div>
                            <div class="col-lg-3 text-right">
                                <a wire:navigate href="{{ route('tasks.list') }}" class="btn btn-primary"><i
                                        class="fa-solid fa-arrow-left"></i> Tasks List</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <form>
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" wire:model="title">
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <div wire:ignore>
                                            <textarea class="form-control" id="description" wire:model="description"></textarea>
                                        </div>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" wire:model="status">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary"
                                            wire:click="store()">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@script
    <script>
        tinymce.init({
            selector: '#description',
            force_br_newlines: true,
            images_upload_url: uploadTinyMceImage,
            images_upload_handler: tinymce_image_upload_handler,
            content_css: tinymce_front_css_file,
            relative_urls: false,
            remove_script_host: false,
            document_base_url: base_url,
            menubar: false,
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion',
            toolbar: "undo redo | fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl | accordion accordionremove | blocks",
            image_advtab: true,
            importcss_append: true,
            height: 600,
            setup: (editor) => {
                editor.on('init change', function() {
                    editor.save();
                });
                editor.on('change', function(e) {
                    @this.set('description', editor.getContent());
                });
            }
        });
    </script>
@endscript
