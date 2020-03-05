@extends('layouts.admin')
@section('title')
    <title>Symbol</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card">
        <div class="card-header">
          <h4>Edit Data Symbol</h4>
        </div>
        <div class="card-body">
                <form action=" {{route('update_symbol')}}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $editSymbol->id }}" name="id">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text">Symbol</span>
                            </div>
                            <input type="text" class="form-control" name="symbol_name" value="{{ $editSymbol->symbol_name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary float-right">
                    </div>
                </form>
        </div>
      </div>
    </div>
  </div>

@endsection
