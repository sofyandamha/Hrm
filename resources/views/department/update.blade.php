@extends('layouts.admin')
@section('title')
    <title>Department</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card">
        <div class="card-header">
          <h4>Data Edit Department</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <form action=" {{route('update_department')}}" method="POST">
                    @csrf
                    <div class="">
                        <input type="text" class="form-control" name="name" value="{{$data->name}}">
                        <input type="hidden" class="form-control" name="id" value="{{$data->id}}">
                    </div>
                    <div class="">
                        <input class="btn btn-primary mt-2" type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>

@endsection
