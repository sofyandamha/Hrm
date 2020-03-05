@extends('layouts.admin')
@section('title')
    <title>Payroll</title>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Data Payroll</h4>
            </div>
            <div class="card-body">
              <ul class="nav nav-pills" id="myTab3" role="tablist">
                <li class="nav-item">
                  <a class="nav-link {{old('tabName') == 'taxRule2' ? 'active' : '' }}" id="takeRule1" data-toggle="tab" href="#taxRule2" role="tab" aria-controls="takeRule">Take Rule</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{old('tabName') == 'lateConfig2' ? 'active' : '' }}" id="lateConfig1" data-toggle="tab" href="#lateConfig2" role="tab" aria-controls="lateConfig">Late Config</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{old('tabName') == 'allowance2' ? 'active' : '' }}" id="allowance1" data-toggle="tab" href="#allowance2" role="tab" aria-controls="allowance">Allowance</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{old('tabName') == 'deduction2' ? 'active' : '' }}" id="deduction1" data-toggle="tab" href="#deduction2" role="tab" aria-controls="deduction">Deduction</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{old('tabName') == 'symbol2' ? 'active' : '' }}" id="symbol1" data-toggle="tab" href="#symbol2" role="tab" aria-controls="symbol">Symbol</a>
                  </li>
              </ul>
              <div class="tab-content pt-4" id="myTabContent2">
                <div class="tab-pane fade {{old('tabName') == 'taxRule2' ? 'active show' : '' }}" id="taxRule2" role="tabpanel" aria-labelledby="takeRule1">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="text-left mb-3">
                                <a class="btn btn-warning" href="" data-toggle="modal" data-target="#modalBulktaxsetup"><i class="fas fa-upload"></i> Import</a>
                                <a class="btn btn-warning" href="{{route('eksportTaxsetup')}}" ><i class="fas fa-download"></i> Eksport</a>
                            </div>
                            <form action="{{route('insert_taxsetup')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">Tax Rule</span>
                                        </div>
                                        <input type="text" class="form-control" name="tax_rule">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">Tax Rate</span>
                                        </div>
                                        <input type="number" class="form-control" name="tax_rate" aria-label="">
                                        <select class="custom-select select" data-placeholder="Choose Type..." required name="symbol">
                                            <option value=""></option>
                                            @foreach ($symbol as $symbols)
                                                <option value="{{ $symbols->id }}">
                                                    @isset($symbols->symbol_name)
                                                        {{ $symbols->symbol_name }}
                                                    @endisset
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary mt-2 float-right">
                            </form>
                        </div>
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                  <tbody>
                                    <tr>
                                        <th>No</th>
                                        <th>Tax Rule</th>
                                        <th>Tax Rate</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($taxsetup as $taxs)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$taxs->tax_rule}}</td>
                                            <td>
                                                @isset($taxs->symboll->symbol_name)
                                                    @if ($taxs->symboll->symbol_name === "Rp")
                                                        {{ $taxs->symboll->symbol_name." ".$taxs->tax_rate }}
                                                        @else
                                                        {{ $taxs->tax_rate ." ". $taxs->symboll->symbol_name }}
                                                    @endif
                                                @endisset
                                            </td>
                                            <td></td>
                                            <td>
                                                <a class="btn btn-warning" href="{{route('edit_taxsetup',$taxs->id)}}"><i class="fas fa-edit"></i></a>
                                                <a class="btn btn-danger" href="{{route('delete_taxsetup',$taxs->id)}}"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{old('tabName') == 'lateConfig2' ? 'active show' : '' }}" id="lateConfig2" role="tabpanel" aria-labelledby="lateConfig1">
                    <div class="row">
                        <div class="col-md-5">
                            {{-- <div class="text-left mb-3">
                                <a class="btn btn-warning" href="" data-toggle="modal" data-target="#modalBulktaxsetup"><i class="fas fa-upload"></i> Import</a>
                                <a class="btn btn-warning" href="{{ route('eksportDepartment')}}" ><i class="fas fa-download"></i> Eksport</a>
                            </div> --}}
                            <form action="{{ route('insert_lateconfig') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">Late Config</span>
                                        </div>
                                        <input type="number" class="form-control" aria-label="" name="late_config">
                                        <div class="input-group-append">
                                          <span class="input-group-text">/Menit</span>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary mt-2 float-right">
                            </form>
                        </div>
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                  <tbody>
                                    <tr>
                                        <th>No</th>
                                        <th>Late Config</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($lateconfig as $lateconfigs)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$lateconfigs->late_config}} /Menit</td>
                                            <td></td>
                                            <td>
                                                <a class="btn btn-warning" href="{{route('edit_lateconfig',$lateconfigs->id)}}"><i class="fas fa-edit"></i></a>
                                                <a class="btn btn-danger" href="{{route('delete_lateconfig',$lateconfigs->id)}}"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{old('tabName') == 'allowance2' ? 'active show' : '' }}" id="allowance2" role="tabpanel" aria-labelledby="allowance1">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="text-left mb-3">
                                <a class="btn btn-warning" href="" data-toggle="modal" data-target="#modalBulkallowance"><i class="fas fa-upload"></i> Import</a>
                                <a class="btn btn-warning" href="{{ route('eksportAllowance')}}" ><i class="fas fa-download"></i> Eksport</a>
                            </div>
                            <form action="{{ route('insert_allowance') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">Allowance Name</span>
                                        </div>
                                        <input type="text" class="form-control" name="allowance_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">Allowance Amount</span>
                                        </div>
                                        <input type="number" class="form-control" name="allowance_amount" aria-label="">
                                        <select class="custom-select select" data-placeholder="Choose Type..." required name="symbol">
                                            <option value=""></option>
                                            @foreach ($symbol as $symbols)
                                                <option value="{{ $symbols->id }}">
                                                    @isset($symbols->symbol_name)
                                                        {{ $symbols->symbol_name }}
                                                    @endisset
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary mt-2 float-right">
                            </form>
                        </div>
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                  <tbody>
                                    <tr>
                                        <th>No</th>
                                        <th>Allowance Name</th>
                                        <th>Allowance Amount</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($allowance as $allowances)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$allowances->allowance_name}}</td>
                                            <td>
                                                @isset($allowances->symboll->symbol_name)
                                                    @if ($allowances->symboll->symbol_name === "Rp")
                                                        {{ $allowances->symboll->symbol_name." ".$allowances->allowance_amount }}
                                                        @else
                                                        {{ $allowances->allowance_amount ." ". $allowances->symboll->symbol_name }}
                                                    @endif
                                                @endisset
                                            </td>
                                            <td></td>
                                            <td>
                                                <a class="btn btn-warning" href="{{route('edit_allowance',$allowances->id)}}"><i class="fas fa-edit"></i></a>
                                                <a class="btn btn-danger" href="{{route('delete_allowance',$allowances->id)}}"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{old('tabName') == 'deduction2' ? 'active show' : '' }}" id="deduction2" role="tabpanel" aria-labelledby="deduction1">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="text-left mb-3">
                                <a class="btn btn-warning" href="" data-toggle="modal" data-target="#modalBulkdeduction"><i class="fas fa-upload"></i> Import</a>
                                <a class="btn btn-warning" href="{{ route('eksportDeduction')}}" ><i class="fas fa-download"></i> Eksport</a>
                            </div>
                            <form action="{{ route('insert_deduction') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">Deduction Name</span>
                                        </div>
                                        <input type="text" class="form-control" name="deduction_name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">Deduction Amount</span>
                                        </div>
                                        <input type="number" class="form-control" name="deduction_amount" aria-label="" required>
                                        <select class="custom-select select" data-placeholder="Choose Type..." required name="symbol">
                                            <option value=""></option>
                                            @foreach ($symbol as $symbols)
                                                <option value="{{ $symbols->id }}">
                                                    @isset($symbols->symbol_name)
                                                        {{ $symbols->symbol_name }}
                                                    @endisset
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary mt-2 float-right">
                            </form>
                        </div>
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                  <tbody>
                                    <tr>
                                        <th>No</th>
                                        <th>Deduction Name</th>
                                        <th>Deduction Amount</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($deduction as $deductions)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$deductions->deduction_name}}</td>
                                            <td>
                                                @isset($deductions->symboll->symbol_name)
                                                    @if ($deductions->symboll->symbol_name === "Rp")
                                                        {{ $deductions->symboll->symbol_name." ".$deductions->deduction_amount }}
                                                        @else
                                                        {{ $deductions->deduction_amount ." ". $deductions->symboll->symbol_name }}
                                                    @endif
                                                @endisset
                                            </td>
                                            <td></td>
                                            <td>
                                                <a class="btn btn-warning" href="{{route('edit_deduction',$deductions->id)}}"><i class="fas fa-edit"></i></a>
                                                <a class="btn btn-danger" href="{{route('delete_deduction',$deductions->id)}}"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{old('tabName') == 'symbol2' ? 'active show' : '' }}" id="symbol2" role="tabpanel" aria-labelledby="symbol1">
                    <div class="row">
                        <div class="col-md-5">
                            <form action="{{route('insert_symbol')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">Symbol Name</span>
                                        </div>
                                        <input name="symbol_name" type="text" class="form-control">
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary mt-2 float-right">
                            </form>
                        </div>
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                  <tbody>
                                    <tr>
                                        <th>No</th>
                                        <th>Symbol Name</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($symbol as $row)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                               @isset($row->symbol_name)
                                               {{$row->symbol_name}}
                                               @endisset
                                            </td>
                                            <td></td>
                                            <td>
                                                <a class="btn btn-warning" href="{{ route('edit_symbol',$row->id) }}"><i class="fas fa-edit"></i></a>
                                                <a class="btn btn-danger" href="{{ route('delete_symbol',$row->id) }}"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            {{-- <div class="card-footer text-right">
                <div class="float-left">
                    <p>{{$tableinfo}}</p>
                  </div>

              <nav class="d-inline-block">
                <ul class="pagination mb-0">
                    {{ $data->links() }}
                </ul>
              </nav>
            </div> --}}

        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modalBulktaxsetup">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Bulk Tax Setup</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- bulk data form excel --}}
            <form action="{{ route('bulk_taxsetup') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <input type="file" name="namaTax" class="form-control">
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

<div class="modal fade" tabindex="-1" role="dialog" id="modalBulkallowance">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Bulk Allowance</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- bulk data form excel --}}
            <form action="{{ route('bulk_allowance') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <input type="file" name="namaAllowance" class="form-control">
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

<div class="modal fade" tabindex="-1" role="dialog" id="modalBulkdeduction">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Bulk Deduction</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- bulk data form excel --}}
            <form action="{{ route('bulk_deduction') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <input type="file" name="namaDeduction" class="form-control">
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
