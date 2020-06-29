@extends('layouts.admin')
@section('title')
    <title>Report Attendance</title>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Data Attendance</h4>
        </div>
        <div class="card-body">

        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-md">
              <tbody>
                <tr>
                    <th>No</th>
                    <th>Scan_id</th>
                    <th>Employee Name</th>
                    <th>Scan In</th>
                    <th>Scan Out</th>
                </tr>
              {{-- @foreach ($data as $row)
                <tr>
                    <td>{{ $loop->iteration + $perPage * ($page - 1) }}</td>
                    <td>{{$row->scan_id}}</td>
                    <td>{{ $row->nik }}</td>
                    <td> @if ($row->is_supervisor == 1)
                        {{ $row->full_name }} <div class="badge badge-warning">Supervisor</div>
                    @else
                        {{ $row->full_name }}
                    @endif
                    </td>
                    <td>
                        @isset($row->department->name)
                            {{ $row->department->name }}
                        @endisset
                    </td>
                    <td>{{ $row->address }}</td>
                    <td>{{ $row->birth_date }}</td>
                    <td></td>
                    <td>{{$row->created_by}}</td>
                    <td>
                        <a class="btn btn-warning" href="{{route('edit_employee',$row->id)}}"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger" href="{{route('delete_employee',$row->id)}}"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
              @endforeach --}}
                </tbody>
            </table>
          </div>
        </div>

        {{-- <div class="card-footer text-right">
            <div class="float-left">
                <p>{{$tableinfo}}</p>
              </div>

          <nav class="d-inline-block">
            <ul class="pagination mb-0">
                {{ $data->links() }}
            </ul>
          </nav>
        </div> --}}
      </div>
    </div>
</div>

@endsection
