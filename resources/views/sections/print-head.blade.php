@if(config('settings.print_head_flag'))
    <h4 class="text-center">{{ config('settings.company_name') }}</h4>
    <h6 class="text-center">{{ config('settings.company_title'). " (". config('settings.company_title_sub'). ")" }}</h6>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8 col-xs-8 col-lg-8 col-sm-8">
                <small>{{ config('settings.company_address') }}</small><br>
                <small>{{ config('settings.company_phones') }}</small>
            </div>
            <div class="col-md-4 col-xs-4 col-lg-4 col-sm-4">
                <small class="pull-right">{{ config('settings.owner_name') }}</small><br>
                <small class="pull-right">{{ config('settings.owner_phone') }}</small>
            </div>
        </div>
    </div>
    <hr style="margin-top: 5px; margin-bottom: 0px;">
@endif