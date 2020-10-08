@extends('layouts.admin')
@section('title')
    <title>Scheduling</title>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Data Schedule</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-left">
                            @php
                                $user = Auth()->user();
                                $roles = $user->roles->pluck('name');
                                $is_supervisor = Auth()->user()->is_supervisor;
                            @endphp

                            @if ($roles[0] == "HRD Manager" || $roles[0] == "HRD Admin Supervisor" )
                                <a class="btn btn-success " href="{{ route('checkSchedule') }}" ><i class="fas fa-upload"></i> Add</a>
                                <a class="btn btn-warning " href="" data-toggle="modal" data-target="#modalBulk"><i class="fas fa-upload"></i> Import Schedule</a>
                                <a class="btn btn-primary " href="" data-toggle="modal" data-target="#modalBulkAttLog"><i class="fas fa-upload"></i> Import AttLog</a>
                            @else
                                @if ($is_supervisor == 1 )
                                    <a class="btn btn-success " href="{{ route('checkSchedule') }}" ><i class="fas fa-upload"></i> Add</a>
                                @else
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="col-md-7"></div>
                    <div class="col-md-2">
                        <form action="{{route('show_schedule')}}" method="get">
                            <div class="input-group input-group-sm">
                                <input type="text" name="r" class="form-control" placeholder="Search" autocomplete="off">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-primary "><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-md">
              <tbody>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Employee Name</th>
                    <th>Date</th>
                    <th>Working Time</th>
                    <th>Month</th>
                    <th>Created at</th>
                </tr>
              @foreach ($data as $row)
                <tr>
                    <td>{{ $loop->iteration + $perPage * ($page - 1) }}</td>
                    <td>{{ $row->employee->scan_id }}</td>
                    <td>{{ $row->employee->full_name }}</td>
                    <td>{{ $row->date_work }}</td>
                    <td>{{ $row->in_time." - ".$row->out_time }}</td>
                    <td>{{ date('F', strtotime($row->date_work)) }}</td>
                    <td>{{ $row->created_at}}</td>
                </tr>
              @endforeach
                </tbody>
            </table>
          </div>
        </div>

        <div class="card-footer text-right">
            <div class="float-left">
                <p>{{$tableinfo}}</p>
              </div>

          <nav class="d-inline-block">
            <ul class="pagination mb-0">
                {{ $data->links() }}
            </ul>
          </nav>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modalBulk">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Bulk Scheduling</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('bulk_schedule') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <input type="file" name="schedule" class="form-control">
                </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <input type="submit" class="btn btn-secondary float-left" value="Close" data-dismiss="modal">
          <input type="submit" class="btn btn-primary" value="Submit">
            </form>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modalBulkAttLog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Bulk AttLog</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('bulk_attlog') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <input type="file" name="attlog" class="form-control">
                </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <input type="submit" class="btn btn-secondary float-left" value="Close" data-dismiss="modal">
          <input type="submit" class="btn btn-primary" value="Submit">
            </form>
        </div>
      </div>
    </div>
</div>

@endsection
