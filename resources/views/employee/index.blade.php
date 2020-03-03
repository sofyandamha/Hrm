@extends('layouts.admin')
@section('title')
    <title>Employee</title>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="col-lg-12">
                <div class="row">
                    <h4>Data Employee</h4>
                    <a class="btn btn-warning" href="" data-toggle="modal" data-target="#modalBulk">Import <i class="fas fa-upload"></i></a>
                    <a class="btn btn-warning" href="{{ route('eksportEmployee')}}" >Eksport <i class="fas fa-download"></i></a> &nbsp;
                    <div class="card-header-action">

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
                    <th>Number</th>
                    <th>Employee Name</th>
                    <th>Department Name</th>
                    <th>Work Time</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
              @foreach ($data as $row)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$row->full_name}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$row->created_by}}</td>
                    <td>
                        <a class="btn btn-warning" href="{{route('edit_employee',$row->id)}}"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger" href="{{route('delete_employee',$row->id)}}"><i class="fas fa-trash"></i></a>
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
