@extends('layouts.admin')
@section('title')
    <title>Leave Type</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card">
        <div class="card-header">
          <h4>Edit Data Leave Type</h4>
        </div>
        <div class="card-body">
                <form action=" {{route('update_leaveType')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="leave_type" value="{{$data->leave_type}}">
                        <input type="hidden" class="form-control" name="id" value="{{$data->id}}">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="is_day" value="{{$data->is_day}}">
                        <input type="hidden" class="form-control" name="id" value="{{$data->id}}">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary mt-2" type="submit" value="Cancel">
                        <input class="btn btn-primary mt-2 float-right" type="submit" value="Submit">
                    </div>
                </form>
        </div>
      </div>
    </div>
  </div>

@endsection
