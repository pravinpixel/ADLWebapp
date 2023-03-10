@extends('layouts.admin')

@section('admin_title') Home @endsection
<style>
    form i {
    margin-left: -30px;
    cursor: pointer;
}
.remove-image {
  position: absolute;
    height: 23px;
    width: 20px;
    border-radius: 12em;
    padding: 0px 5px 3px;
    background: #e58c8c;
    border: 3px;
    color: #fff;
    box-shadow: 0 2px 6px rgb(0 0 0 / 50%), inset 0 2px 4px rgb(0 0 0 / 30%);
    margin-left: -3px;
}
</style>
@section('admin_content') 
    <div class="p-1 mb-3">
        <div class="mb-1 lead"><strong>Welcome  <b class="text-gradient">{{ Sentinel::getUser()->name }}</b></strong></div>
        <span><b class="text-dark">Role :</b> <span class="badge bg-gradient">{{ Sentinel::getUser()->roles[0]->name }}</span></span>
    </div>
    <div class="card custom table-card">
        <div class="card-header">
            <div class="card-title">
                Profile
            </div>
            
        </div>
        <div class="card-body"> 
            {!! Form::open(['route' => 'profile.store','class'=>'needs-validation','novalidate',  'id' => 'brochures_form', 'method'=> 'post', 'files' => true]) !!}
                @csrf
                <br>
                <div class="row mb-3">
                    <label class="col-2 text-end col-form-label">Name *</label>
                    <div class="col-10">
                        <input type="text" class="form-control" autocomplete="off" name="name" value="{{ $data->name }}" required>

                    </div>
                </div>
                <input type="hidden" name="id" value="{{ $data->id }}" >
                <div class="row mb-3">
                    <label class="col-2 text-end col-form-label">Email *</label>
                    <div class="col-10">
                        <input type="email" class="form-control" autocomplete="off" name="email" value="{{ $data->email }}" required>
                       
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 text-end col-form-label">Current Password</label>
                    <div class="col-10">
                        <input type="password" name="old_password" class="form-control"  autocomplete="off" id="old_password">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 text-end col-form-label">New Password</label>
                    <div class="col-10">
                        <input type="password" name="password" class="form-control"  autocomplete="off" id="password">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 text-end col-form-label">Confirm Password</label>
                    <div class="col-10">
                        <input type="password" name="confirm_password" class="form-control"  autocomplete="off" id="confirm_password">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 text-end col-form-label">Profile</label>
                    <div class="col-4">
                        <input type="file" name="image" class="form-control"  id="image" accept="image/*" >
                    </div>
                    <div class="col-4">
                        @if ($data->image ?? null)
                        <img src="{{ asset_url($data->image) }}" class="image_delete" height="100" class="mt-2">
                        <a class="remove-image" id="delete_image" data-id="{{ $data->id }}" href="#" style="display: inline;">&#215;</a>
                        @endif
                    </div>
                </div>
              
                <div class="row mb-3">
                    <div class="col-10 offset-2">
                        <a href="{{ route('dashboard.index') }}" class="btn btn-light">Back</a>
                        <button type="submit" class="btn btn-primary fw-bold">Save</button>
                    </div>
                </div> 
                
               
            {!! Form::close() !!}
        </div>
    </div>
  
@endsection
@section('scripts')

<script>
    $(document).ready(function(){

        $('#delete_image').click(function(){
           
            var id = $(this).data('id')
            $.ajax({
                type:"POST",
                url:"{{ route('profile.image') }}",
                data: {
                    "id":id,
                    "_token": "{{ csrf_token() }}",
                },
                success:function(data){
                    if(data.res == "true")
                    {
                    location.reload(true);
                    }
                }
            });

        })
    })
</script>
@endsection