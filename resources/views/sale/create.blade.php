@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
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
          <!-- Default box -->
          <div class="card">
              <div class="card-header">
                  <h3 class="card-title">Manage Sales</h3>
                </div>
              <div class="card-body">
                <div class="col-md-8 col-xs-12">
                    <div class="form-group row">
                        <label for="order-number" class="col-md-3 col-form-label">Sales Number</label>
                        <div class="col-md-9">
                            <input type="text" readonly class="form-control-plaintext" id="order-number" name="order-number" value="{{ $salesNumber }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date" class="col-md-3 col-form-label">Date</label>
                        <div class="col-md-9 input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" name="date" id="date" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="customer" class="col-md-3 col-form-label">Customer</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="customer" name="customer" value="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="search-item" class="col-md-3 col-form-label">Search Item</label>
                        <div class="col-md-9">
                            <select id="search-item" class="form-control">
                                <option></option>
                                @foreach ($items as $item)
                                <option data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-upc="{{ $item->upc }}" data-total-qty="{{ $item->total_qty }}" data-with-serial-number="{{ $item->with_serial_number }}" data-cost-price="{{ $item->cost_price }}" data-selling-price="{{ $item->selling_price }}" value="{{ $item->id }}">{{ $item->name }} {{ $item->upc ? '(' . $item->upc . ')' : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <table class="table table-bordered" id="sales-table" hidden>
                        <thead>
                        <tr>
                            <th>Item</th>
                            {{-- <th>UPC</th> --}}
                            <th>On Hand</th>
                            <th>Serial Number</th>
                            <th>Qty</th>
                            <th>Cost Price</th>
                            <th>Selling Price</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 col-xs-12 float-right">
                    <div class="form-group row">
                      <label for="gross-total" class="col-md-4 col-form-label">Gross Total</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control" id="gross-total" name="gross-total" readonly autocomplete="off">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="discount" class="col-md-4 col-form-label">Discount</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount" autocomplete="off">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="net-total" class="col-md-4 col-form-label">Net Total</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control" id="net-total" name="net-total" disabled autocomplete="off">
                      </div>
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
          </div>
        </div>
        <!-- col-md-12 -->
      </div>
    </section>
    <!-- /.content -->
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

<script src="{{ asset('js/sale.js') }}"></script>
@endpush
  