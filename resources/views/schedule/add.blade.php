@extends('layouts.admin')
@section('title')
    <title>Scheduling</title>
@endsection

@section('content')
<div class="row">
    <div class="col-4 col-md-4 col-lg-4">
        <div class="card">
          <div class="card-header">
            <h4>Add New Schedule</h4>
          </div>
          <form method="POST" action="{{ route('insert_schedule')}}">
              @csrf
            <div class="card-body">
                <div class="form-group">
                        <label for="name">Employee Name :</label>
                        <select name="employee_id" class="form-control select2">
                            <option value=""></option>
                            @foreach ($employee as $row)
                            <option value="{{ $row->id }}">{{ $row->full_name }}</option>
                            @endforeach
                        </select>
                </div>
              <div id="table-responsive" class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>Tanggal</th>
                        <th>Work Time</th>
                    </thead>
                    <tbody>
                        @foreach ($datatgl as $row  => $schedule_detail)
                            <tr>
                                <td>
                                    <input type="text" name="schedule_detail[{{$row}}][date_id]" value="{{$schedule_detail->id}}" hidden>
                                    {{ date('l d F Y', strtotime($schedule_detail->full_date)) }}
                                </td>
                                <td>
                                    <select name="schedule_detail[{{$row}}][working_time]" class="form-control select2">
                                        <option value="">Off</option>
                                        @foreach ($workingtime as $row)
                                            <option value="{{ $row->id }}">{{$row->in_time." - ".$row->out_time }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

              </div>

            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
          </form>
        </div>
      </div>
</div>
@endsection
