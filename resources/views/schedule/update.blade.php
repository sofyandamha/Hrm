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
            <form method="POST" action="{{ route('update_schedule')}}">
                @csrf
              <div class="card-body">
                  <div class="form-group">
                          <label for="name">Employee Name : {{ $schedule->Employee->full_name." - ".$schedule->Employee->Designation->Department->name }}
                           </label>
                  </div>
                <div id="table-responsive" class="table-responsive">
                  <table class="table table-bordered">
                      <thead>
                          <th>Tanggal</th>
                          <th>In Time</th>
                          <th>Out Time</th>
                      </thead>
                      <tbody>
                        @foreach ($scheduledetail  as $row  => $schedule_det)
                                  <tr>
                                      <td>
                                          <input type="text" name="schedule_det[{{$row}}][sched_id]" value="{{$schedule_det->id}}" hidden>
                                          {{ date('l d F Y', strtotime($schedule_det->date_work)) }}
                                      </td>
                                      <td>
                                          <input type="text" class="form-control timepicker" name="schedule_det[{{$row}}][in_time]" value="{{ $schedule_det->in_time }}">
                                      </td>
                                      <td>
                                          <input type="text" class="form-control timepicker" name="schedule_det[{{$row}}][out_time]" value="{{ $schedule_det->out_time }}">
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
</div>
@endsection
