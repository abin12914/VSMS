@extends('layouts.app')
@section('title', 'Purchase Receipt')
@section('stylesheets')
<style>
    @page{
        margin-left: 0px;
        margin-right: 0px;
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>
@endsection
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Purchases<small>Receipt</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('purchase.index') }}"> Purchase</a></li>
            <li class="active"> Receipt</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="invoice">
        <div class="row no-print">
            <div class="col-md-12">
                <h6 class="text-center">Receipt of purchase</h6>
                <table class="table table-bordered" style="margin-bottom: 0px;">
                    <tbody>
                        <tr>
                            <td>
                                <table class="table table-bordered" style="margin-bottom: 0px;">
                                    <tbody>
                                        <tr>
                                            <td style="width: 20%;">
                                                <b>Date & Ref. Number</b>
                                            </td>
                                            <td style="width: 30%;">
                                                {{ $purchase->date->format('d-m-Y') }}&emsp;#{{ $purchase->id }}/{{ $purchase->transaction_id }}
                                            </td>
                                            <td style="width: 20%;">
                                                <b>Supplier</b>
                                            </td>
                                            <td style="width: 30%;">
                                                {{ $purchase->transaction->creditAccount->account_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">
                                                <b>Supplier Detail</b>
                                            </td>
                                            <td style="width: 30%;">
                                                {{ $purchase->supplier_name }}, {{ $purchase->supplier_phone }}
                                            </td>
                                            <td style="width: 20%;">
                                                <b>Notes</b>
                                            </td>
                                            <td style="width: 30%;">
                                                {{ $purchase->description }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>Purchase Details</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 25%;">Product</th>
                                            <th style="width: 8%;">Gross Quantity</th>
                                            <th style="width: 8%;">Product Number</th>
                                            <th style="width: 8%;">Unit Wastage</th>
                                            <th style="width: 8%;">Total Wastage</th>
                                            <th style="width: 13%;">Net Quantity</th>
                                            <th style="width: 10%;">Rate</th>
                                            <th style="width: 15%;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchase->products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>
                                                    {{ $product->purchaseDetail->gross_quantity ?: $product->purchaseDetail->net_quantity }}
                                                    {{ $product->uom_code }}
                                                </td>
                                                <td>{{ $product->purchaseDetail->product_number ?: '-' }}</td>
                                                <td>{{ $product->purchaseDetail->unit_wastage ?: '-' }}</td>
                                                <td>{{ $product->purchaseDetail->total_wastage ?: 0 }}</td>
                                                <td>{{ $product->purchaseDetail->net_quantity }} {{ $product->uom_code }}</td>
                                                <td>{{ $product->purchaseDetail->rate }}/-</td>
                                                <td>{{ ($product->purchaseDetail->net_quantity * $product->purchaseDetail->rate) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>Total Price</strong></td>
                                            <td></td>
                                            <td>{{ ($purchase->total_amount + $purchase->discount) }}</td>
                                        </tr>
                                        @if(!empty($purchase->discount) && $purchase->discount > 0)
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong>Discount</strong></td>
                                                <td></td>
                                                <td>{{ $purchase->discount or 0}}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong>Total Bill</strong></td>
                                                <td></td>
                                                <td>{{ $purchase->total_amount }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <h4>Payment Details</h4>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td style="width: 5%;">#</td>
                                            <td style="width: 65%;">Total Bill</td>
                                            <td style="width: 15%;">{{ $purchase->total_amount }}</td>
                                            <td style="width: 15%;">-</td>
                                        </tr>
                                        <tr>
                                            <td>#</td>
                                            @if($oldBalance == 0)
                                                <td>Old Balance</td>
                                                <td>-</td>
                                                <td>-</td>
                                            @elseif($oldBalance < 0)
                                                <td>
                                                    Old Balance 
                                                    <b> (Payable To {{ $purchase->transaction->creditAccount->account_name }})</b>
                                                </td>
                                                <td>{{ abs($oldBalance) }}</td>
                                                <td>-</td>
                                            @else
                                                <td>
                                                    Old Balance 
                                                    <b> (Recievable From {{ $purchase->transaction->creditAccount->account_name }})</b>
                                                </td>
                                                <td></td>
                                                <td>{{ abs($oldBalance) }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>#</td>
                                            <td>Cash Paid To Supplier</td>
                                            <td>-</td>
                                            <td>{{ (!empty($purchase->payment) && $purchase->payment->amount > 0) ? $purchase->payment->amount : '-'  }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if($oldBalance - $purchase->total_amount + (!empty($purchase->payment) ? $purchase->payment->amount : 0) == 0)
                                    <h4>Outstanding Balance = 0/-
                                    </h4>
                                @elseif($oldBalance - $purchase->total_amount + (!empty($purchase->payment) ? $purchase->payment->amount : 0) > 0)
                                    <h4>Outstanding Balance (Recievable From {{ $purchase->transaction->creditAccount->account_name }}) = {{ abs($oldBalance - $purchase->total_amount) + (!empty($purchase->payment) ? $purchase->payment->amount : 0) }}/-
                                    </h4>
                                @else
                                    <h4>Outstanding Balance (Payable To {{ $purchase->transaction->creditAccount->account_name }}) = {{ abs($oldBalance - $purchase->total_amount) + (!empty($purchase->payment) ? $purchase->payment->amount : 0) }}/-
                                    </h4>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row visible-print-block">
            <div class="col-md-12">
                @include('sections.print-head')
                <i class="invoice-table-content">
                    Supplier : {{ $purchase->transaction->creditAccount->account_name }}
                    <i class="pull-right invoice-table-content-pull-right">
                        Ref No : #{{ ($purchase->id < 100 ? '0' : ''). $purchase->id }}
                    </i><br>
                    <i class="invoice-table-content">{{ $purchase->supplier_name }}, {{ $purchase->supplier_phone }}</i>
                    <i class="pull-right invoice-table-content-pull-right">
                        Date: {{ $purchase->date->format('d-m-Y') }}
                    </i>
                </i>
                <hr style="margin-top: 5px; margin-bottom: 5px;">
                <h6 class="invoice-table-content">Purchase Details</h6>
                <table class="table-sm table-bordered invoice-table-content invoice-table-content-product">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 25%;">Product</th>
                            <th style="width: 10%;">Gross Qty</th>
                            <th style="width: 6%;">Nos</th>
                            <th style="width: 8%;">Unit Wastage</th>
                            <th style="width: 8%;">Total Wastage</th>
                            <th style="width: 13%;">Net Qty</th>
                            <th style="width: 10%;">Rate</th>
                            <th style="width: 15%;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchase->products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    {{ $product->purchaseDetail->gross_quantity ?: $product->purchaseDetail->net_quantity }}
                                    {{ $product->uom_code }}
                                </td>
                                <td>{{ $product->purchaseDetail->product_number ?: '-' }}</td>
                                <td>{{ $product->purchaseDetail->unit_wastage ?: '-' }}</td>
                                <td>{{ $product->purchaseDetail->total_wastage ?: 0 }}</td>
                                <td>{{ $product->purchaseDetail->net_quantity }} {{ $product->uom_code }}</td>
                                <td>{{ $product->purchaseDetail->rate }}/-</td>
                                <td>{{ ($product->purchaseDetail->net_quantity * $product->purchaseDetail->rate) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <small class="invoice-table-content">Total Bill : {{ $purchase->total_amount }}</small><br>
                @if($oldBalance < 0))
                    <small class="invoice-table-content">Old Balance : - {{ abs($oldBalance) }} (Payable to Supplier)</small>
                    <small class="pull-right invoice-table-content-pull-right">
                        Total : {{ $oldBalance + $purchase->total_amount }}
                    </small><br>
                @elseif($oldBalance > 0)
                    <small class="invoice-table-content">Old Balance : + {{ abs($oldBalance) }} (Recievable from Supplier)</small>
                    <small class="pull-right invoice-table-content-pull-right">
                        Total : {{ $oldBalance - $purchase->total_amount }}
                    </small><br>
                @else
                    <small class="invoice-table-content">Old Balance : 0</small>
                    <small class="pull-right invoice-table-content-pull-right">
                        Total : {{ $purchase->total_amount }}
                    </small><br>
                @endif
                <small class="invoice-table-content">Cash Paid To [{{ $purchase->transaction->creditAccount->account_name }}] : </small> --}}
                <table class="table-sm table-bordered invoice-table-content invoice-table-content-payment">
                    <tbody>
                        <tr>
                            <td style="width: 86%;">
                                <strong>Total Bill</strong>
                                @if(!empty($purchase->discount) && $purchase->discount > 0)
                                    [Bill : {{ ($purchase->total_amount + $purchase->discount) }} - Discount : {{ $purchase->discount }}]
                                @endif
                            </td>
                            <td style="width: 14%;">{{ $purchase->total_amount }}</td>
                        </tr>
                        <tr>
                            @if($oldBalance == 0)
                                <td>Old Balance</td>
                                <td>-</td>
                            @elseif($oldBalance < 0)
                                <td>
                                    Old Balance 
                                    <b> (Payable To {{ $purchase->transaction->creditAccount->account_name }})</b>
                                </td>
                                <td> + {{ abs($oldBalance) }}</td>
                            @else
                                <td>
                                    Old Balance 
                                    <b> (Recievable From {{ $purchase->transaction->creditAccount->account_name }})</b>
                                </td>
                                <td> - {{ abs($oldBalance) }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td>Cash Paid To Supplier</td>
                            <td> - {{ (!empty($purchase->payment) && $purchase->payment->amount > 0) ? $purchase->payment->amount : 0  }}</td>
                        </tr>
                        <tr>
                            @if($oldBalance - $purchase->total_amount + (!empty($purchase->payment) ? $purchase->payment->amount : 0) == 0)
                                <td>
                                    Outstanding Balance
                                </td>
                                <td>
                                    0
                                </td>
                            @elseif($oldBalance - $purchase->total_amount + (!empty($purchase->payment) ? $purchase->payment->amount : 0) > 0)
                                <td>
                                    <strong>Outstanding Balance (Recievable From {{ $purchase->transaction->creditAccount->account_name }})</strong>
                                </td>
                                <td>
                                    {{ abs($oldBalance - $purchase->total_amount) + (!empty($purchase->payment) ? $purchase->payment->amount : 0) }}/-
                                </td>
                            @else
                                <td>
                                    <strong>Outstanding Balance (Payable To {{ $purchase->transaction->creditAccount->account_name }})</strong>
                                </td>
                                <td>
                                    {{ abs($oldBalance - $purchase->total_amount) + (!empty($purchase->payment) ? $purchase->payment->amount : 0) }}/-
                                </td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row no-print">
            <div class="col-md-12">
                <a>
                    <button type="button" class="btn btn-lg btn-default" onclick="event.preventDefault(); print();">
                        <i class="fa fa-print"></i> Print Receipt
                    </button>
                </a>
                <a href="{{ route('purchase.create') }}">
                    <button type="button" class="btn btn-lg btn-default">
                        <i class="fa fa-line-chart"></i> New Purchase
                    </button>
                </a>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function () {
            /*window.print();*/
        });
    </script>
@endsection