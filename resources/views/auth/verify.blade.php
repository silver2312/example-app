@extends('layouts.app', ['class' => 'bg-default'])

@section('content')

    <div class="container mt-8">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>{{ __('Xác nhận Email của bạn') }}</small>
                        </div>
                        <div>
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.') }}
                                </div>
                            @endif

                            {{ __('Trước khi tiếp tục, vui lòng kiểm tra email của bạn để biết liên kết xác minh.') }}

                            @if (Route::has('verification.resend'))
                                {{ __('Nếu bạn không nhận được email') }},
                                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Nhấp để gửi lại') }}</button>.
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
