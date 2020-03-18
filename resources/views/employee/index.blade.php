@extends('layouts.admin')
@section('title')
    <title>Employee</title>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Data Employee</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-left">
                            <a class="btn btn-success " href="{{ route('addEmployee') }}" ><i class="fas fa-upload"></i> Add</a>
                            <a class="btn btn-warning " href="" data-toggle="modal" data-target="#modalBulk"><i class="fas fa-upload"></i> Import</a>
                            <a class="btn btn-warning " href="{{ route('eksportEmployee')}}" ><i class="fas fa-download"></i> Eksport</a>
                        </div>
                    </div>
                    <div class="col-md-7"></div>
                    <div class="col-md-2">
                        <form action="{{route('show_employee')}}" method="get">
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
                    <th>Scan_id</th>
                    <th>NIK</th>
                    <th>Employee Name</th>
                    <th>Department Name</th>
                    <th>Address</th>
                    <th>Birthday</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
              @foreach ($data as $row)
                <tr>
                    <td>{{ $loop->iteration + $perPage * ($page - 1) }}</td>
                    <td>{{$row->scan_id}}</td>

                    <td>{{ $row->nik }}</td>
                    <td>
                        {{ $row->full_name }}
                        @foreach ($role as $roleku)
                            @if ($roleku->id == $row->id )
                                <br><div class="badge badge-warning"> {{ $roleku->name }} </div>
                            @else

                            @endif
                        @endforeach

                        {{-- <div class="badge badge-warning"></div> --}}
                    </td>
                    <td>
                        @foreach ($department as $departments)
                            @if ($departments->id == $row->id_department)
                                {{ $departments->name }}
                            @else

                            @endif
                        @endforeach
                    </td>
                    <td>{{ $row->address }}</td>
                    <td>{{ $row->birth_date }}</td>
                    <td></td>
                    <td>{{$row->created_by}}</td>
                    <td>
                        <a class="btn btn-warning" href="{{route('edit_employee',$row->scan_id)}}"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger" href="{{route('delete_employee',$row->scan_id)}}"><i class="fas fa-trash"></i></a>
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
          <h5 class="modal-title">Bulk Employee</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- bulk data form excel --}}
            <form action="{{ route('bulk_employee') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <input type="file" name="namaEmployee" class="form-control">
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
