@extends('layouts.admin')
@section('title')
    <title>Employee</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>Edit New Employee</h4>
        </div>
        <div class="card-body">
            <form action="{{route('update_employee')}}" method="post">
                    @csrf
                    <input type="hidden" name="id_emp" value="{{ $editEmp->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Department Name :</label>
                                <select name="department_name" class="form-control select2">
                                    @foreach($data as $dep)
                                    <option
                                    value="{{ $dep->id}}"
                                    @if($dep->id == $editEmp->id_department)
                                    selected
                                    @endif
                                    >{{  $dep->name }}
                                    </option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Scan Id :</label>
                                <input type="text" name="scan_id" class="form-control" value="{{ $editEmp->scan_id }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">NIK :</label>
                                <input type="text" name="nik" class="form-control" value="{{ $editEmp->nik }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Full Name :</label>
                                <input type="text" name="full_name" class="form-control" value="{{ $editEmp->full_name }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Address :</label>
                                <input type="text" name="address" class="form-control" value="{{ $editEmp->address }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Birthday :</label>
                                <input type="text" name="birth_date" class="form-control" value="{{ $editEmp->birth_date }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-block">Role :</label>
                            <select name="role" class="form-control select2">
                                {{-- <option value="{{ $role->id }}">{{ $role->name }}</option> --}}
                                @foreach($role as $rol)
                                <option
                                value="{{ $rol->id}}"
                                @if($rol->id == $editEmp->role_id)
                                selected
                                @endif
                                >{{  $rol->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" value="Cancel" class="btn btn-primary mt-2 float-left">
                    <input type="submit" value="Submit" class="btn btn-danger mt-2 float-right">
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection
