@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  {{-- <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"> --}}
  <!-- iCheck -->
  {{-- <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css"> --}}
  <!-- JQVMap -->
  {{-- <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <!-- Daterange picker -->
  {{-- <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css"> --}}
  <!-- summernote -->
  {{-- <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css"> --}}
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Manage Items</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div id="messages"></div>

            <button class="btn btn-primary" data-toggle="modal" data-target="#add-item-modal">Add Item</button>
            <br><br>
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Items</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="manage-item-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>UPC</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                </div>
                <!-- /.card-footer-->
            </div>
        <!-- /.card -->
        </div>
    </div>
    </section>
    <!-- /.content -->

<!-- create item modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="add-item-modal">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add Item</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        {{-- <form role="form" action="#" method="post" id="createForm"> --}}
        {!! Form::open(['id' => 'create-item-form', 'url' => 'item/store', 'method' => 'POST']) !!}
        <div class="modal-body">
            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', '', ['class' => 'form-control', 'id' => 'name', 'required' => true, 'placeholder' => 'Enter name', 'autocomplete' => 'off']) }}
            </div>
            <div class="form-group">
                {{ Form::label('price', 'Selling Price') }}
                {{ Form::text('price', '', ['class' => 'form-control', 'id' => 'price', 'placeholder' => 'Enter price', 'autocomplete' => 'off']) }}
            </div>
            <div class="form-group">
                <label for="active">With Serial Number</label>
                <select class="form-control" id="with-serial-number" name="with-serial-number">
                    <option value="1">Yes</option>
                    <option value="0" selected>No</option>
                </select>
            </div>
            <div class="form-group">
                {{ Form::label('upc', 'UPC') }}
                {{ Form::text('upc', '', ['class' => 'form-control', 'id' => 'upc', 'placeholder' => 'Enter UPC', 'autocomplete' => 'off']) }}
            </div>
            <div class="form-group">
                <label for="active">Status</label>
                <select class="form-control" id="active" name="active">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        {!! Form::close() !!}
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit branch modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="edit-item-modal">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Item</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        {{-- <form role="form" action="#" method="post" id="createForm"> --}}
        {!! Form::open(['id' => 'update-item-form', 'url' => 'item', 'method' => 'POST']) !!}
        <div class="modal-body">
            <div class="form-group">
                {{ Form::label('edit-name', 'Name') }}
                {{ Form::text('edit-name', '', ['class' => 'form-control', 'id' => 'edit-name', 'required' => true, 'placeholder' => 'Enter name', 'autocomplete' => 'off']) }}
            </div>
            <div class="form-group">
                {{ Form::label('edit-price', 'Selling Price') }}
                {{ Form::text('edit-price', '', ['class' => 'form-control', 'id' => 'edit-price', 'placeholder' => 'Enter price', 'autocomplete' => 'off']) }}
            </div>
            <div class="form-group">
                <label for="active">With Serial Number</label>
                <select class="form-control" id="edit-with-serial-number" name="edit-with-serial-number">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="form-group">
                {{ Form::label('edit-upc', 'UPC') }}
                {{ Form::text('edit-upc', '', ['class' => 'form-control', 'id' => 'edit-upc', 'placeholder' => 'Enter UPC', 'autocomplete' => 'off']) }}
            </div>
            <div class="form-group">
                <label for="active">Status</label>
                <select class="form-control" id="edit-active" name="edit-active">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        {!! Form::close() !!}
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="remove-item-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Remove Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            {!! Form::open(['id' => 'remove-item-form', 'url' => 'item', 'method' => 'DELETE']) !!}
                @csrf
                <div class="modal-body">
                    <p>Do you really want to remove?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            {!! Form::hidden('_method', 'DELETE') !!}
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@push('scripts')
<script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- ChartJS -->
{{-- <script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>--}}
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script> --}}
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>

<script src="{{ asset('js/item.js') }}"></script>
@endpush
