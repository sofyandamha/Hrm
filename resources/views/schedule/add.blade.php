@extends('layouts.admin')
@section('title')
    <title>Scheduling</title>
@endsection

@section('content')
<div class="row">
    <div class="col-8 col-md-8 col-lg-8">
        <div class="card">
          <div class="card-header">
            <h4>Add New Schedule</h4>
          </div>
          <form method="POST" action="{{ route('insert_schedule')}}">
              @csrf
            <div class="card-body">
                <div class="form-group">
                        <label for="name">Employee Name :

                            @php
                                if($employee->Designation->Department->is_officeHour == 1)
                                {
                                   echo $employee->full_name." - Office Hour - ".$employee->Designation->Department->name ;
                                }
                                else{
                                    echo $employee->full_name." - Not Office Hour -".$employee->Designation->Department->name;
                                }
                            @endphp
                         </label>
                        <input type="hidden" name="id_emp" value="{{ $employee->scan_id }}">
                </div>
              <div id="table-responsive" class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>Tanggal</th>
                        <th>In Time</th>
                        <th>Out Time</th>
                    </thead>
                    <tbody>
                        @foreach ($datatgl as $row  => $schedule_detail)
                            @if ($employee->Designation->Department->is_officeHour == 1)


                                    @php
                                        $hari =  date('l', strtotime($schedule_detail->full_date));
                                    @endphp
                                    <tr>

                                        @if ($hari == "Saturday" || $hari == "Sunday")

                                        @else
                                            <td>
                                                <input type="text" name="schedule_detail[{{$row}}][date_work]" value="{{$schedule_detail->full_date}}" hidden>
                                                {{ date('l d F Y', strtotime($schedule_detail->full_date)) }}
                                            </td>
                                            <td>
                                                <input type="text" class="form-control timepicker" name="schedule_detail[{{$row}}][in_time]" value="09:30" readonly >
                                            </td>
                                            <td>
                                                <input type="text" class="form-control timepicker" value="18:30" name="schedule_detail[{{$row}}][out_time]" readonly>
                                            </td>
                                        @endif
                                    </tr>

                            @else
                                <tr>
                                    <td>
                                        <input type="text" name="schedule_detail[{{$row}}][date_id]" value="{{$schedule_detail->id}}" hidden>
                                        {{ date('l d F Y', strtotime($schedule_detail->full_date)) }}
                                    </td>
                                    <td>
                                        {{-- <select name="schedule_detail[{{$row}}][working_time]" class="form-control select2">
                                            <option value="0">Off</option>
                                            @foreach ($workingtime as $row)
                                                <option value="{{ $row->id }}">{{$row->workingTime_name." - ".$row->in_time." - ".$row->out_time }}</option>
                                            @endforeach
                                        </select> --}}
                                        <input type="text" class="form-control timepicker" value="00:00">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control timepicker" value="00:00">
                                    </td>

                                </tr>

                            @endif
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
