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
                    <th>Employee Name</th>
                    <th>Department Name</th>
                    <th>Leave Type</th>
                    <th>Request Duration</th>
                    <th>Days</th>
                    <th>Request Date</th>
                    <th>Remark</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
              @foreach ($data as $row)
                @if (Auth()->user()->id == $row->id_employee || Auth()->user()->id == 1)
                <tr>
                    {{-- <td>{{ $loop->iteration + $perPage * ($page - 1) }}</td> --}}
                    <td>{{$row->employee->scan_id}}</td>
                    <td>{{ $row->employee->full_name }}</td>
                    <td>{{ $row->employee->designation->name.' - '.$row->employee->designation->department->name }}</td>
                    <td>{{ $row->leavetype->leave_type.' ('.$row->leavetype->is_day.')'}}</td>
                    <td>{{ $row->start_leave}}<b>  to  </b>{{ $row->end_leave }}</td>
                    <td>
                        {{ $row->totalhari }}
                     </td>
                    <td>{{ $row->created_at->format('Y-m-d')}}</td>
                    <td>{{ $row->remarks}}</td>
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
                        @if (Auth()->user()->id == 1)
                            @if ($row->status == 0)
                                <a class="badge badge-primary" href="{{route('approved_requestApp',$row->id)}}"><i class="fas fa-check"></i></a>
                                <a class="badge badge-danger" href="{{route('rejected_requestApp',$row->id)}}"><i class="fas fa-times"></i></a>
                            @else
                                <a class="badge badge-warning" href="{{route('cancel_requestApp',$row->id)}}"><i class="fas fa-undo"></i></a>
                            @endif

                        @elseif($row->status == 0)
                            <a class="btn btn-warning" href="{{route('edit_requestApp',$row->id)}}"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-danger" href="{{route('delete_requestApp',$row->id)}}"><i class="fas fa-trash"></i></a>
                        @else
                        <div class="form-group">
                            <label for="noaction">No Action</label>
                        </div>
                        @endif
                    </td>
                </tr>
                @endif
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
