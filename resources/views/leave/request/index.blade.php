@extends('layouts.admin')
@section('title')
    <title>Leave Managament</title>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Data Request Leave</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-left">
                            <a class="btn btn-success " href="{{ route('add_requestApp') }}" ><i class="fas fa-upload"></i> Add</a>
                            {{-- <a class="btn btn-warning " href="" data-toggle="modal" data-target="#modalBulk"><i class="fas fa-upload"></i> Import</a> --}}
                            {{-- <a class="btn btn-warning " href="{{ route('export_request')}}" ><i class="fas fa-download"></i> Eksport</a> --}}
                        </div>
                    </div>
                    <div class="col-md-7"></div>
                    <div class="col-md-2">
                        <form action="{{route('show_requestApp')}}" method="get">
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
                    <th>Scan ID</th>
                    <th>Department Name</th>
                    <th>Employee Name</th>
                    <th>Leave Type</th>
                    <th>Request Duration</th>
                    <th>Request Date</th>
                    <th>Number of Day</th>
                    <th>Remark</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              @foreach ($data as $row)
                <tr>
                    {{-- <td>{{ $loop->iteration + $perPage * ($page - 1) }}</td> --}}
                    <td>{{$row->employee->scan_id}}</td>
                    <td>{{ $row->employee->department->name }}</td>
                    <td>{{ $row->employee->full_name }}</td>
                    <td>{{ $row->leave_type->leave_type}}</td>
                    <td>{{ $row->start_leave}}<b>  to  </b>{{ $row->end_leave }}</td>
                    <td>{{ $row->created_at->format('Y-m-d')}}</td>
                    <td>
                        {{
                            round((strtotime($row->end_leave) - strtotime($row->start_leave)) / (60 * 60 * 24))
                        }}
                    </td>
                    <td>{{ $row->remak}}</td>
                    <td>
                        @if ($row->status == 1)
                            <div class="badge badge-success">Approved</div>
                        @elseif ($row->status == 2)
                            <div class="badge badge-danger">Reject</div>
                        @else
                            <div class="badge badge-warning">Pending</div>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-warning" href="{{route('edit_requestApp',$row->id)}}"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger" href="{{route('delete_requestApp',$row->id)}}"><i class="fas fa-trash"></i></a>
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

@endsection
