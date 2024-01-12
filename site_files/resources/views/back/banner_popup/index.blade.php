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
                    <li class="active">Banner Popups</li>
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
                <div class="box">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="box-header">
                                <h3 class="box-title">Banner Popup</h3>
                            </div>
                        </div>
                        <div class="col-sm-4 text-right">
                            {{--  <button wire:click="showCreateBannerPopupModal" class="btn btn-success">Add Banner
                                Popup</button> --}}
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        {{-- <div class="row">
                            <div class="col-lg-6">
                                <button type="button" class="btn btn-info" wire:click="showFilters"
                                    style="display: {{ $show_filter ? 'none' : 'block' }};">Show
                                    Filters</button>
                                <button type="button" class="btn btn-warning" wire:click="hideFilters"
                                    style="display: {{ $show_filter ? 'block' : 'none' }};">Hide
                                    Filters</button>
                            </div>
                            <div class="col-lg-6 text-end">
                                <a wire:navigate href="{{ route('sort-banner-popups') }}" class="btn btn-warning">
                                    <i class="la la-bars"></i>Sort Banner Popups
                                </a>
                            </div>
                        </div> 
                        <div class="row" style="display: {{ $show_filter ? 'block' : 'none' }};">
                            <div class="col-md-3 form-group">
                                <label for="banner_title">Banner Title</label>
                                <input type="text" name="banner_title" id="banner_title" placeholder="Banner Title"
                                    wire:model.live="banner_title" class="form-control">
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="per_page">Per Page</label>
                                        <select name="per_page" id="per_page" class="form-control"
                                            wire:model="per_page" wire:change="setPerPage">
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
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="offset-md-6 col-md-6 form-group">
                                        <label for="sort_by">Sort By</label>
                                        <select class="form-control" name="sort_by" id="sort_by" wire:model="sort_by"
                                            wire:change="setAscDesc">
                                            <option value="banner_title-asc">Banner Title(ASC)</option>
                                            <option value="banner_title-desc">Banner Title(DESC)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        --}}
                        <div>
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                        </div>
                        <table class="table table-striped table-bordered" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Banner Title</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bannerPopUpsCollection as $bannerPopUpObj)
                                    <tr wire:key="{{ $bannerPopUpObj->id }}">
                                        <td>{{ $bannerPopUpObj->banner_title }}</td>
                                        <td>
                                            @if ($bannerPopUpObj->status == 'active')
                                                <button class="btn btn-small btn-success"
                                                    wire:click="setInActive({{ $bannerPopUpObj->id }})">Active</button>
                                            @else
                                                <button class="btn btn-small btn-secondary"
                                                    wire:click="setActive({{ $bannerPopUpObj->id }})">Inactive</button>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-small btn-warning"
                                                wire:click="showEditBannerPopupModal({{ $bannerPopUpObj->id }})">Edit</button>
                                            @if ($bannerPopUpObj->id != 1)
                                                <button class="btn btn-small btn-danger" type="button"
                                                    wire:click="delete({{ $bannerPopUpObj->id }})"
                                                    wire:confirm="Are you sure you want to delete this Banner Popup?">Delete</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $bannerPopUpsCollection->links() }}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
    <div wire:ignore.self class="modal fade text-left" id="banner_popup_modal" tabindex="-1" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $form->add_or_edit == 'add' ? 'Create' : 'Edit' }} Banner Popup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (!empty($message))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                    <form wire:submit.prevent="{{ $form->add_or_edit == 'add' ? 'store' : 'update' }}">
                        <div class="mb-3">
                            <label for="banner_title" class="form-label">Banner Title</label>
                            <input type="text" wire:model.defer="form.banner_title"
                                class="form-control @error('form.banner_title') is-invalid @enderror" id="banner_title"
                                aria-describedby="banner_title_help">
                            @error('form.banner_title')
                                <div id="banner_title_help" class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="banner_popup_content" class="form-label">Banner Content</label>
                            <div wire:ignore>
                                <textarea id="banner_popup_content" wire:model.defer="form.content"
                                    class="form-control @error('form.content') is-invalid @enderror" aria-describedby="content_help">{!! adjustUrl($form->content) !!}</textarea>
                            </div>
                            @error('form.content')
                                <div id="content_help" class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Banner Status</label>
                            <select wire:model.defer="form.status"
                                class="form-control @error('form.status') is-invalid @enderror" id="status"
                                aria-describedby="status_help">
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            @error('form.status')
                                <div id="status_help" class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" onclick="showLoader();"
                            class="btn btn-primary">{{ $form->add_or_edit == 'add' ? 'Save' : 'Update' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        $(document).ready(function() {
            function makeTinyMceEditor() {
                tinymce.init({
                    selector: '#banner_popup_content',
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
                            @this.set('form.content', editor.getContent());
                        });
                    }
                });
            }

            function openModal() {
                $("#banner_popup_modal").modal('show');
                tinyMCE.get('banner_popup_content').setContent(@this.get('form.content'));
            }

            function hideModal() {
                setTimeout(() => {
                    resetForm();
                    $("#banner_popup_modal").modal('hide');
                }, 2000);
            }

            function resetForm() {
                @this.set('message', '');
                @this.set('form.banner_title', '');
                @this.set('form.content', '');
            }

            window.addEventListener('openBannerPopupFormModal', (event) => openModal());
            window.addEventListener('closeBannerPopupFormModal', (event) => hideModal());
            var banner_popup_modal = document.getElementById('banner_popup_modal');
            banner_popup_modal.addEventListener('hidden.bs.modal', (event) => resetForm());

            makeTinyMceEditor();
        });
        document.addEventListener('focusin', (e) => {
            if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
                e.stopImmediatePropagation();
            }
        });
    </script>
@endscript
