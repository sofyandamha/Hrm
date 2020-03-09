@extends('layouts.admin')
@section('title')
    <title>Leave Type</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-5 col-lg-5">
      <div class="card">
        <div class="card-header">
          <h4>Add New Leave Type</h4>
        </div>
        <div class="card-body">
            <form action="{{route('insert_leaveType')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Leave Type Name :</label>
                    <input type="text" name="leave_type" class="form-control">
                </div>
                <div class="form-group">
                    <label for="name">Number of Day :</label>
                    <input type="number" name="is_day" class="form-control">
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
          <h4>Data Leave Type</h4>

          <div class="float-right">
            <form action="{{route('show_leaveType')}}" method="get">
              <div class="input-group input-group-sm">
            <input type="text" name="r" class="form-control" placeholder="Leave Type Name" autocomplete="off">
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
                    <th>Leave Type</th>
                    <th>Number of Day</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
              @foreach ($data as $row)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$row->leave_type}}</td>
                    <td>{{$row->is_day}}</td>
                    <td>{{$row->created_by}}</td>
                    <td>
                        <a class="btn btn-warning" href="{{route('edit_leaveType',$row->id)}}"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger" href="{{route('delete_leaveType',$row->id)}}"><i class="fas fa-trash"></i></a>
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
