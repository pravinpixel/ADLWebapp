@extends('layouts.admin')

@section('admin_title')
    Orders
@endsection

@section('admin_content')
    <div class="card custom table-card">
        <div class="card-header">
            <div class="card-title">
                Customers
            </div>
            @if (permission_check('CUSTOMERS_EXPORT'))
            <form method="POST" name="dashboard_export" action="{{ route('customers.export') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <button type="submit" id="dashboardExport" class="btn btn-primary" >Export</button>
            </form>
            @endif
        </div>
        <div class="card-body">
            <table class="table table-bordered table-centered m-0 tr-sm table-hover" id="data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function () {
            var table = $('#data-table').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                processing: true,
                serverSide: true,
                ajax: "{{ route('customers.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'id',orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endsection
