@extends('layouts.admin')
@section('title')
    <title>Scheduling</title>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Add Schedule</h4>
        </div>
    <form action="{{ route('findSchedule') }}" method="POST">
        @csrf
        <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="name">Employee Name :</label>
                        <select name="employee_id" class="form-control select2">
                            <option value=""></option>
                            @foreach ($employee as $row)
                            <option value="{{ $row->scan_id }}">{{ $row->scan_id."-".$row->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="name">Month:</label>
                        <input type="text" name="month" class="form-control datepickers" id="" autocomplete="off">
                    </div>
                </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Check</button>
        </div>
    </form>

      </div>
    </div>
</div>

@endsection

@push('jsCustom')
    <script>
       $('.datepickers').datepicker({
            format: 'yyyy-mm'
        });
    </script>
@endpush
