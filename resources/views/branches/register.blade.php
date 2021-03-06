@extends('layouts.app')
@section('title', 'Branch Registration')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Branch
            <small>Registartion</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Branch Registration</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row no-print">
            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="float: left;">Branch Details</h3>
                                <p>&nbsp&nbsp&nbsp(Fields marked with <b style="color: red;">* </b>are mandatory.)</p>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="{{route('branch.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                            <div class="box-body">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <label for="branch_name" class="col-md-3 control-label"><b style="color: red;">* </b> Branch Name : </label>
                                            <div class="col-md-9">
                                                <input type="text" name="branch_name" class="form-control" id="branch_name" placeholder="Branch Name" value="{{ old('branch_name') }}" tabindex="1" maxlength="100">
                                                {{-- adding error_message p tag component --}}
                                                @component('components.paragraph.error_message', ['fieldName' => 'branch_name'])
                                                @endcomponent
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="place" class="col-md-3 control-label"><b style="color: red;">* </b>Place : </label>
                                            <div class="col-md-9">
                                                @if(!empty(old('place')))
                                                    <textarea class="form-control" name="place" id="place" rows="3" placeholder="Place" style="resize: none;" tabindex="2" maxlength="199">{{ old('place') }}</textarea>
                                                @else
                                                    <textarea class="form-control" name="place" id="place" rows="3" placeholder="Place" style="resize: none;" tabindex="2" maxlength="199"></textarea>
                                                @endif
                                                {{-- adding error_message p tag component --}}
                                                @component('components.paragraph.error_message', ['fieldName' => 'place'])
                                                @endcomponent
                                            </div>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="address" class="col-md-3 control-label"><b style="color: red;">* </b>Address : </label>
                                            <div class="col-md-9">
                                                @if(!empty(old('address')))
                                                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address" style="resize: none;" tabindex="3" maxlength="199">{{ old('address') }}</textarea>
                                                @else
                                                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address" style="resize: none;" tabindex="3" maxlength="199"></textarea>
                                                @endif
                                                {{-- adding error_message p tag component --}}
                                                @component('components.paragraph.error_message', ['fieldName' => 'address'])
                                                @endcomponent
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="gstin" class="col-md-3 control-label"><b style="color: red;">* </b> Branch GSTIN : </label>
                                            <div class="col-md-9">
                                                <input type="text" name="gstin" class="form-control" id="gstin" placeholder="Branch GSTIN" value="{{ old('gstin') }}" tabindex="1" maxlength="15">
                                                {{-- adding error_message p tag component --}}
                                                @component('components.paragraph.error_message', ['fieldName' => 'gstin'])
                                                @endcomponent
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="primary_phone" class="col-md-3 control-label"><b style="color: red;">* </b> Primary Phone : </label>
                                            <div class="col-md-9">
                                                <input type="text" name="primary_phone" class="form-control" id="primary_phone" placeholder="Primary Phone Number" value="{{ old('primary_phone') }}" tabindex="1" maxlength="13">
                                                {{-- adding error_message p tag component --}}
                                                @component('components.paragraph.error_message', ['fieldName' => 'primary_phone'])
                                                @endcomponent
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="secondary_phone" class="col-md-3 control-label">Secondary Phone : </label>
                                            <div class="col-md-9">
                                                <input type="text" name="secondary_phone" class="form-control" id="secondary_phone" placeholder="Secondary Phone Number" value="{{ old('secondary_phone') }}" tabindex="1" maxlength="13">
                                                {{-- adding error_message p tag component --}}
                                                @component('components.paragraph.error_message', ['fieldName' => 'secondary_phone'])
                                                @endcomponent
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="branch_level" class="col-md-3 control-label">Branch Level : </label>
                                            <div class="col-md-9">
                                                <select class="form-control select2" name="branch_level" id="branch_level" style="width: 100%" tabindex="">
                                                    <option value="0">Main Branch/Head Office</option>
                                                    <option value="1">Sub Branch</option>
                                                </select>
                                                @component('components.paragraph.error_message', ['fieldName' => 'branch_level'])
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"> </div><br>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="5">Clear</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="4">Submit</button>
                                    </div>
                                    <!-- /.col -->
                                </div><br>
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