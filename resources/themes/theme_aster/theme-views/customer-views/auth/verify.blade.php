@extends('theme-views.layouts.app')

@section('title', $web_config['name']->value.' '.translate('Customer_Verify').' | '.$web_config['name']->value.''.translate(' Ecommerce'))

@section('content')
<!-- Main Content -->
<main class="main-content d-flex flex-column gap-3 py-3 mb-30">
    <div class="container {{($user_verify == 1?'d-none':'')}}" id="otp_form_section">
        @php($email_verify_status = \App\CPU\Helpers::get_business_settings('email_verification'))
        @php($phone_verify_status = \App\CPU\Helpers::get_business_settings('phone_verification'))

        @if($phone_verify_status == 1)
        <div class="card mb-5">
            <div class="card-body py-5 px-lg-5">
                <div class="row align-items-center pb-5">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <h2 class="text-center mb-2">{{ translate('OTP_Verification') }}</h2>
                        <p class="text-center mb-5 text-muted">{{ translate('Please_Verify_that_it’s_you') }}.</p>
                        <div class="d-flex justify-content-center">
                            <img width="283" class="dark-support" src="{{theme_asset('assets/img/media/otp.png')}}"
                                alt="">
                        </div>
                    </div>

                    <div class="col-lg-6 text-center">
                        <div class="d-flex justify-content-center mb-3">
                            <img width="50" class="dark-support" src="{{theme_asset('assets/img/media/otp-lock.png')}}"
                                alt="">
                        </div>
                        <p class="text-muted mx-w mx-auto" style="--width: 27.5rem">{{ translate('An_OTP_(One_Time_Password)_has_been_sent_to') }} {{$user->phone}}.
                            {{ translate('Please_enter_the_OTP_in_the_field_below_to_verify_your_phone') }}.</p>

                        <div class="resend_otp_custom">
                            <p class="text-primary mb-2 ">{{ translate('Resend_code_within') }}</p>
                            <h6 class="text-primary mb-5 verifyTimer">
                                <span class="verifyCounter" data-second="{{$get_time}}"></span>s
                            </h6>
                        </div>

                        <form action="{{ route('customer.auth.ajax_verify') }}" class="otp-form" method="POST"
                            id="customer_verify">
                            @csrf
                            <div class="d-flex gap-2 gap-sm-3 align-items-end justify-content-center">
                                <input class="otp-field" type="text" name="opt-field[]" maxlength="1"
                                    autocomplete="off">
                                <input class="otp-field" type="text" name="opt-field[]" maxlength="1"
                                    autocomplete="off">
                                <input class="otp-field" type="text" name="opt-field[]" maxlength="1"
                                    autocomplete="off">
                                <input class="otp-field" type="text" name="opt-field[]" maxlength="1"
                                    autocomplete="off">
                            </div>

                            <!-- Store OTP Value -->
                            <input class="otp-value" type="hidden" name="token">
                            <input type="hidden" value="{{$user->id}}" name="id">
                            <div class="d-flex justify-content-center gap-3 mt-5">
                                <button class="btn btn-outline-primary resend-otp-button" type="button" id="resend_otp">{{ translate('Resend_OTP') }}</button>
                                <button class="btn btn-primary px-sm-5" type="submit" disabled>{{ translate('verify') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @elseif($email_verify_status == 1)
        <div class="card">
            <div class="card-body py-5 px-lg-5">
                <div class="row justify-content-center pb-5">
                    <div class="col-lg-6 text-center">
                        <div class="d-flex justify-content-center mb-3">
                            <img width="220" class="dark-support" src="{{theme_asset('assets/img/media/otp-2.png')}}"
                                alt="">
                        </div>
                        <h2 class="text-center mb-3">{{ translate('OTP_Verification') }}</h2>
                        <p class="text-muted mx-w mx-auto" style="--width: 27.5rem">
                            {{ translate('An_OTP_(One_Time_Password)_has_been_sent_to_your_email') }}.
                            {{ translate('Please_enter_the_OTP_in_the_field_below_to_verify_your_email') }}.</p>

                        <div class="resend_otp_custom">
                            <p class="text-primary mb-2 ">{{ translate('Resend_code_within') }}</p>
                            <h6 class="text-primary mb-5 verifyTimer">
                                <span class="verifyCounter" data-second="{{$get_time}}"></span>s
                            </h6>
                        </div>

                        <form action="{{ route('customer.auth.ajax_verify') }}" class="otp-form" method="POST"
                            id="customer_verify">
                            @csrf
                            <div class="d-flex gap-2 gap-sm-3 align-items-end justify-content-center">
                                <input class="otp-field style--two" type="text" name="opt-field[]" maxlength="1"
                                    autocomplete="off">
                                <input class="otp-field style--two" type="text" name="opt-field[]" maxlength="1"
                                    autocomplete="off">
                                <input class="otp-field style--two" type="text" name="opt-field[]" maxlength="1"
                                    autocomplete="off">
                                <input class="otp-field style--two" type="text" name="opt-field[]" maxlength="1"
                                    autocomplete="off">
                            </div>

                            <!-- Store OTP Value -->
                            <input class="otp-value" type="hidden" name="token">
                            <input type="hidden" value="{{$user->id}}" name="id">
                            <div class="d-flex justify-content-center gap-3 mt-5">
                                <button class="btn btn-outline-primary resend-otp-button" type="button" id="resend_otp">{{ translate('Resend_OTP') }}</button>
                                <button class="btn btn-primary px-sm-5" type="submit">{{ translate('verify') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

    <div class="container {{($user_verify != 1?'d-none':'')}}" id="success_message">
        <div class="card">
            <div class="card-body p-md-5">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-md-10">
                        <div class="text-center d-flex flex-column align-items-center gap-3">
                            <img width="46" src="{{theme_asset('assets/img/icons/check.png')}}" class="dark-support" alt="">
                            <h3>{{translate('Verification_Successfully_Completed')}}</h3>
                            <p class="text-muted">{{ translate('Thank_you_for_your_verification')}}! {{ translate('Now_you_can_login') }}, {{ translate('your_account_is_ready_to_use') }}</p>
                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                 <button class="btn btn-outline-primary bg-primary-light border-transparent"
                                         data-bs-toggle="modal" data-bs-target="#loginModal">{{ translate('login') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- End Main Content -->
@endsection

@push('script')
<script>
    $('#customer_verify').on('submit', function (event) {
        event.preventDefault();
        let login_form = $(this);
        $.ajax({
            url: login_form.attr('action'),
            method: 'POST',
            dataType: "json",
            data: login_form.serialize(),
            beforeSend: function () {
                $("#loading").addClass("d-grid");
            },
            success: function (data) {
                if (data.status === 'success') {
                    $('#otp_form_section').addClass('d-none');
                    $('#success_message').removeClass('d-none');
                    $('#loginModal').modal('show');
                    toastr.success(data.message);
                }else{
                    toastr.error(data.message);
                }

            },
            complete: function () {
                $("#loading").removeClass("d-grid");
            },
        });
    });

    // Resend OTP
    $('#resend_otp').click(function(){
        $('input.otp-field').val('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: `{{route('customer.auth.resend_otp')}}`,
            method: 'POST',
            dataType: 'json',
            data: {
                'user_id':{{$user->id}},
            },
            beforeSend: function () {
                $("#loading").addClass("d-grid");
            },
            success: function (data) {
                if (data.status == 1) {
                    // Countdown
                    let new_counter = $(".verifyCounter");
                    let new_seconds = data.new_time;
                    function new_tick() {
                        let m = Math.floor(new_seconds / 60);
                        let s = new_seconds % 60;
                        new_seconds--;
                        new_counter.html(m + ":" + (s < 10 ? "0" : "") + String(s));
                        if (new_seconds > 0) {
                            setTimeout(new_tick, 1000);
                            $('.resend-otp-button').attr('disabled', true);
                            $(".resend_otp_custom").slideDown();
                        }
                        else {
                            $('.resend-otp-button').removeAttr('disabled');
                            $(".verifyCounter").html("0:00");
                            $(".resend_otp_custom").slideUp();
                        }
                    }
                    new_tick();

                    toastr.success(`{{translate('OTP_has_been_sent_again.')}}`);
                } else {
                    toastr.error(`{{translate('please_wait_for_new_code.')}}`);
                }
            },
            complete: function () {
                $("#loading").removeClass("d-grid");
            },
        });
    });
</script>
@endpush
