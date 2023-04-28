@extends('layouts.simple')

@section('css_after')
    <style>
        #login-container {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            padding: 0 40px;
        }
        #login-container.shown {
            max-height: 158px;
            opacity: 1;
            transition: max-height 1s ease, opacity 1s ease;
        }
        #login-container>form {
            flex-direction: row;
            justify-content: center;
        }
    </style>
@endsection

@section('content')
    <!-- Hero -->
    <div class="position-relative hero hero-bubbles bg-body-extra-light overflow-hidden">
        <div class="position-relative hero-inner">
            <div class="content content-full text-center">
                <h1 class="fw-bold display-6 mb-3">
                    Тур Вояж
                </h1>
                <h2 class="h4 fw-medium text-muted mb-3">
                    Админ.панель
                </h2>
                <div id="login-container">
                    <form id="login-form" class="row" action="{{ route('login') }}" method="POST">
                        <div class="col-12 col-sm-auto mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="username" name="email" required>
                        </div>
                        <div class="col-12 col-sm-auto mb-3">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        @csrf
                    </form>
                </div>
                <div>
                    <button
                        class="btn btn-primary px-3 py-2 mt-2 mt-sm-0"
                        form="login-form"
                        id="login-button"
                        data-toggle="click-ripple"
                        href="#"
                        onclick="openLogin(event)"
                    >
                        <i class="fa fa-fw fa-arrow-right opacity-50 me-1"></i>
                        Войти
                    </button>
                </div>
                <script>
                    function openLogin(e) {
                        e.preventDefault()
                        document.querySelector('#login-container').classList.add('shown')
                        document.querySelector('#login-button').removeAttribute('onclick')
                    }
                </script>
            </div>
        </div>
    </div>
    <!-- END Hero -->
@endsection

@section('js_after')
    {{--@if ($errors->first())
        <script src="/js/lib/jquery.min.js"></script>
        <script src="/js/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
        <script>
            Codebase.helpers('jq-notify', {
                align: 'center',
                from: 'bottom',
                type: 'danger',
                icon: 'fa fa-times me-5',
                message: '{{ $errors->first() }}',
            });
        </script>
    @endif--}}
@endsection
