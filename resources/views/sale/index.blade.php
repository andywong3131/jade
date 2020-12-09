@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
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
                    <h1 class="m-0 text-dark">Manage Sales</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            {{-- <div class="row">
                <form action="#" id="form-test" method="POST">
                    @csrf
                    <input type="text" name="name">
                    <input type="submit" value="submit">
                </form>
            </div> --}}
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
  
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
  
          <div id="messages"></div>
          {{-- <button class="btn btn-primary" data-toggle="modal" data-target="#add-itemin-modal">Add Sales</button> --}}
            <a href="{{ url('sale/create') }}" class="btn btn-primary">Add Sales</a>
          <br><br>
          <!-- Default box -->
          <div class="card">
              <div class="card-header">
                  <h3 class="card-title">Manage Sales</h3>
                </div>
              <div class="card-body">
                  <table id="manage-item-in-table" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                            <th>Purchase Number</th>
                            <th>Item</th>
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
        </div>
        <!-- col-md-12 -->
      </div>
    </section>
    <!-- /.content -->
  
    {{-- <div class="box"> --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="add-itemin-modal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Item In</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                {!! Form::open(['class' => 'form-horizontal','id' => 'create-itemin-form', 'url' => 'itemin/store', 'method' => 'GET']) !!}
                <div class="modal-body">
                    <div class="col-md-8 col-xs-12">

                        <div class="form-group row">
                            <label for="supplier" class="col-sm-5 col-form-label">Supplier</label>
                            <div class="col-sm-7">
                                <input type="text" readonly class="form-control-plaintext" id="supplier" name="supplier" value="Supplier A" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="purchase-number" class="col-sm-5 col-form-label">Purchase Number</label>
                            <div class="col-sm-7">
                                <input type="text" readonly class="form-control-plaintext" id="purchase-number" name="purchase-number">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gross_amount" class="col-sm-5 col-form-label">Date</label>
                            <div class="col-sm-7 input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="date" id="date" data-target="#reservationdate"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gross_amount" class="col-sm-5 col-form-label">Search Item</label>
                            <div class="col-sm-7">
                                <select id="search-item" class="form-control">
                                    <option></option>
                                    @foreach ($items as $item)
                                    <option data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-upc="{{ $item->upc }}" data-with-serial-number="{{ $item->with_serial_number }}" data-cost-price="{{ $item->cost_price }}" value="{{ $item->id }}">{{ $item->name }} {{ $item->upc ? '(' . $item->upc . ')' : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <br /> <br/>
                    <table class="table table-bordered" id="item-in-table" hidden>
                        <thead>
                        <tr>
                            <th>Item</th>
                            {{-- <th>UPC</th> --}}
                            <th>Serial Number</th>
                            <th>Qty</th>
                            <th>Cost Price</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>

                    <br /> <br/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Item In</button>
                </div>
                <input type="hidden" name="branch-id" value="1">
                <input type="hidden" name="supplier-id" value="1">
                {!! Form::close() !!}
            </div>  
        </div>
    </div>
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
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- ChartJS -->
{{-- <script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script> --}}


<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script> --}}
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>

<script src="{{ asset('js/itemin.js') }}"></script>
@endpush
  