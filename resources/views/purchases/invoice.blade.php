@extends('layouts.app')
@section('title', 'Purchase Receipt')
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
        <div class="row">
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
                                                <b>Ref. Number</b>
                                            </td>
                                            <td style="width: 30%;">
                                                {{ $purchase->id }}/{{ $purchase->transaction_id }}
                                            </td>
                                            <td style="width: 20%;">
                                                <b>Date</b>
                                            </td>
                                            <td style="width: 30%;">
                                                {{ $purchase->date->format('d-m-Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">
                                                <b>Transaction Account</b>
                                            </td>
                                            <td style="width: 30%;">
                                                {{ $purchase->transaction->creditAccount->account_name }}
                                            </td>
                                            <td style="width: 20%;">
                                                <b>Notes</b>
                                            </td>
                                            <td style="width: 30%;">
                                                {{ $purchase->description }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">
                                                <b>Supplier Name</b>
                                            </td>
                                            <td style="width: 30%;">
                                                {{ $purchase->supplier_name }}
                                            </td>
                                            <td style="width: 20%;">
                                                <b>Supplier Phone</b>
                                            </td>
                                            <td style="width: 30%;">
                                                {{ $purchase->supplier_phone }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table table-bordered -ssd">
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
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Amount</th>
                                            <th></th>
                                            <td>{{ ($purchase->total_amount + $purchase->discount) }}</td>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Discount</th>
                                            <th></th>
                                            <td>{{ $purchase->discount or 0}}</td>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Value of supply</th>
                                            <th></th>
                                            <td>{{ $purchase->total_amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
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
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection