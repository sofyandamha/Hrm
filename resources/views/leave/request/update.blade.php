@extends('layouts.admin')
@section('title')
    <title>Leave Managament</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>Edit Request Leave</h4>
        </div>
        <div class="card-body">
            <form action="{{route('insert_requestApp')}}" method="post">
                    @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Employee Name :</label>
                                <select name="employee_name" class="form-control
                                @if (!Auth()->user()->id)
                                    selected
                                @endif">
                                    @if (Auth()->user()->id == 1)
                                        <option value=""></option>
                                        @foreach ($employee as $employees)
                                            <option value="{{ $employees->id }}"
                                            @if ($edit_requestApp->id == $employees->id)
                                                selected
                                            @endif>
                                                {{ $employees->full_name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="{{ Auth()->user()->id }}">{{ Auth()->user()->full_name }}</option>
                                    @endif
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="leaveType">Leave Type :</label>
                            <select class="form-control select2" name="leave_type" id="leaveType">
                                <option value=""></option>
                                @foreach ($leave_type as $leave_types)
                                    <option value="{{ $leave_types->id }}"
                                        @if ($edit_requestApp->id == $leave_types->id)
                                            selected
                                        @endif>
                                        {{ $leave_types->leave_type }}
                                    </option>
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
                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">Start :</label>
                                  <input type="text" class="form-control datepicker" id="" name="start_leave" value="{{ $edit_requestApp->start_leave }}">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="inputPassword4">End :</label>
                                  <input type="text" class="form-control datepicker" id="" name="end_leave" value="{{ $edit_requestApp->end_leave }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="remak">Remak</label>
                            <textarea name="remak" class="form-control">{{ $edit_requestApp->remak }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary mt-2 float-right" value="Update">
                    <a class="btn btn-danger" href="{{ route('show_requestApp') }}">Cancel</a>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection
