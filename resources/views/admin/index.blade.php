@extends('layouts.admin')

@section('admin_title')
    Home
@endsection

@section('admin_content')
    <div class="p-1 mb-3">
        <div class="mb-1 lead"><strong>Welcome <b class="text-gradient">{{ Sentinel::getUser()->name }}</b></strong></div>
        <span><b class="text-dark">Role :</b> <span
                class="badge bg-gradient">{{ Sentinel::getUser()->roles[0]->name }}</span></span>
    </div>

    @if (Sentinel::getUser()->roles[0]['id'] == '1')
        <div class="row m-0">

            <div class="col-3 p-1">
                <a href="{{ route('test.index') }}">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <div class="h4 text-gradient"> <span id="total_test"></span> </div>
                            <div class="x-between y-center">
                                <b class="text-secondary">Total Tests</b>
                                <i class="text-primary fa fa-flask fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-3 p-1">
                <a href="{{ route('test.index') }}">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <div class="h4 text-gradient"><span id="total_package"></span></div>
                            <div class="x-between y-center">
                                <b class="text-secondary">Total Packages</b>
                                <i class="text-primary bi bi-box fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-3 p-1">
                <a href="{{ route('orders.index') }}">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <div class="h4 text-gradient"><span id="total_order"></span></div>
                            <div class="x-between y-center">
                                <b class="text-secondary">Total Orders</b>
                                <i class="text-primary fa fa-shopping-cart fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-3 p-1">
                <a href="{{ route('customers.index') }}">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <div class="h4 text-gradient"><span id="total_customer"></span></div>
                            <div class="x-between y-center">
                                <span>Total Customers</span>
                                <i class="text-primary bi bi-person-lines-fill fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-3 p-1">
                <div class="card card-body shadow-sm">
                    <div class="x-between y-center">
                        <div>
                            <div class="h4 text-success"><span id="received_payment"></span> </div>
                            <div><b>Received Payments</b></div>
                        </div>
                        <i class="fa-2x bi bi-credit-card-fill text-success"></i>
                    </div>
                </div>
            </div>
            <div class="col-3 p-1">
                <div class="card card-body shadow-sm">
                    <div class="x-between y-center">
                        <div>
                            <div class="h4 text-warning"><span id="pending_order"></span> </div>
                            <div><b>Pending Order</b></div>
                        </div>
                        <i class="fa-2x bi bi-credit-card-fill text-warning"></i>
                    </div>
                </div>
            </div>
            <div class="col-3 p-1">
                <div class="card card-body shadow-sm">
                    <div class="x-between y-center">
                        <div>
                            <div class="h4 text-info"><span id="cancel_order"></span> </div>
                            <div><b>Cancel Order Request</b></div>
                        </div>
                        <i class="fa-2x bi bi-credit-card-fill text-info"></i>
                    </div>
                </div>
            </div>
            <div class="col-3 p-1">
                <div class="card card-body shadow-sm">
                    <div class="x-between y-center">
                        <div>
                            <div class="h4 text-danger"><span id="failed_payment"></span> </div>
                            <div><b>Failed Payments</b></div>
                        </div>
                        <i class="fa-2x bi bi-credit-card-fill text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card custom table-card m-1 mt-2">
        <div class="card-header">
            <div class="row m-0 align-items-center w-100">
                <div class="col-3 p-0">
                    <div class="card-title">
                        All Enquiries
                    </div>
                </div>
                <div class="col p-0 text-end">
                    <div class="input-group input-daterange m-0">
                        @if (permission_check('DASHBOARD_EXPORT'))
                            <form method="POST" name="dashboard_export" action="{{ route('dashboard.export') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="export_enquiry" id="export_enquiry" value="">
                                <input type="hidden" name="export_enquiry_from_date" id="export_enquiry_from_date"
                                    value="">
                                <input type="hidden" name="export_enquiry_to_date" id="export_enquiry_to_date"
                                    value="">
                                <button type="submit" id="dashboardExport" class="btn btn-primary">Export</button>
                            </form>
                        @endif
                        <button type="button" name="refresh" id="refresh" class="btn btn-warning form-control-sm"><i
                                class="fa fa-repeat" aria-hidden="true"></i></button>
                        <select name="search_data" id="search_data" class="form-select selectpicker">
                            <option value="">-- Search Enquiry --</option>
                            @foreach (config('dashboard.enquiry_types') as $type)
                                <option value="{{ $type }}">{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                            @endforeach
                        </select>

                        <input type="text" name="from_date" id="from_date"
                            class="btn form-control form-control-sm text-start" placeholder="From Date" readonly />
                        <input type="text" name="to_date" id="to_date"
                            class="btn form-control form-control-sm text-start" placeholder="To Date" readonly />
                        <button type="button" name="filter" id="filter" class="btn btn-primary form-control-sm"><i
                                class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table" id="data-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Date</th>
                        <th>Page</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.input-daterange').datepicker({
                todayBtn: 'linked',
                format: 'yyyy-mm-dd',
                autoclose: true
            });
            $.ajax({
                type: 'GET',
                url: "{{ route('dashboard.data') }}",
                success: function(data) {
                    $('#total_test').html(data.data.test);
                    $('#total_package').html(data.data.package);
                    $('#total_order').html(data.data.order);
                    $('#total_customer').html(data.data.customer);
                    $('#received_payment').html(data.data.received_payment);
                    $('#pending_order').html(data.data.pending_order);
                    $('#failed_payment').html(data.data.failed_payment);
                    $('#cancel_order').html(data.data.cancel_order);

                }
            });

            function load_data(from_date = '', to_date = '', search_data = '') {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                $('#data-table').DataTable({
                    order: [
                        [6, 'desc']
                    ],
                    lengthMenu: [
                        [5,10, 25, 50, -1],
                        [5,10, 25, 50, "All"]
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('dashboard.index') }}",
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            search_data: search_data
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'mobile',
                            name: 'mobile'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'page',
                            name: 'page'
                        },                        
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ],
                });
            }
            load_data();
            $('#dashboardExport').click(function() {
                var search_data = $('#search_data').val();
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                $('#export_enquiry_from_date').val(from_date);
                $('#export_enquiry_to_date').val(to_date);
                $('#export_enquiry').val(search_data);
            });
            $('#filter').click(function() {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var search_data = $('#search_data').val();
                $('#export_enquiry').val(search_data);
                $('#data-table').DataTable().destroy();
                load_data(from_date, to_date, search_data);
            });

            $('#refresh').click(function() {
                $('#search_data').val('');
                $('#from_date').val('');
                $('#to_date').val('');
                $('#data-table').DataTable().destroy();
                load_data();
            });

            $(document).on('change', '#status', function() {
                var type = $(this).data("type");
                var id = $(this).data("id");
                var value = $(this).val();

                if (type != '' && id != '' && value != '') {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.status') }}",
                        data: {
                            id: id,
                            type: type,
                            value: value,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            // $('#data-table').DataTable().destroy();
                            toastr.success("Status updated successfully");
                        }
                    })
                }
            });
            $(document).on('keyup', '#remark', function() {
                var type = $(this).data("type");
                var id = $(this).data("id");
                var value = $(this).val();
                if (type != '' && id != '') {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.remark') }}",
                        data: {
                            id: id,
                            type: type,
                            value: value,
                            _token: '{{ csrf_token() }}'
                        }
                    })
                } 
            });
        });
    </script>
@endsection
