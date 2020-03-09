@extends('layouts.admin')
@section('title')
    <title>Status Employee</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-5 col-lg-5">
      <div class="card">
        <div class="card-header">
          <h4>Add New Status Employee</h4>
        </div>
        <div class="card-body">
            <form action="{{route('insert_statusEmployee')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Status Employee Name :</label>
                    <input type="text" name="status_name" class="form-control">
                </div>
                <div class="">
                    <input type="submit" class="btn btn-primary mt-2 float-right">
                </div>
            </form>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-7 col-lg-7">
      <div class="card">
        <div class="card-header">
          <h4>Data Status Employee</h4>

          <div class="float-right">
            <form action="{{route('show_statusEmployee')}}" method="get">
              <div class="input-group input-group-sm">
            <input type="text" name="r" class="form-control" placeholder="Status Employee Name" autocomplete="off">
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
                    <th>Status Employee</th>
                    <th>Created By</th>
                </tr>
              @foreach ($data as $row)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$row->status_name}}</td>
                    <td>{{$row->created_by}}</td>
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
