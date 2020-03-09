@extends('layouts.admin')
@section('title')
    <title>Working Time</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card">
        <div class="card-header">
          <h4>Add New Working Time</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="text-left mb-3">
                    <a class="btn btn-warning" href="" data-toggle="modal" data-target="#modalBulk"><i class="fas fa-upload"></i> Import</a>
                </div>
            </div>
            <form action="{{route('insert_workingTime')}}" method="post">
                    @csrf
                <div class="form-group">
                    <label for="name">In Time :</label>
                        <input type="number" name="in_time" class="form-control">
                </div>
                <div class="form-group">
                    <label for="name">Out Time :</label>
                        <input type="number" name="out_time" class="form-control">
                </div>
                <div class="">
                    <input type="submit" class="btn btn-primary mt-2 float-right">
                </div>
            </form>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card">
        <div class="card-header">
          <h4>Data Working Time</h4>

          <div class="float-right">
            <form action="{{route('show_workingTime')}}" method="get">
              <div class="input-group input-group-sm">
            <input type="text" name="r" class="form-control" placeholder="Working Time" autocomplete="off">
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-primary "><i class="fa fa-search"></i></button>
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
                    <th>No</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
              @foreach ($data as $row)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$row->in_time}}</td>
                    <td>{{$row->out_time}}</td>
                    <td>{{$row->created_by}}</td>
                    <td>
                        <a class="btn btn-warning" href="{{route('edit_workingTime',$row->id)}}"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger" href="{{route('delete_workingTime',$row->id)}}"><i class="fas fa-trash"></i></a>
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
          <h5 class="modal-title">Bulk Working Time</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- bulk data form excel --}}
            <form action="{{ route('bulk_workingTime') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <input type="file" name="namaWorkingtime" class="form-control">
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
