@extends('admin.master.layout')

@section('admin_master_content')
    <div class="card custom table-card">
        <div class="card-header">
            <div class="card-title">
                Lab Test & Packages List
            </div>

            <form action="{{ route('test.sync') }}" method="POST">
                @csrf
                <small><b>Last Sync</b> : {{ $last_sync }}</small>
                <button type="submit" class="btn btn-primary ms-3">
                    <i class="fa fa-refresh me-2" aria-hidden="true"></i>
                    Sync Data</button>
            </form>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills m-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button onclick="isPackage('No')" class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true">Test</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="isPackage('Yes')" class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false">Packages</button>
                </li>
            </ul>
            <table class="table table-bordered  table-centered m-0 tr-sm table-hover" id="data-table">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Test Id</th>
                        <th>Test Name</th>
                        <th>Applicable Gender</th>
                        <th>Is Package</th>
                        <th>Classifications</th>
                        <th>Drive Through</th>
                        <th>Home Collection</th>
                        <th>Test Schedule</th>
                        <th>Test Price</th>
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
        $(function() {
            LoadData = (data) => {
                var table = $('#data-table').DataTable({
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('test.index') }}",
                        data: {
                            isPackage: data
                        },
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: "TestId",
                            name: "TestId"
                        },
                        {
                            data: "TestName",
                            name: "TestName"
                        },
                        {
                            data: "Applicable_Gender",
                            name: "ApplicableGender"
                        },
                        {
                            data: "IsPackage",
                            name: "IsPackage"
                        },
                        {
                            data: "Classifications",
                            name: "Classifications"
                        },
                        {
                            data: "Drive_Through",
                            name: "DriveThrough"
                        },
                        {
                            data: "Home_Collection",
                            name: "HomeCollection"
                        },
                        {
                            data: "Test_Schedule",
                            name: "TestSchedule"
                        },
                        {
                            data: "TestPrice",
                            name: "TestPrice"
                        },
                        {
                            data: "action",
                            name: "action"
                        },
                    ],
                });
            }
            LoadData('No')
            isPackage = (data) => {
                console.log(data)
                $('#data-table').DataTable().destroy();
                LoadData(data);
            }
        });
    </script>
@endsection
