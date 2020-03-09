@extends('layouts.admin')
@section('title')
    <title>Deduction</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card">
        <div class="card-header">
          <h4>Edit Data Deduction</h4>
        </div>
        <div class="card-body">
                <form action=" {{route('update_deduction')}}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $editDeduction->id }}" name="id">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text">Tax Rule</span>
                            </div>
                            <input type="text" class="form-control" name="deduction_name" value="{{ $editDeduction->deduction_name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Tax Rate</span>
                            </div>
                            <input type="number" class="form-control" name="deduction_amount" aria-label="" value="{{ $editDeduction->deduction_amount }}">
                            <select class="custom-select select" data-placeholder="Choose Type..." required name="symbol">
                                <option value=""></option>
                                @foreach ($editSymbol as $symbols)
                                    <option value="{{ $symbols->id }}">
                                        @isset($symbols->symbol_name)
                                            {{ $symbols->symbol_name }}
                                        @endisset
                                    </option>
                                @endforeach
                            </select>
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