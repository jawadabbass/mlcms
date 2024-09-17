@extends('back.layouts.app',['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section>
          <div class="breadcrumb">
            <h1 class=" card-title">General Message Templates</h1>
            <ul>
              <li><a href="{{ admin_url() }}"><i class="fas fa-tachometer-alt"></i> Home</a></li>
              <li><a href="{{ route('message.index') }}"> Message Templates</a></li>
              <li class="active">General</li>
            </ul>
          </div>
        <div class="separator-breadcrumb border-top"></div>
        </section>
        <section class="content">
            @if(\Session::has('success'))
                <div class="alert alert-success alert-dismissible mb-2" role="alert">
                <button type="button" class="btn close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Success!</strong> {{session('success')}}
                    
             </div>
            @endif
            @if($errors->all())
            <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                <button type="button" class="btn close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Danger!</strong>
                    @foreach($errors->all() as $error)
                    {{$error}}
                    @endforeach
             </div>
        @endif
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <div class="card p-2">
              <div class="row">
                <div class="col-sm-8">
                  <div class="box-header">
                    <div class="clearfix"></div>
                    <br>
                  </div>
                </div>
                @if(isAllowed(115))
                <div class="col-sm-4" >
                   
                      <button  data-bs-toggle="modal" data-bs-target="#AddserviceModal" class="btn btn-success" style="margin-bottom: 10px;float: right;">Add New Message</button>
                    
                </div>
                @endif

              </div>
            </div>
            <div class=" card-body table-responsive">
              <table id="table_id" class="table table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th style="display: none;">Title</th>
                    <th width="75%">Message Body</th>
                    <th style="display: none;">Status</th>
                    <th colspan="5">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($result as $row)
                  <tr id="row_{{ $row->id}}">
                    <td>{{ $row->id}}</td>
                    <td style="display: none;">{{ $row->title }}</td>
                    <td>{{ $row->body }}</td>
                    <td style="display: none;"></td>
                    <td>
                      @if(isAllowed(116))
                       <a class="btn-sm btn-success my-a" href="javascript:void(0)" id="update_btn" 
                        data-id="{{$row->id}}"><i class="fas fa-edit" aria-hidden="true"></i> Edit</a>
                        @endif
                        @if(isAllowed(117))
                        <a class="btn-sm btn-danger my-a"  href="javascript:;" onClick="delete_record({{$row->id}})"><i class="fas fa-trash"></i> Delete</a>
                        @endif
                    </td>
                  </tr>

                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        </section>
    </div>
        <!--------- Update Start Modal Here------->
         <div class="modal fade" id="UpdateserviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg" role="document">
             <div class="modal-content">
               <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Update Message Template</h5>
                 <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                   
                 </button>
               </div>
               <div class="modal-body">
                  <form action="{{route('message.update',0)}}" method="post" enctype="multipart/form-data">
                   @csrf
                   @method('PUT')
                   <input type="hidden" id="id" name="id">
                   <div class="form-group">
                     <label for="message-text" class="col-form-label"><strong>Message Body:</strong></label>
                     <textarea class="form-control" id="body"  name="body"></textarea>
                   </div>
                   
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button type="submit"  class="btn-sm btn-primary">Update</button>
               </div>
             </form>
             </div>
           </div>
         </div>
        <!--------- End Modal Here------->
   
<!--------- ADD Start Modal Here------->
 <div class="modal fade" id="AddserviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Add New Message Template</h5>
         <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
           
         </button>
       </div>
       <div class="modal-body">
          <form action="{{ route('message.store') }}" method="post" enctype="multipart/form-data">
           @csrf
            <div class="form-group" style="display: none;">
              <label for="">Title</label>
              <input type="text" class="form-control" name="title">
            </div>
            <div class="form-group">
             <label for="message-text" class="col-form-label"><strong>Message Body:</strong></label>
             <textarea class="form-control" id="" id="body" name="body"></textarea>
           </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
         <button type="submit"  class="btn-sm btn-primary">Submit</button>
       </div>
     </form>
     </div>
   </div>
 </div>
<!--------- End Modal Here------->


@endsection

@section('page_scripts')



<script>
$(document).ready(function(){

  $(document).on('click', '#update_btn', function(){
    var id = $(this).attr('data-id');
  
    get_url = 'services';
    $.ajax({
      url: "{{ base_url() . 'message/'}}" + id,
      type:'GET',
      success:function(data){
        console.log(data)
        $('#id').val(data.id);
        $('#body').html(data.body);
        $('#UpdateserviceModal').modal({ show : true });
      }

    })
  })
});

function delete_record(id) {

  $('.message-container').fadeOut(3000);
  if (confirm('Are you sure delete this data?')) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: "{{ base_url() . 'message/'}}" + id,
      type: "DELETE",
      success: function (data) {
        if(data.status == "success")
        {
          location.reload();
        }
        else
        {
          alert('Error adding / update data');
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
      }
    });
  }
}
</script>
@endsection