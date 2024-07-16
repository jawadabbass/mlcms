@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-tachometer-alt"></i> Home </a></li>
                        <li><a href="{{ admin_url() }}contact_request">Contact Leads</a></li>

                    </ol>
                    {{-- {!!getBC('Details',$bcArr)!!} --}}
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">
                                Details of Mr /Mr's <code> {!! $result->name !!}</code>
                                <button onclick="editContactRequest({{ $result->id }});"
                                    class="btn btn-warning">Edit</button>
                            </h3>
                        </div>
                        <div class="row">
                            <div class="col-md-5 table-responsive">
                                <p class="alert alert-success mt-2" style="display: none;"
                                    id="editContactRequestMessageAlert"></p>
                                <table class="table border ">
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>{{ $result->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $result->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number</td>
                                            <td>{{ $result->phone }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <td>Address</td>
                                            <td>{{ $result->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cost of Lead</td>
                                            <td>${{ $result->price }}</td>
                                        </tr>
                                        <tr>
                                            <td>Subject</td>
                                            <td>{{ $result->subject }}</td>
                                        </tr> --}}
                                        <tr>
                                            <td>Comments</td>
                                            <td>{{ $result->comments }}</td>
                                        </tr>
                                        <tr>
                                            <td>Enrolled Date</td>
                                            <td><?php echo date('d-M-Y', strtotime($result->dated)); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-7">
                                {{-- HERE --}}
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">

                                        <div id="tracking-pre"></div>
                                        <div id="tracking">
                                            <div class="text-center tracking-status-intransit">
                                                <div class="row">
                                                    <div class="col-md-4 text-left pl-4">
                                                        @if ($pre)
                                                            <a href="{{ route('contact_request.show', [$pre->id]) }}"
                                                                class="btn btn-info"><i
                                                                    class="fa-solid fa-arrow-circle-left"></i></a>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <p class="tracking-status text-tight">
                                                            <span><i class="fa-solid fa-history" aria-hidden="true"></i>
                                                                History</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4 text-right pr-4">
                                                        @if ($next)
                                                            <a href="{{ route('contact_request.show', [$next->id]) }}"
                                                                class="btn btn-info"><i
                                                                    class="fa-solid fa-arrow-circle-right"></i></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tracking-list">
                                                @foreach ($history as $key => $val)
                                                    <div class="tracking-item">
                                                        <div class="tracking-icon status-intransit">
                                                            <div style="font-size:18px;" class="">
                                                                @if ($val->ref == 1)
                                                                    <i class="fas fa-money" style="color:green;"
                                                                        aria-hidden="true"></i>
                                                                @elseif($val->ref == 2)
                                                                    <i class="fas fa-plus" style="color:green;"
                                                                        aria-hidden="true"></i>
                                                                @elseif($val->ref == 3)
                                                                    <i class="fas fa-envelope-square" style="color:#b9b929;"
                                                                        aria-hidden="true"></i>
                                                                @else
                                                                    <i class="fas fa-edit" style="color:red"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="tracking-date">
                                                            {{ format_date($val->created_at, 'date') }}<span>{{ format_date($val->created_at, 'time_only') }}</span>
                                                        </div>
                                                        <div class="tracking-content">{{ $val->msg }} by <strong><span
                                                                    class="d-inline-block" tabindex="0"
                                                                    data-toggle="tooltip"
                                                                    title="{{ $val->admin->name }}&nbsp; ({{ $val->admin->email }})">
                                                                    <h5 style="pointer-events: none;color:#038cfc;font-size:14px;"
                                                                        disabled>{{ $val->admin->name }}</h5>
                                                                </span></strong></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        {!! $history->links() !!}
                                    </div>
                                </div>
                                {{-- HEREE --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="editContactRequestModal" tabindex="-1" role="dialog"
        aria-labelledby="editContactRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editContactRequestModalLabel">Edit Contact Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editContactRequestModalBody">
                    @include('back.contactus.edit_contact_request')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <style type="text/css">
        .tracking-detail {
            padding: 3rem 0
        }

        #tracking {
            margin-bottom: 1rem
        }

        [class*=tracking-status-] p {
            margin: 0;
            font-size: 1.1rem;
            color: #fff;
            text-transform: uppercase;
            text-align: center
        }

        [class*=tracking-status-] {
            padding: 1.6rem 0
        }

        .tracking-status-intransit {
            background-color: #65aee0
        }

        .tracking-status-outfordelivery {
            background-color: #f5a551
        }

        .tracking-status-deliveryoffice {
            background-color: #f7dc6f
        }

        .tracking-status-delivered {
            background-color: #4cbb87
        }

        .tracking-status-attemptfail {
            background-color: #b789c7
        }

        .tracking-status-error,
        .tracking-status-exception {
            background-color: #d26759
        }

        .tracking-status-expired {
            background-color: #616e7d
        }

        .tracking-status-pending {
            background-color: #ccc
        }

        .tracking-status-inforeceived {
            background-color: #214977
        }

        .tracking-list {
            border: 1px solid #e5e5e5
        }

        .tracking-item {
            border-left: 1px solid #e5e5e5;
            position: relative;
            padding: 2rem 1.5rem .5rem 2.5rem;
            font-size: .9rem;
            margin-left: 3rem;
            min-height: 5rem
        }

        .tracking-item:last-child {
            padding-bottom: 4rem
        }

        .tracking-item .tracking-date {
            margin-bottom: .5rem
        }

        .tracking-item .tracking-date span {
            color: #888;
            font-size: 85%;
            padding-left: .4rem
        }

        .tracking-item .tracking-content {
            padding: .5rem .8rem;
            background-color: #f4f4f4;
            border-radius: .5rem
        }

        .tracking-item .tracking-content span {
            display: block;
            color: #888;
            font-size: 85%
        }

        .tracking-item .tracking-icon {
            line-height: 2.6rem;
            position: absolute;
            left: -1.3rem;
            width: 2.6rem;
            height: 2.6rem;
            text-align: center;
            border-radius: 50%;
            font-size: 1.1rem;
            background-color: #fff;
            color: #fff
        }

        .tracking-item .tracking-icon.status-sponsored {
            background-color: #f68
        }

        .tracking-item .tracking-icon.status-delivered {
            background-color: #4cbb87
        }

        .tracking-item .tracking-icon.status-outfordelivery {
            background-color: #f5a551
        }

        .tracking-item .tracking-icon.status-deliveryoffice {
            background-color: #f7dc6f
        }

        .tracking-item .tracking-icon.status-attemptfail {
            background-color: #b789c7
        }

        .tracking-item .tracking-icon.status-exception {
            background-color: #d26759
        }

        .tracking-item .tracking-icon.status-inforeceived {
            background-color: #214977
        }

        .tracking-item .tracking-icon.status-intransit {
            color: #e5e5e5;
            border: 1px solid #e5e5e5;
            font-size: .6rem
        }

        @media(min-width:992px) {
            .tracking-item {
                margin-left: 8rem
            }

            .tracking-item .tracking-date {
                position: absolute;
                left: -10rem;
                width: 7.5rem;
                text-align: right
            }

            .tracking-item .tracking-date span {
                display: block
            }

            .tracking-item .tracking-content {
                padding: 0;
                background-color: transparent
            }
        }
    </style>
    <script>
        function editContactRequest(id) {
            fetch('{{ admin_url() }}get_contact_request_to_edit/' + id)
                .then(contatUsRequest => {
                    return contatUsRequest.json();
                })
                .then(contatUsRequest => {
                    $('#edit_contact_request_form').find('#id').val(contatUsRequest.id);
                    $('#edit_contact_request_form').find('#name').val(contatUsRequest.name);
                    $('#edit_contact_request_form').find('#email').val(contatUsRequest.email);
                    $('#edit_contact_request_form').find('#phone').val(contatUsRequest.phone);
                    $('#edit_contact_request_form').find('#address').val(contatUsRequest.address);
                    $('#edit_contact_request_form').find('#price').val(contatUsRequest.price);
                    $('#edit_contact_request_form').find('#subject').val(contatUsRequest.subject);
                    $('#edit_contact_request_form').find('#comments').val(contatUsRequest.comments);
                    $('#edit_contact_request_form').find('#dated').val(contatUsRequest.dated);

                    $('#editContactRequestModal').modal('show');
                });
        }

        function updateContactRequest() {
            const form = new FormData(document.getElementById('edit_contact_request_form'));
            fetch('{{ admin_url() }}update_contact_request', {
                    method: "POST",
                    body: form
                })
                .then(response => {
                    return response.json();
                })
                .then(jsonResponse => {
                    $('#editContactRequestMessageAlert').text(jsonResponse.message).show('slow');
                    contatUsRequest = jsonResponse.contatUsRequestObj;

                    $('#contact_request_details').find('#name').text(getData(contatUsRequest.name));
                    $('#contact_request_details').find('#email').text(getData(contatUsRequest.email));
                    $('#contact_request_details').find('#phone').text(getData(contatUsRequest.phone));
                    $('#contact_request_details').find('#address').text(getData(contatUsRequest.address));
                    $('#contact_request_details').find('#price').text('$' + getData(contatUsRequest.price));
                    $('#contact_request_details').find('#subject').text(getData(contatUsRequest.subject));
                    $('#contact_request_details').find('#comments').text(getData(contatUsRequest.comments));
                    $('#contact_request_details').find('#dated').text(getFormattedDate(getData(contatUsRequest.dated)));

                    $('#editContactRequestModal').modal('hide');
                });
        }

        function getData(data) {
            return (data == null) ? '' : data;
        }

        function getFormattedDate(date) {
            date = new Date(date);
            var year = date.getFullYear();

            var month = (1 + date.getMonth()).toString();
            month = month.length > 1 ? month : '0' + month;

            var day = date.getDate().toString();
            day = day.length > 1 ? day : '0' + day;

            return month + '-' + day + '-' + year;
        }
    </script>
@endsection
