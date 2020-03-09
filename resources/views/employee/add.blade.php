@extends('layouts.admin')
@section('title')
    <title>Employee</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>Add New Employee</h4>
        </div>
        <div class="card-body">
            <form action="{{route('insert_employee')}}" method="post">
                    @csrf
                <div class="row">
                    <div class="form-group">
                        <label for="name">Scan Id :</label>
                            <input type="time" name="in_time" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Nik :</label>
                            <input type="time" name="out_time" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary mt-2 float-right">
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection