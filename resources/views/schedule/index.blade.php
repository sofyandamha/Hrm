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
                            <a class="btn btn-success " href="{{ route('addSchedule') }}" ><i class="fas fa-upload"></i> Add</a>
                            <a class="btn btn-warning " href="" data-toggle="modal" data-target="#modalBulk"><i class="fas fa-upload"></i> Import</a>
                            {{-- <a class="btn btn-warning " href="route('eksportSchedule')" ><i class="fas fa-download"></i> Eksport</a> --}}
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
                    <th>Employee Name</th>
                    <th>Department Name</th>
                    <th>Working Time</th>
                    <th>at Month</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
              @foreach ($data as $row)
                <tr>
                    <td>{{ $loop->iteration + $perPage * ($page - 1) }}</td>
                    <td>{{ $row->employee->full_name }}</td>
                    <td>{{ $row->department->name }}</td>
                    <td>{{ $row->workingtimge->workingTime_name.' : '.$row->workingtime->in_time." - ".$row->workingtime->out_time }}</td>
                    <td>{{ $row->month }}</td>
                    <td>{{$row->created_by}}</td>
                    <td>
                        <a class="btn btn-warning" href="{{route('edit_schedule',$row->id)}}"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger" href="{{route('delete_schedule',$row->id)}}"><i class="fas fa-trash"></i></a>
                    </td>
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

@endsection
