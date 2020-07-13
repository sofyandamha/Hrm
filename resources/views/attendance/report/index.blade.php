@extends('layouts.admin')
@section('title')
    <title>Report Attendance</title>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Report Attendance</h4>
           
        </div>
        <div class="card-body">
          <div class="float-right">
            <form method="get" action="{{ route('show_report') }}">
              <div class="input-group">
                <select class="form-control select2 " name="scan_id" >
                  <option value="">Select Employee Name</option>
                    @foreach ($employee as $emp)
                      <option value="{{ $emp->scan_id }}">{{ $emp->full_name }}</option>
                    @endforeach
                </select>
                <input name="date_attendance" type="text" class="form-control input-append date" id="datepicker"  data-date-format="mm/yyyy" placeholder="Choose Month" autocomplete="off">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-md">
              <tbody>
                <tr>
                    {{-- <th>No</th> --}}
                    {{-- <th>Scan_id</th> --}}
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Tanggal</th>
                    <th>Scan In</th>
                    <th>Scan Out</th>
                    {{-- <th>Action</th> --}}
                </tr>
              @foreach ($data as $row)
                <tr>
                    {{-- <td>{{ $loop->iteration + $perPage * ($page - 1) }}</td> --}}
                    {{-- <td>{{$row->id_employee}}</td> --}}
                    <td>{{$row->employee_name }}</td>
                    <td>
                      @foreach ($department as $dept)
                          @if ($dept->id ==  $row->employee_department )
                              {{ $dept->name }}
                          @else
                          @endif
                      @endforeach
                    </td>
                    <td>{{$row->tanggal}}</td>
                    <td>{{$row->in_time}}</td>
                    <td>{{$row->out_time}}</td>
                    {{-- <td>
                        <a class="btn btn-warning" href="{{route('edit_employee',$row->id)}}"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger" href="{{route('delete_employee',$row->id)}}"><i class="fas fa-trash"></i></a>
                    </td> --}}
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

@push('jsCustom')
    <script>
        $("#datepicker").datepicker( {
          format: "mm/yyyy",
          viewMode: "months", 
          minViewMode: "months"
    });
    </script>
@endpush'
