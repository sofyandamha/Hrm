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
                <input name="date_attendance" type="text" class="form-control input-append date" id="datepicker"  data-date-format="yyyy-mm" placeholder="Choose Month" autocomplete="off">
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
                    <th>Jadwal Masuk</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    {{-- <th>Tanggal Scan</th> --}}
                    <th>Scan Masuk</th>
                    <th>Scan Keluar</th>
                    <th>Total Jam Kerja</th>
                    {{-- <th>Action</th> --}}
                </tr>
              @foreach ($data as $row)
                <tr>
                    {{-- <td>{{ $loop->iteration + $perPage * ($page - 1) }}</td> --}}
                    {{-- <td>{{$row->id_employee}}</td> --}}
                    <td>{{$row->Full_Name }}</td>
                    
                    <td>{{$row->Jadwal_Masuk}}</td>
                    <td>{{$row->Jam_Masuk}}</td>
                    <td>{{$row->Jam_Keluar}}</td>
                    {{-- <td>{{$row->Tanggal_Scan}}</td> --}}
                    <td>
                      @php
                        $loginTime = strtotime($row->Scan_Masuk);
                        $jam_masuk = strtotime($row->Jam_Masuk);
                        $difff = $jam_masuk - $loginTime;
                      @endphp 
                      
                      {{$row->Scan_Masuk}}
                      @if ($row->Scan_Masuk != "")
                        {{  ($difff < 0)? 'Terlambat!' : 'Right time!' }}
                          
                      @else
                          
                      @endif
                    
                    </td>
                    <td>{{$row->Scan_Keluar}}</td>
                    <td>
                      @php
                          $time_out = strtotime($row->Scan_Keluar);
                          $time_in = strtotime($row->Scan_Masuk);
                          $diff = $time_out - $time_in;
                      @endphp 

                      @if ($row->Scan_Masuk != "" && $row->Scan_Keluar != "")
                      {{ date('H:i', $diff) }}
                      
                        
                      @else
                        
                      @endif
                      
                    </td>
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
                {{-- <p>{{$tableinfo}}</p> --}}
              </div>

          <nav class="d-inline-block">
            <ul class="pagination mb-0">
                {{-- {{ $data->links() }} --}}
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
          format: "yyyy-mm",
          viewMode: "months", 
          minViewMode: "months"
    });
    </script>
@endpush'
