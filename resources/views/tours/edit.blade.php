<?php
/**
 * @var $tour
 */
?>

@extends('layouts.backend')

@section('css_after')
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
            padding: 0 20px 20px;
            width: 100%;
            text-align: center;
        }

        #preview img {
            max-width: 100%;
        }

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
        }*/
    </style>
    <!--</editor-fold>-->
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <nav class="breadcrumb push">
                    <a class="breadcrumb-item" href="{{ route('tours') }}">Туры</a>
                    <span class="breadcrumb-item active">{{ $tour->name }}</span>
                </nav>
                <!--<editor-fold desc="Category Edit Form">-->
                <form action="{{ route('tours.update', ['id' => $id]) }}" name="tourCreate" id="tourCreate"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="block block-rounded">
                        <!--<editor-fold desc="Block Header">-->
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Редактировать тур</h3>
                            <div class="block-options">
                                <button class="btn btn-sm btn-danger me-2"
                                        data-bs-toggle="modal" data-bs-target="#modal-delete"
                                        onclick="event.preventDefault();">
                                    <i class="fa fa-trash opacity-50 me-1"></i> Удалить
                                </button>
                                <button type="submit" class="btn btn-sm btn-primary" id="submit-all">
                                    <i class="fa fa-save opacity-50 me-1"></i> Сохранить
                                </button>
                            </div>
                        </div>
                        <!--</editor-fold>-->
                        <!--<editor-fold desc="Block Content">-->
                        <div class="block-content block-content-full row">
                            <div class="col-md-5 flex-grow-1 row">
                                <!--<editor-fold desc="Active Select">-->
                                <div class="col-12">
                                    <label class="form-label" for="price_value">Статус после сохранения</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" value=""
                                               id="active" name="active"
                                               <?php if (old('active') || $tour->active) echo 'checked'; ?>  onchange="switchActive()">
                                        <label class="form-check-label"
                                               for="active" id="active_label">Активен</label>
                                    </div>
                                </div>
                                <!--</editor-fold>-->
                                <!--<editor-fold desc="Name Field">-->
                                <div class="mb-3 col-12">
                                    <label class="form-label block-title" for="name">Название</label>
                                    <input type="text" class="form-control" id="name"
                                           name="name" placeholder="Название тура" value="{{ $tour->name }}">
                                </div>
                                <!--</editor-fold>-->
                                <!--<editor-fold desc="Category Selects">-->
                                <div class="mb-3 col-md-12">
                                    <label class="form-label block-title col-12">Категория</label>
                                    <div class="form-check form-switch col-md-12 col-auto float-start">
                                        <input class="form-check-input" type="checkbox" value="sochi"
                                               id="category-sochi" name="categories[]"
                                            {{ (in_array('sochi', $tour->categories)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category-sochi">Сочи</label>
                                    </div>
                                    <div class="m-1 col-auto d-md-none float-start"></div>
                                    <div class="form-check form-switch col-md-12 col-auto float-start">
                                        <input class="form-check-input" type="checkbox" value="abhazia"
                                               id="category-abhazia" name="categories[]"
                                            {{ (in_array('abhazia', $tour->categories)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category-abhazia">Абхазия</label>
                                    </div>
                                    <div class="m-1 col-auto d-md-none float-start"></div>
                                    <div class="form-check form-switch col-md-12 col-auto float-start">
                                        <input class="form-check-input" type="checkbox" value="vip"
                                               id="category-vip" name="categories[]"
                                            {{ (in_array('vip', $tour->categories)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category-vip">VIP</label>
                                    </div>
                                </div>
                                <!--</editor-fold>-->
                            </div>
                            <!--<editor-fold desc="Main Properties">-->
                            <div class="col-md-7 row align-content-start">

                                <div class="mb-1 mb-xl-4 col-sm-6 col-md-12 col-xl-6">
                                    <label class="form-label" for="prop-time">Продолжительность</label>
                                    <div class="row">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                              <i class="fa fa-fw fa-clock"></i>
                                            </span>
                                            <input type="text" class="form-control" id="prop-time"
                                                   name="duration" value="{{ $tour->duration }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-1 mb-xl-4 col-sm-6 col-md-12 col-xl-6">
                                    <label class="form-label" for="prop-starts">Старт</label>
                                    <div class="row">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                              <i class="fa fa-fw fa-rocket"></i>
                                            </span>
                                            <input type="text" class="form-control" id="prop-starts"
                                                   name="starting" value="{{ $tour->starting }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-1 col-sm-6 col-md-12 col-xl-6">
                                    <label class="form-label" for="prop-schedule">Расписание</label>
                                    <div class="row">

                                        <div class="input-group">
                                            <span class="input-group-text">
                                              <i class="fa fa-fw fa-calendar-days"></i>
                                            </span>
                                            <input type="text" class="form-control" id="prop-schedule"
                                                   name="schedule" value="{{ $tour->schedule }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 col-sm-6 col-md-12 col-xl-6">
                                    <label class="form-label" for="prop-price">Цена</label>
                                    <div class="row">

                                        <div class="input-group">
                                            <span class="input-group-text">
                                              <i class="fa fa-fw fa-money-bill"></i>
                                            </span>
                                            <input type="text" class="form-control" id="prop-price"
                                                   name="pricing" value="{{ $tour->pricing }}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--</editor-fold>-->
                            <!--<editor-fold desc="Length and Video">-->
                            <div class="col-sm-6 mb-1">
                                <label class="form-label block-title" for="length">Длинна <small>(отобр. на
                                        катрочке)</small></label>
                                <input type="text" class="form-control" id="length"
                                       name="length" placeholder="Длинна тура" value="{{ $tour->length }}">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label block-title" for="video">Видео</label>
                                <input type="text" class="form-control" id="video"
                                       name="video" placeholder="ID видео на YouTube (например: x2D7jHfitzk)"
                                       value="{{ $tour->video }}">
                            </div>
                            <!--</editor-fold>-->
                            <!--<editor-fold desc="Short Description">-->
                            <div class="mb-1">
                                <label class="form-label" for="short-description">Краткое описание</label>
                                <textarea class="form-control" id="short-description" name="short_description"
                                          placeholder="Описание, видимое на карточке тура.."
                                          rows="3">{{ $tour->short_description }}</textarea>
                            </div>
                            <!--</editor-fold>-->
                        </div>
                        <!--</editor-fold>-->
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <!--<editor-fold desc="Texts Block">-->
                            <div class="block block-rounded row g-0 border-secondary overflow-hidden">
                                <ul class="nav nav-tabs nav-tabs-block flex-md-column col-md-4 rounded-0"
                                    role="tablist">
                                    <li class="nav-item d-md-flex flex-md-column" role="presentation">
                                        <button class="nav-link fs-sm text-md-start rounded-0 active"
                                                id="btabs-vertical-program-tab" data-bs-toggle="tab"
                                                data-bs-target="#btabs-vertical-program" role="tab"
                                                aria-controls="btabs-vertical-home" aria-selected="true"
                                                onclick="event.preventDefault();">
                                            <i class="fa fa-fw fa-home opacity-50 me-1 d-none d-sm-inline-block"></i>
                                            Программа
                                        </button>
                                    </li>
                                    <li class="nav-item d-md-flex flex-md-column" role="presentation">
                                        <button class="nav-link fs-sm text-md-start rounded-0"
                                                id="btabs-vertical-additional-costs-tab" data-bs-toggle="tab"
                                                data-bs-target="#btabs-vertical-additional-costs" role="tab"
                                                aria-controls="btabs-vertical-profile" aria-selected="false"
                                                tabindex="-1" onclick="event.preventDefault();">
                                            <i class="fa fa-fw fa-user-circle opacity-50 me-1 d-none d-sm-inline-block"></i>
                                            Возможные дополнительные расходы
                                        </button>
                                    </li>
                                    <li class="nav-item d-md-flex flex-md-column" role="presentation">
                                        <button class="nav-link fs-sm text-md-start rounded-0"
                                                id="btabs-vertical-booking-conditions-tab" data-bs-toggle="tab"
                                                data-bs-target="#btabs-vertical-booking-conditions" role="tab"
                                                aria-controls="btabs-vertical-settings" aria-selected="false"
                                                tabindex="-1" onclick="event.preventDefault();">
                                            <i class="fa fa-fw fa-cog opacity-50 me-1 d-none d-sm-inline-block"></i>
                                            Условия
                                            бронирования
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content col-md-8">
                                    <div class="block-content mb-4 tab-pane active" id="btabs-vertical-program"
                                         role="tabpanel"
                                         aria-labelledby="btabs-vertical-program-tab" tabindex="0">

                                        <!-- Program Text -->
                                        <textarea class="form-control" id="program" name="program"
                                                  placeholder="Оставьте пустым, чтобы не отображать секцию"
                                                  rows="5">{{ $tour->program }}</textarea>
                                        <!-- END Program Text -->

                                    </div>
                                    <div class="block-content mb-4 tab-pane" id="btabs-vertical-additional-costs"
                                         role="tabpanel"
                                         aria-labelledby="btabs-vertical-additional-costs-tab" tabindex="0">

                                        <!-- Additional Costs -->
                                        <textarea class="form-control" id="additional" name="additional"
                                                  placeholder="Оставьте пустым, чтобы не отображать секцию"
                                                  rows="5">{{ $tour->additional }}</textarea>
                                        <!-- END Additional Costs -->

                                    </div>
                                    <div class="block-content mb-4 tab-pane" id="btabs-vertical-booking-conditions"
                                         role="tabpanel"
                                         aria-labelledby="btabs-vertical-booking-conditions-tab" tabindex="0">

                                        <!-- Booking Conditions Text -->
                                        <textarea class="form-control" id="booking" name="booking"
                                                  placeholder="Оставьте пустым, чтобы не отображать секцию"
                                                  rows="5">{{ $tour->booking }}</textarea>
                                        <!-- END Booking Conditions Text -->

                                    </div>
                                </div>
                            </div>
                            <!--</editor-fold>-->
                        </div>
                        <!--<editor-fold desc="Image Upload">-->
                        <div class="col-md-5">
                            <div class="block block-rounded">
                                <div class="uploadOuter">
                                    <label for="uploadFile" class="btn btn-primary">Загрузите изображение</label>
                                    <strong style="display: block">или</strong>
                                    <span class="dragBox">
                                      Перетащите изображение сюда
                                    <input type="file" onChange="dragNdrop(event)" ondragover="drag()" ondrop="drop()"
                                           id="uploadFile" name="image"/>
                                    </span>
                                </div>
                                <div id="preview">
                                    <img src="{{ $tour->image }}">
                                </div>
                            </div>
                        </div>
                        <!--</editor-fold>-->
                    </div>
                </form>
                <!--</editor-fold>-->
            </div>
        </div>
        <!--<editor-fold desc="Delete Modal">-->
        <div class="modal" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-small" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <form name="deleteForm" action="{{ route('tours.delete', $tour->id) }}" method="GET">
                        <div class="block block-rounded shadow-none mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Удаление тура</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content fs-sm">
                                <p>Вы уверены, что хотите удалить тур?</p>
                            </div>
                            <div class="block-content block-content-full block-content-sm text-end border-top">
                                <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal" onclick="event.preventDefault();">
                                    Отмена
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    Удалить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--</editor-fold>-->
    </div>
@endsection


@section('js_after')
    <script src="/js/views/drag-n-drop-single.js"></script>
    <script>
        function switchActive() {
            let switchPos = $('#active').is(':checked')
            let switchLabel = $('#active_label')
            if (switchPos) {
                switchLabel.html('Активен')
            } else {
                switchLabel.html('Не активен')
            }
        }
    </script>
@endsection
