@extends('gallery::dashboard.layouts.app')

@section('title', 'گالری')
@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-spacing mt-4">
            <div class="col-lg-12">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header bg-4">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4> @lang('list') @lang($page_name)</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area bg-6">
{{--                        @can('create-gallery')--}}
                            <div class="col-md-12 text-right mb-5">
                                <a class="btn btn-success" href="{{route('gallery.create')}}">@lang('create new gallery')</a>
                            </div>
{{--                        @endcan--}}
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover overflow-hidden data-table">
                                <thead>
                                <tr>
                                    @foreach($fields as $field)
                                        <th>@lang($field)</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('gallery::dashboard.inc.group-includes.datatable-js')
    <script type="text/javascript">
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var fields  = <?php echo json_encode($fields) ?>;
            var columns = [];
            console.log(fields)
            for(i=0; i<fields.length; i++){
                console.log(fields.length);
                if(fields[i] == 'column'){
                    columns.push({data: 'DT_RowIndex', name: 'DT_RowIndex'});
                }else if(fields[i] == 'action'){
                    columns.push({data: 'action', name: 'action', orderable: false, searchable: false});
                }
                else{
                    columns.push({data: fields[i], name: fields[i]});
                }

            }
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: {{config('gallery.pagination')}} ,
                ajax: "{{ route('gallery.index') }}",
                columns: columns
            });


            $('#createNewticket').click(function () {
                $('#saveBtn').val("create-ticket");
                $('#ticket_id').val('');
                $('#ticketForm').trigger("reset");
                $('#modelHeading').html("@lang('create new ticket')");
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.editticket', function () {
                var ticket_id = $(this).data('id');
                $.get("{{ route('gallery.index') }}" +'/' + ticket_id +'/edit', function (data) {
                    $('#modelHeading').html("@lang('edit ticket')");
                    $('#saveBtn').val("edit-ticket");
                    $('#ajaxModel').modal('show');
                    $('#ticket_id').val(data.id);
                    $('#title').val(data.title);
                    $('#category').val(data.group);
                    if(data.parent_id){
                        $('#parent_id').val(1);
                        $('#parent_id').trigger('change');
                        ajaxParant(data.group)
                        setTimeout(function () {
                            $('#parent').val(data.parent_id) ;
                            $('#parent').trigger('change') ;
                        } , 1000);
                        setTimeout(changeIcon() , 2000);
                    }else{
                        $('#parent_id').val('');
                        $('#parent_id').trigger('change');
                    }
                    $('#permission_id').val(data.permission_id);
                    $('#permission_id').trigger('change');
                    $('#route_name').val(data.route_name);
                    $('#order').val(data.order);
                    $('#icon').val(data.icon);
                })
            });

            $('body').on('click', '.deleteGallery', function (){
                var ticket_id = $(this).data("id");
                var result = confirm("@lang('Are You sure want to delete !')");
                if(result){
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('gallery.store') }}"+'/'+ticket_id,
                        success: function (data) {
                            table.draw();
                            iziNotif(data);
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }else{
                    return false;
                }
            });
        });
    </script>

    {{--   select2 java script --}}
    <script>
        function changeIcon() {
            $icon = 'fa-'+$('#icon').val();
            $("#showIcon").removeClass();
            $("#showIcon").addClass('fas');
            $("#showIcon").addClass($icon);
        }
    </script>
@endsection
@section('head')
    @include('gallery::dashboard.inc.group-includes.datatable-css')
    <style>
        .buttons-excel,
        .buttons-print,
        .buttons-copy {
            background-color: white !important;
            color: #8e8e8e !important;
            border-radius: 5px !important;
            margin-left: 2px !important;
            font-size: 1em;
        }

        #posts_filter {
            float: left;
        }

        #posts_info {
            float: right;
        }

        #posts_paginate {
            margin: 0 3px;
            float: left;
        }
    </style>
@endsection
