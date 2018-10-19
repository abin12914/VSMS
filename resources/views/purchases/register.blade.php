@extends('layouts.app')
@section('title', 'Purchase Registration')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Register
            <small>Purchase</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('purchase.index') }}"> Purchase</a></li>
            <li class="active"> Registration</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row no-print">
            <div class="col-md-12">
                {{-- <div class="col-md-2"></div> --}}
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="float: left;">Purchase Details</h3>
                                <p>&nbsp&nbsp&nbsp(Fields marked with <b style="color: red;">* </b>are mandatory.)</p>
                        </div><br>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="{{route('purchase.store')}}" method="post" class="form-horizontal" autocomplete="off">
                            <div class="box-body">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="purchase_date" class="control-label"><b style="color: red;">* </b> Purchase Date : </label>
                                                            <input type="text" class="form-control decimal_number_only datepicker_reg" name="purchase_date" id="purchase_date" placeholder="Purchase date" value="{{ old('purchase_date') }}" tabindex="2">
                                                            {{-- adding error_message p tag component --}}
                                                            @component('components.paragraph.error_message', ['fieldName' => 'purchase_date'])
                                                            @endcomponent
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="supplier_account_id" class="control-label"><b style="color: red;">* </b> Purchase From : </label>
                                                            {{-- adding account select component --}}
                                                            @component('components.selects.accounts', ['selectedAccountId' => old('supplier_account_id'), 'cashAccountFlag' => true, 'selectName' => 'supplier_account_id', 'activeFlag' => false, 'nonAccountFlag' => true, 'tabindex' => 5])
                                                            @endcomponent
                                                            {{-- adding error_message p tag component --}}
                                                            @component('components.paragraph.error_message', ['fieldName' => 'supplier_account_id'])
                                                            @endcomponent
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="supplier_name" class="control-label"><b style="color: red;">* </b> Supplier Name : </label>
                                                            <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Supplier name" value="{{ old('supplier_name') }}" tabindex="3">
                                                            {{-- adding error_message p tag component --}}
                                                            @component('components.paragraph.error_message', ['fieldName' => 'supplier_name'])
                                                            @endcomponent
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="supplier_phone" class="control-label"><b style="color: red;">* </b> Supplier Phone : </label>
                                                            <input type="text" class="form-control" name="supplier_phone" id="supplier_phone" placeholder="Supplier phone" value="{{ old('supplier_phone') }}" tabindex="3">
                                                            {{-- adding error_message p tag component --}}
                                                            @component('components.paragraph.error_message', ['fieldName' => 'supplier_phone'])
                                                            @endcomponent
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="description" class="control-label"><b style="color: red;">* </b> Notes : </label>
                                                    @if(!empty( old('description')))
                                                        <textarea class="form-control" name="description" id="description" tabindex="4" rows="4" style="resize: none;" placeholder="description"></textarea>
                                                    @else
                                                        <textarea class="form-control" name="description" id="description" tabindex="4" rows="4" style="resize: none;" placeholder="description">{{ old('description') }}</textarea>
                                                    @endif
                                                    {{-- adding error_message p tag component --}}
                                                    @component('components.paragraph.error_message', ['fieldName' => 'description'])
                                                    @endcomponent
                                                </div>
                                            </div><br>
                                        </div>
                                        <br><br>
                                        <div class="form-group">
                                            <div class="row">
                                                <table class="table table-bordered table-hover dataTable">
                                                    <thead>
                                                        <th style="width: 5%;">#</th>
                                                        <th style="width: 30%;">Product</th>
                                                        <th style="width: 12%;">Gross Weight</th>
                                                        <th style="width: 5%;">Nos</th>
                                                        <th style="width: 5%;">Unit Wastage</th>
                                                        <th style="width: 5%;">Total Wastage</th>
                                                        <th style="width: 13%;">Net Weight</th>
                                                        <th style="width: 10%;">Rate</th>
                                                        <th style="width: 15%;">Amount</th>
                                                    </thead>
                                                    <tbody>
                                                        @for($i = 0; $i < 50; $i++)
                                                            <tr id="product__row_{{ $i }}" style="display : {{ (($i > 2) && empty(old('product_id.'. $i ))) ? 'none' : '' }}">
                                                                <td>
                                                                    @if(!empty($errors->first('product_id.'. $i)) || !empty($errors->first('purchase_quantity.'. $i)) || !empty($errors->first('purchase_rate.'. $i)) || !empty($errors->first('sub_bill.'. $i)))
                                                                        {{ $i + 1 }} &nbsp;
                                                                        <i class="fa fa-hand-o-right" style="color: red;" title="Invalid data in this row."></i>
                                                                    @else
                                                                        {{ $i + 1 }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @component('components.selects.products_custom', ['selectedProductId' => old('product_id.'. $i), 'selectName' => 'product_id[]', 'selectId' => 'product_id_'.$i, 'customClassName' => 'products_combo', 'indexNo' => $i, 'tabindex' => (8 + $i), 'disabledOption' => (empty(old('product_id.'. ($i-1))) && $i > 0 ? true : false )])
                                                                    @endcomponent
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control gross_weight decimal_number_only" name="gross_weight[]" id="gross_weight_{{ $i }}" placeholder="Gross Weight" value="{{ old('gross_weight.'. $i) }}" maxlength="7" {{ empty(old('product_id.'. $i )) ? 'disabled' : '' }} tabindex="{{ 8 + $i }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control product_number decimal_number_only" name="product_number[]" id="product_number_{{ $i }}" placeholder="Nos" value="{{ old('product_number.'. $i) }}" maxlength="100" {{ empty(old('product_id.'. $i )) ? 'disabled' : '' }} tabindex="{{ 8 + $i }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control unit_wastage decimal_number_only" name="unit_wastage[]" id="unit_wastage_{{ $i }}" placeholder="Unit wastage" value="{{ old('unit_wastage.'. $i) }}" maxlength="100" {{ empty(old('product_id.'. $i )) ? 'disabled' : '' }} tabindex="{{ 8 + $i }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control total_wastage decimal_number_only" name="total_wastage[]" id="total_wastage_{{ $i }}" placeholder="Total wastage" value="{{ old('total_wastage.'. $i) }}" maxlength="100" {{ empty(old('product_id.'. $i )) ? 'disabled' : '' }} tabindex="{{ 8 + $i }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control decimal_number_only purchase_quantity" name="purchase_quantity[]" id="purchase_quantity_{{ $i }}" placeholder="Net weight" value="{{ old('purchase_quantity.'. $i) }}" maxlength="4" {{ empty(old('product_id.'. $i )) ? 'disabled' : '' }} tabindex="{{ 8 + $i }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control decimal_number_only purchase_rate" name="purchase_rate[]" id="purchase_rate_{{ $i }}" placeholder="Purchase rate" value="{{ old('purchase_rate.'. $i) }}" maxlength="6" {{ empty(old('product_id.'. $i )) ? 'disabled' : '' }} tabindex="{{ 8 + $i }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control decimal_number_only" name="sub_bill[]" id="sub_bill_{{ $i }}" placeholder="Bill value" value="{{ old('sub_bill.'.$i) }}" readonly>
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>Total</td>
                                                            <td>
                                                                @if(!empty($errors->first('total_amount')))
                                                                    <i class="fa fa-hand-o-right" style="color: red;" title="Something went wrong. Please try again."></i>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control decimal_number_only" name="total_amount" id="total_amount" placeholder="Total Amount" value="{{ old('total_amount') }}" readonly>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>Discount</td>
                                                            <td>
                                                                @if(!empty($errors->first('discount')))
                                                                    &nbsp;<i class="fa fa-hand-o-right" style="color: red;" title="{{ $errors->first('discount') }}"></i>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control decimal_number_only" name="discount" id="discount" placeholder="Discount" value="{{ !empty(old('discount')) ? old('discount') : 0 }}" maxlength="6" tabindex="13">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>Total Bill Amount</td>
                                                            <td>
                                                                @if(!empty($errors->first('total_bill')))
                                                                    <i class="fa fa-hand-o-right" style="color: red;" title="Something went wrong. Please try again."></i>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control decimal_number_only" name="total_bill" id="total_bill" placeholder="Total Bill Amount" value="{{ old('total_bill') }}" readonly>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="clearfix"> </div><br>
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2">
                                        <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="15">Clear</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="purchase_submit_button" class="btn btn-primary btn-block btn-flat" tabindex="14">Submit</button>
                                    </div>
                                    <!-- /.col -->
                                </div><br>
                                <div class="row text-center">
                                    {{-- adding error_message p tag component --}}
                                    @component('components.paragraph.error_message', ['fieldName' => 'calculations'])
                                    @endcomponent
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box primary -->
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('scripts')
    <script src="/js/registrations/purchaseRegistration.js?rndstr={{ rand(1000,9999) }}"></script>
@endsection