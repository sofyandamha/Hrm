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
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Department Name :</label>
                                <select name="department_name" class="form-control select2">
                                    <option value=""></option>
                                    @foreach ($department as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Scan Id :</label>
                                <input type="text" name="scan_id" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">NIK :</label>
                                <input type="text" name="nik" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Full Name :</label>
                                <input type="text" name="full_name" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Address :</label>
                                <input type="text" name="address" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Birthday :</label>
                                <input type="text" name="birth_date" class="form-control datepicker">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-block">is Supervisor :</label>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" name="is_supervisor" type="checkbox" id="inlineCheckbox1" value="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary mt-2 float-right" value="Submit">
                    <a class="btn btn-danger" href="{{ route('show_employee') }}">Cancel</a>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection
