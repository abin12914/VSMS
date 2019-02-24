@if(config('settings.print_head_flag'))
    <div class="row visible-print-block">
        <h4 class="text-center">{{ config('settings.company_name') }}</h4>
        <h6 class="text-center">{{ config('settings.company_address') }}</h6>
        <h6 class="text-center">{{ config('settings.owner_name'). " : ". config('settings.owner_phone'). ",". config('settings.company_phones') }}</h6>
        <hr style="margin-top: 5px; margin-bottom: 0px;">
    </div>
@endif