@extends('admin.enquiry.layout')

@section('admin_enquiry_content') 
    
    <div class="card custom table-card"> 
        <div class="card-header">
            <div class="card-title">
                Patients Consumers
            </div>
            @if (permission_check('PATIENTS_CONSUMERS_EXPORT'))
            <form method="POST" name="dashboard_export" action="{{ route('patients-consumers.export') }}" enctype="multipart/form-data">
                @csrf
                <button type="submit" id="dashboardExport" class="btn btn-primary" >Export</button>
            </form>
            @endif
        </div>
        <div class="card-body"> 
            <table class="table table-bordered table-centered m-0 tr-sm table-hover" id="data-table">
                <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Prescription</th>
                        <th>Date & Time</th>
                        <th width="100px">Action</th>
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
                ajax: "{{ route('patients-consumers.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'id',orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'email', name: 'email'},
                    {data: 'gender', name: 'gender'},
                    {data: 'download', name: 'download', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endsection