@extends('layouts.admin')
@section('title')
    <title>Scheduling</title>
@endsection

@section('content')
<div class="row">
    <div class="col-6 col-md-6 col-lg-6">
        <div class="card">
          <div class="card-header">
            <h4>Add New Schedule</h4>
          </div>
          <div class="card-body">
                <div class="form-group">
                        <label for="name">Employee Name :</label>
                        <select name="employee_name" class="form-control select2">
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
                        @foreach ($datatgl as $row)
                            <tr>
                                <td>{{ date('D-m-Y', strtotime($row->full_date)) }}</td>
                                <td>
                                    <select name="working_time" class="form-control select2">
                                        @foreach ($workingtime as $row)
                                            <option value="{{ $row->id }}">{{ $row->workingTime_name.' : '.$row->in_time." - ".$row->out_time }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

              </div>
          </div>
        </div>
      </div>
</div>
@endsection
