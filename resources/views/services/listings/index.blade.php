@extends('layouts.backend')

@section('css_after')
    <link rel="stylesheet" href="/js/plugins/select2/css/select2.min.css">
    <!--<editor-fold desc="Styles">-->
    <style>
        .block-container {
            text-align:justify;
        }
        .right-container {
            float:right;
        }
        .content-block {
            float: right;
        }

        .select2-selection.select2-selection--single {
            height: 41px;
            border-radius: 12px;
            border-width: 1px;
            border-color: #b7b7b7 !important;
            background-color: #fff;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            margin-left: 4px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
            right: 4px;
        }
        .select2-container .select2-dropdown {
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            overflow: hidden;
        }
        .rounded-12 {
            border-radius: 12px;
        }
    </style>
    <!--</editor-fold>-->
@endsection

@section('content')
    <div class="content row items-push">
        <!--<editor-fold desc="Page Header">-->
        <h2 class="fw-bold mb-2 content-heading col-md-8">
            Услуги
            <a class="ms-2 btn btn-primary btn-sm" href="{{ route('services.create') }}">Добавить новую</a>
        </h2>
        <div class="col-md-4">
            <select class="js-select2 form-control" id="category-select" style="width: 100%;"
                    data-placeholder="Выберите категорию..." autocomplete="off" onchange="selectCategory()">
                <option></option>
                @if(count($categories) > 0)
                    <option value="0">Все</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <!--</editor-fold>-->
        <div class="col-12 row items-push" id="services">
            @include('services.listings.tiles')
        </div>
    </div>
@endsection

@section('js_after')
    <script src="/js/plugins/select2/js/select2.full.min.js"></script>
    <script>
        jQuery('.js-select2:not(.js-select2-enabled)').each((index, element) => {
            let el = jQuery(element);

            // Add .js-select2-enabled class to tag it as activated and init it
            el.addClass('js-select2-enabled').select2({
                placeholder: el.data('placeholder') || false,
                dropdownParent: el.data('container') || document.getElementById('page-container'),
                language: {
                    noResults: function() {
                        return "Резульатов не найдено.";
                    }
                },
            });
        });
    </script>
    <script>
        function selectCategory() {
            let categorySelect = $('#category-select')
            let selectedValue = categorySelect.val()

            $.ajax({
                url:"{{ route('services.get') }}?category="+selectedValue,
                success:function(services)
                {
                    $('#services').html('')
                    $('#services').html(services)
                }
            })
        }
    </script>
@endsection
