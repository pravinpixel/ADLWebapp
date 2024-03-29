@extends('admin.master.layout')

@section('admin_master_content')
    
    <div class="card custom">
        <div class="card-header">
            <div class="card-title">
                Edit Condition 
            </div>
            <a href="{{ route('condition.index') }}" class="btn btn-primary ms-3">
                <i class="fa fa-arrow-left me-2" aria-hidden="true"></i>
                Go back
            </a>
        </div>
        <div class="card-body"> 
            {!! Form::model($condition,['route' => ['condition.update', $condition->id], 'id' => 'condition_edit_form', 'method'=> 'post','files' => true]) !!}
                @csrf
                @include('admin.master.conditions.form')
                <div class="row ">
                    <div class="col-10 offset-2">
                        <a href="{{ route('condition.index') }}" class="btn btn-light">back</a>
                        <button type="submit" class="btn btn-primary fw-bold">Save</button>
                    </div>
                </div> 
            {!! Form::close() !!}
        </div>
    </div>
@endsection 