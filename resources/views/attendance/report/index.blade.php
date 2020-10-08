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
                    <option value="">Select Employee</option>
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
                    <th>NIK</th>
                    <th>Employee Name</th>
                    <th>Tanggal</th>
                    <th>Scan Masuk Min</th>
                    <th>Scan Masuk Max</th>
                    <th>Scan Keluar Min</th>
                    <th>Scan Keluar Max</th>
                    <th>Scan Masuk Min FIX</th>
                    <th>Scan Keluar Max FIX</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Selisih Masuk</th>
                    <th>Selisih Keluar</th>
                    <th>Keterangan Masuk</th>
                    <th>Keterangan Pulang</th>
                </tr>
              @foreach ($data as $row)
                <tr>
                    <td>{{$row->scan_id}}</td>
                    <td>
                        @foreach ($employee as $emp)
                            @if ($emp->nik == $row->scan_id )
                                {{ $emp->full_name }}
                            @else

                            @endif
                        @endforeach
                    </td>
                    <td>{{$row->tglku }}</td>
                    <td>{{$row->JamMasukMin }}</td>
                    <td>{{$row->JamMasukMax }}</td>
                    <td>{{$row->JamKelMin }}</td>
                    <td>{{$row->JamKelMax }}</td>
                    <td>{{$row->JamMasukMinFix }}</td>
                    <td>{{$row->JamKelMaxFix }}</td>
                    <td>{{$row->in_time }}</td>
                    <td>{{$row->out_time }}</td>
                    <td>{{$row->selisihmasuk }}</td>
                    <td>{{$row->selisihkeluar }}</td>
                    <td>{{$row->KeteranganMasuk }}</td>
                    <td>{{$row->KeteranganPulang }}</td>
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

@push('jsCustom')
    <script>
        $("#datepicker").datepicker( {
          format: "yyyy-mm",
          viewMode: "months",
          minViewMode: "months"
    });
    </script>
@endpush'
