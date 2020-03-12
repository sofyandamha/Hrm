@extends('layouts.admin')
@section('title')
    <title>Scheduling</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>Edit Data Schedule</h4>
        </div>
        <div class="card-body">
            <form action="{{route('update_schedule')}}" method="post">
                    @csrf
                <input type="hidden" name="id" value="{{ $editSchedule->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Employee Name :</label>
                                <select name="employee_name" class="form-control select2">
                                    <option value="{{ $editSchedule->employee->id }}">{{ $editSchedule->employee->full_name }}</option>
                                    @foreach ($employee as $row)
                                    <option value="{{ $row->id }}">{{ $row->full_name }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Department Name :</label>
                                <select name="department_name" class="form-control select2">
                                    <option value="{{ $editSchedule->department->id }}">{{ $editSchedule->department->name }}</option>
                                    @foreach ($department as $row )
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Working Time :</label>
                                <select name="working_time" class="form-control select2">
                                    <option value="{{ $editSchedule->workingtime->id }}">{{ $editSchedule->workingtimge->workingTime_name.' : '.$editSchedule->workingtime->in_time.'-'.$editSchedule->workingtime->out_time }}</option>
                                    @foreach ($workingtime as $row)
                                        <option value="{{ $row->id }}">{{ $row->in_time." - ".$row->out_time }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-block">Is Supervisor :</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="1" name="is_supervisor" id="inlineCheckbox1"
                                @if ($editSchedule->is_supervisor == 1)
                                checked
                                @else

                                @endif
                                >
                                <label class="form-check-label" for="inlineCheckbox1">Supervisor</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="name">Month :</label>
                                <input type="text" id="datemonth" name="is_month" value="{{ $editSchedule->month }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary mt-2 float-right" value="Submit">
                    <a class="btn btn-danger" href="{{ route('show_schedule') }}">Cancel</a>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection
