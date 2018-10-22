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
                                                {{ $purchase->id }}
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
                                                <b>Serial Number</b>
                                            </td>
                                            <td style="width: 30%;">
                                                sdfsd
                                            </td>
                                            <td style="width: 20%;">
                                                fsdfsdfsdf
                                            </td>
                                            <td style="width: 30%;">
                                                fsdfdsf
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 30%;">Description of Product/Service</th>
                                            <th style="width: 10%;">HSN</th>
                                            <th style="width: 10%;">UOM</th>
                                            <th style="width: 15%;">Quantity</th>
                                            <th style="width: 15%;">Rate</th>
                                            <th style="width: 15%;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchase->products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->hsn_code }}</td>
                                                <td>{{ $product->uom_code }}</td>
                                                <td>{{ $product->purchaseDetail->quantity }}</td>
                                                <td>{{ $product->purchaseDetail->rate }}</td>
                                                <td>{{ ($product->purchaseDetail->quantity * $product->purchaseDetail->rate) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
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
                                            <th>Discount</th>
                                            <th></th>
                                            <td>{{ $purchase->discount or 0}}</td>
                                        </tr>
                                        <tr>
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
                        <tr>
                            <td>
                                <table class="table table-bordered" style="margin-bottom: 0px;">
                                    <tr>
                                        <td style="width: 50%;">
                                            <p class="text-muted well well-sm no-shadow">
                                                <b><u>Terms And Conditions</u></b>
                                                <br>&emsp;1. Seller is not responsible for any loss or damage of goods in transport
                                                <br>&emsp;1. Dispute if any will be subject to seller court jurisdiction
                                            </p>
                                        </td>
                                        <td style="width: 50%;"><br>
                                            <p class="text-muted well well-sm no-shadow">
                                                <i>Certify that the particulars given above are true and correct.</i>
                                                <br><br><br>
                                                <p class="text-center">(Authorized Signatory)</p>
                                            </p>
                                        </td>
                                    </tr>
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