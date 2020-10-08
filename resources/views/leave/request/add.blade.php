@extends('layouts.admin')
@section('title')
    <title>Leave Managament</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>Add Request Leave</h4>
        </div>
        <div class="card-body">
            <form action="{{route('check_requestApp', [
                'empId'=> request('employee_id'),
                'leaveId'=> request('leave_type_id'),
                'leave_date'=> request('leave_date')
            ])}}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Employee Name :</label>
                                @php
                                    $user = Auth()->user();
                                    $roles = $user->roles->pluck('name');
                                @endphp
                                @if ($roles[0] == "HRD Manager" || $roles[0] == "HRD Admin Supervisor")
                                <select name="employee_id" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($employee as $employees)
                                            <option value="{{ $employees->id }}">{{ $employees->full_name }}</option>
                                        @endforeach
                                </select>
                                @else
                                    <input type="hidden"  value="{{ Auth()->user()->id }}" name="employee_id">
                                    <input class="form-control" value="{{ Auth()->user()->full_name }}" type="text" readonly>
                                @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="leaveType">Leave Type :</label>
                            <select class="form-control select2" name="leave_type_id" id="leaveType">
                                <option value=""></option>
                                @foreach ($leave_type as $leave_types)
                                    <option value="{{ $leave_types->id }}">{{ $leave_types->leave_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Request Duration :</label>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                  <input type="text" class="form-control daterange" name="leave_date">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="remak">Remak</label>
                            <textarea name="remak" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" value="Check" class="btn btn-primary mt-2 float-right" ></input>
                </div>
            </form>

        </div>
      </div>
    </div>
</div>
@endsection

@push('jsCustom')
@endpush
