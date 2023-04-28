<?php
/**
 * @var $categories
 * @var $currencies
 * @var $units
 * @var $countries
 * @var $cities
 * @var $saleTags
 *
 * @var $category
 * @var $unit
 * @var $saleTag
 */
?>
@extends('layouts.backend')

@section('css_after')
    <link rel="stylesheet" href="/js/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!--<editor-fold desc="Styles">-->
    <style>
        .uploadOuter {
            text-align: center;
            padding: 20px;
        }

        strong {
            display: block;
            padding: 8px;
        }

        .dragBox {
            width: 100%;
            height: 100px;
            margin: 0 auto;
            position: relative;
            text-align: center;
            font-weight: bold;
            line-height: 95px;
            color: #999;
            border: 2px dashed #ccc;
            display: inline-block;
            transition: transform 0.3s;
        }

        input[type="file"] {
            position: absolute;
            height: 100%;
            width: 100%;
            opacity: 0;
            top: 0;
            left: 0;
        }

        .draging {
            transform: scale(1.1);
        }

        #preview {
            padding: 20px 20px 0;
            /*width: 100%;*/
            text-align: center;
            min-height: 218px;
        }

        #preview img {
            max-width: 100%;
        }

        #preview > div {
            margin-bottom: 20px;
            background: transparent;
            border-color: transparent;
        }


       /* .form-block {
            padding-left: calc(var(--bs-gutter-x));
            padding-right: calc(var(--bs-gutter-x));
        }*/

        /*#preview {
            flex-direction: row;
            flex-wrap: wrap;
            display: flex;
            justify-content: space-around;
        }
        #preview > div {
            min-width: 180px;
            flex-basis: 26%;
            aspect-ratio: 4/3;
            flex: 1;
            margin-bottom: 16px;
            background-size: cover;
            background-position: center;
        }

        */

        .select2-selection.select2-selection--single {
            height: 38px;
            margin-bottom: -11px;
            border-color: #dbdbdb;
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

        .dropdown-toggle-split::after, .dropend .dropdown-toggle-split::after, .dropup .dropdown-toggle-split::after {
            margin-left: 4px;
        }
    </style>
    <!--</editor-fold>-->
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <nav class="breadcrumb push">
                    <a class="breadcrumb-item" href="{{ route('services') }}">Услуги</a>
                    <span class="breadcrumb-item active">Новая услуга</span>
                </nav>
                <!--<editor-fold desc="Service Create Form">-->
                <form action="{{ route('services.create') }}" name="serviceCreate" id="serviceCreate"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="block block-rounded">
                        <!--<editor-fold desc="Block Header">-->
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Новая услуга</h3>
                            <div class="block-options">
                                <button type="submit" class="btn btn-sm btn-primary" id="submit-all">
                                    <i class="fa fa-save opacity-50 me-1"></i> Сохранить
                                </button>
                            </div>
                        </div>
                        <!--</editor-fold>-->
                        <!--<editor-fold desc="Block Content">-->
                        <div class="block-content block-content-full">
                            <div class="row items-push">
                                <div class="col-xl-5 col-md-7">
                                    <div class="row">
                                        <!--<editor-fold desc="Name Field">-->
                                        <div class="col-md-12 mb-1 mb-xl-4 ">
                                            <label class="form-label block-title" for="name">Название</label>
                                            <input type="text" class="form-control" id="name"
                                                   name="name" placeholder="Название услуги" value="{{ old('name') }}"
                                                   autocomplete="off">
                                        </div>
                                        <!--</editor-fold>-->
                                        <!--<editor-fold desc="Category Select">-->
                                        <div class="col-md-12 mb-1 mb-xl-4">
                                            <label class="form-label block-title" for="category">Категория</label>
                                            <select id="category" name="category" class="js-select2" style="width: 100%;"
                                                    data-placeholder="Выберите категорию..." autocomplete="off">
                                                <option></option>
                                                @if(count($categories) > 0)
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" <?php if (old('category') == $category->id) echo 'selected';?>>{{ $category->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <!--</editor-fold>-->
                                    </div>
                                </div>
                                <!--<editor-fold desc="Main Properties">-->
                                <div class="col-xl-7 col-md-5 align-content-start">
                                    <div class="row">

                                        <div class="mb-1 mb-xl-4 col-sm-6 col-md-12 col-xl-6">
                                            <label class="form-label block-title" for="price_value">Цена</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="price_value"
                                                       name="price_value" value="{{ old('price_value') }}">
                                                <button id="currency-btn" type="button" class="btn btn-alt-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                    @if(count($currencies) > 0)
                                                        {{ $currencies->first()->name }}
                                                    @endif
                                                </button>
                                                <input type="hidden" name="price_currency" value="<?php if(count($currencies) > 0) echo $currencies->first()->id; ?>" autocomplete="off">
                                                <div class="dropdown-menu">
                                                    @foreach($currencies as $currency)
                                                        <div class="dropdown-item" onclick="changeCurrency({{ $currency->id }}, '{{ $currency->name }}')">
                                                            {{ $currency->name }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 mb-xl-4 col-sm-6 col-md-12 col-xl-6">
                                            <label class="form-label block-title" for="price_unit">Единица измерения цены</label>
                                            <div class="input-group">
                                                <select name="price_unit" id="price_unit" class="form-select" autocomplete="off">
                                                    <option value="0">Нет</option>
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->id }}" <?php if (old('price_unit') == $unit->id) echo 'selected';?>>{{ $unit->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-1 col-sm-6 col-md-12 col-xl-6">
                                            <label class="form-label block-title" for="country">Страна</label>
                                            <div class="input-group">
                                                <select name="country" id="country" class="form-select" autocomplete="off" onchange="fillCities()">
                                                    <option value="0">Не выбрана</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" <?php if (old('country') == $unit->id) echo 'selected';?>>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-12 col-xl-6">
                                            <label class="form-label block-title" for="city">Город</label>
                                            <div class="input-group">
                                                <select name="city" id="city" class="form-select" autocomplete="off">
                                                    <option value="0" disabled selected>Выберите страну</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--</editor-fold>-->
                            </div>
                            <div class="row push">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label" for="price_value">Статус после сохранения</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" value=""
                                                       id="active" name="active"
                                                       checked="" onchange="switchActive()">
                                                <label class="form-check-label"
                                                       for="active" id="active_label">Активна</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label block-title" for="sale_tag">Метка
                                                распродажи</label>
                                            <div class="input-group">
                                                <select name="sale_tag" id="sale_tag" class="form-select"
                                                        autocomplete="off">
                                                    <option value="0">Нет</option>
                                                    @foreach($saleTags as $saleTag)
                                                        <option value="{{ $saleTag->id }}" <?php if (old('sale_tag') == $saleTag->id) echo 'selected';?>>{{ $saleTag->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--<editor-fold desc="Short Description">-->
                            <div class="mb-1">
                                <label class="form-label" for="description">Описание</label>
                                <textarea class="form-control" id="description" name="description"
                                          placeholder="Описание услуги.."
                                          rows="3">{{ old('description') }}</textarea>
                            </div>
                            <!--</editor-fold>-->
                        </div>
                        <!--</editor-fold>-->
                    </div>
                    <div class="row">
                        <!--<editor-fold desc="Image Upload">-->
                        <div class="col-md-5">
                            <div class="block block-rounded">
                                <div class="uploadOuter">
                                    <label for="uploadFile" class="btn btn-primary">Загрузите изображения</label>
                                    <strong style="display: block">или</strong>
                                    <span class="dragBox">
                                      Перетащите изображения сюда
                                    <input type="file" onChange="dragNdrop(event)" ondragover="drag()" ondrop="drop()"
                                           id="uploadFile" name="images[]" multiple/>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="block block-rounded">
                                <div id="preview" class="row"></div>
                            </div>
                            <input type="hidden" value="" id="image_order" name="image_order" autocomplete="off">
                        </div>
                        <!--</editor-fold>-->
                    </div>
                </form>
                <!--</editor-fold>-->
            </div>
        </div>
    </div>
@endsection


@section('js_after')
    <script src="/js/views/drag-n-drop-single.js"></script>
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
        function changeCurrency(id, name) {
            $('input[name="price_currency"]').val(id)
            $('#currency-btn').html(name)
        }
    </script>
    <script>
        const citiesList = [
            <?php
                foreach ($cities as $city) {
                    echo '{
                            id: '.$city->id.',
                            name: "'.$city->name.'",
                            parent_id: '.$city->parent_id.'
                          }, ';
                }
            ?>
        ]

        function fillCities() {
            let citySelect = $('#city')
            let parent_id = $('#country').val()
            if (parent_id === 0) {
                citySelect.html('<option value="0" selected disabled>Выберите страну</option>')
                return;
            }
            let availableCities = citiesList.filter(obj => (obj.parent_id == parent_id))
            let optionsHTML = '<option value="0">Не выбран</option>'
            for (let city of availableCities) {
                optionsHTML += '<option value="' + city['id'] + '">' + city['name'] + '</option>'
            }
            citySelect.html(optionsHTML)
        }
        @if(old('country'))
            fillCities()
            @if(old('city'))
                $('#city').val({{ old('city') }})
            @endif
        @endif
        function switchActive() {
            let switchPos = $('#active').is(':checked')
            let switchLabel = $('#active_label')
            if (switchPos) {
                switchLabel.html('Активна')
            } else {
                switchLabel.html('Не активна')
            }
        }
    </script>
    <script src="/js/views/drag-n-drop-multiple.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $('#preview').sortable({
            update: function (event, ui) {
                let images = $('#preview').children()
                let orderInput = $('#image_order')
                let count = 0
                let order = [];
                for (let image of images) {
                    order.push(image.getAttribute('initial-order'))
                }
                orderInput.val(order.toString())
            }
        })
    </script>
@endsection
