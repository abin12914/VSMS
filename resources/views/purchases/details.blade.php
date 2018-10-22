@extends('layouts.app')
@section('title', 'Purchase Details')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Purchase
            <small>Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('purchase.index') }}"> Purchase</a></li>
            <li class="active"> Details</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row no-print">
            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2">
                        @if(!empty($purchase))
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                                <div class="widget-user-image">
                                    <img class="img-circle" src="/images/public/service.png" alt="User Avatar">
                                </div>
                                <!-- /.widget-user-image -->
                                <h3 class="widget-user-username">Purchase</h3>
                                <h5 class="widget-user-desc">xxx</h5>
                            </div>
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-paperclip margin-r-5"></i> Reference Number
                                            </strong>
                                            <p class="text-muted multi-line">
                                                #{{ $purchase->id }}/{{ $purchase->transaction->id }}
                                                @if(!empty($purchase->tax_invoice_number))
                                                    /{{ config('constants.branchInvoiceCode')[$purchase->branch_id]. $purchase->tax_invoice_number }}
                                                @endif
                                            </p>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-industry margin-r-5"></i> XXX
                                            </strong>
                                            <p class="text-muted multi-line">
                                                xxx
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-user-o margin-r-5"></i> Purchase Account
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $purchase->transaction->debitAccount->account_name }}
                                            </p>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-calendar margin-r-5"></i> Date
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $purchase->date->format('d-m-Y') }}
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-edit margin-r-5"></i> Billing Name
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $purchase->customer_name }}
                                            </p>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-map-marker margin-r-5"></i> Consignment Location
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $purchase->transportation->consignee_address or 'No Consignment' }}
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-inr margin-r-5"></i> Consignment Charge
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $purchase->transportation->consignment_charge or 'No Consignment charge' }}
                                            </p>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>
                                                <i class="fa fa-inr margin-r-5"></i>  Total Bill
                                            </strong>
                                            <p class="text-muted multi-line">
                                                {{ $purchase->total_amount or 'error' }}
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="box-header with-border">
                                        <h3 class="box-title"></h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10">
                                            <table class="table table-responsive table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;">#</th>
                                                        <th style="width: 35%;">Product</th>
                                                        <th style="width: 20%;">Quantity</th>
                                                        <th style="width: 20%;">Rate</th>
                                                        <th style="width: 20%;">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($purchase->products as $index => $product)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $product->name }}</td>
                                                            <td>{{ $product->purchaseDetail->quantity }}</td>
                                                            <td>{{ $product->purchaseDetail->rate }}</td>
                                                            <td>{{ $product->purchaseDetail->quantity * $product->purchaseDetail->rate }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td><strong>Total</strong></td>
                                                        <td></td>
                                                        <td><strong>{{ $purchase->total_amount + $purchase->discount }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td><strong>Discount</strong></td>
                                                        <td></td>
                                                        <td><strong>{{ $purchase->discount or 0 }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td><strong>Total Bill Amount</strong></td>
                                                        <td></td>
                                                        <td><strong>{{ $purchase->total_amount }}</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><br>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <div class="clearfix"> </div>
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                @if(!empty($purchase->tax_invoice_number) && $purchase->tax_invoice_number > 0)
                                                    <a href="{{ route('purchase.invoice', ['id' => $purchase->id]) }}" target="_blank">
                                                        <button type="button" class="btn btn-default btn-block btn-flat"><i class="fa fa-print"></i> Invoice</button>
                                                    </a>
                                                @else
                                                    <a href="{{ route('purchase.invoice', ['id' => $purchase->id]) }}" target="_blank">
                                                        <button type="button" class="btn btn-default btn-block btn-flat"><i class="fa fa-print"></i> Estimate</button>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <form action="{{ route('purchase.edit', $purchase->id) }}" method="get" class="form-horizontal">
                                                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-4">
                                                <form action="{{ route('purchase.destroy', $purchase->id) }}" method="post" class="form-horizontal">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="button" class="btn btn-danger btn-block btn-flat delete_button">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                        @endif
                    </div>
                    <!-- /.widget-user -->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection