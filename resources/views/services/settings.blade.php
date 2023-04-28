@extends('layouts.backend')

@section('css_after')
    <link rel="stylesheet" href="/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!--<editor-fold desc="Styles">-->
    <style>
        .alert {
            z-index: 1060 !important;
        }
    </style>
    <!--</editor-fold>-->

@endsection

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <!--<editor-fold desc="Block Header">-->
            <div class="block-header block-header-default">
                <h3 class="block-title">Настройки свойств услуг</h3>
            </div>
            <!--</editor-fold>-->
            <div class="block-content block-content-full">
                <div class="row items-push">

                    <!--<editor-fold desc="Currencies">-->
                    <div class="col-12">
                        <h2 class="content-heading pt-0 ps-4 mb-0">Валюты</h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-vcenter table-hover"
                                   id="currencies">
                                @include('services.includes.simple-list', ['listings' => $currencies, 'modalName' => 'CurrencyModal', 'deleteName' => 'эту валюту', 'newName' => 'новую валюту'])
                            </table>
                        </div>
                    </div>
                    <!--</editor-fold>-->
                    <!--<editor-fold desc="Price Units">-->
                    <div class="col-12">
                        <h2 class="content-heading pt-0 ps-4 mb-0">Единицы измерения цены</h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-vcenter table-hover"
                                   id="price_units">
                                @include('services.includes.simple-list', ['listings' => $priceUnits, 'modalName' => 'PriceUnitModal', 'deleteName' => 'эту единицу измерения цены', 'newName' => 'новую единицу измерения цены'])
                            </table>
                        </div>
                    </div>
                    <!--</editor-fold>-->
                    <!--<editor-fold desc="Sale Tags">-->
                    <div class="col-12">
                        <h2 class="content-heading pt-0 ps-4 mb-0">Метки распродажи</h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-vcenter table-hover"
                                   id="sale_tags">
                                @include('services.includes.saletags-list')
                            </table>
                        </div>
                    </div>
                    <!--</editor-fold>-->
                    <!--<editor-fold desc="Places">-->
                    <div class="col-12">
                        <h2 class="content-heading pt-0 ps-4 mb-0">Места</h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-vcenter js-table-sections table-hover" id="places">
                                @include('services.includes.places-list')
                            </table>
                        </div>
                    </div>
                    <!--</editor-fold>-->
                </div>
            </div>
        </div>
    </div>

    <!--<editor-fold desc="Modal">-->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-rounded shadow-none mb-0 overflow-hidden">
                    <!--<editor-fold desc="Modal Form">-->
                    <form action="/" name="modal-form" id="modal-form"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="block-header block-header-default">
                            <h3 class="block-title" id="modal-title">Место</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Закрыть">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content fs-sm row items-push">
                            <input type="hidden" id="placeID" name="id" value="" autocomplete="off">
                            <input type="hidden" id="parent_id" name="parent_id" value="" autocomplete="off">
                            <div class="form-check form-switch" id="active_div">
                                <input class="form-check-input" type="checkbox" value="1" id="active" name="active" checked="" autocomplete="off">
                                <label class="form-check-label" for="active">Актив</label>
                            </div>
                            <label for="name">Название</label>
                            <input class="form-control mb-2" name="name" id="name" autocomplete="off">
                            <label for="short_name" id="short_name_label">Короткое название</label>
                            <input class="form-control mb-2" name="short_name" id="short_name" autocomplete="off">
                            <label for="color_input" id="color_input_label">Цвет</label>
                            <input id="color_input" type="text" name="color" class="js-colorpicker form-control" value="#ffffff" autocomplete="off">
                        </div>
                        <div class="block-content block-content-full block-content-sm text-end pb-3">
                            <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal" onclick="event.preventDefault()">
                                Отмена
                            </button>
                            <input type="submit" value="Сохранить" class="btn btn-primary">
                        </div>
                    </form>
                    <!--</editor-fold>-->
                </div>
            </div>
        </div>
    </div>
    <!--</editor-fold>-->
    <!--<editor-fold desc="Delete Modal">-->
    <div class="modal" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-small" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="block block-rounded shadow-none mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Удаление места</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Закрыть">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        <p>Вы уверены, что хотите удалить <span id="delete-name"></span>?</p>
                        <input type="hidden" id="delete-place-id" value="0" autocomplete="off">
                        <input type="hidden" id="delete-mode" value="currency" autocomplete="off">
                    </div>
                    <div class="block-content block-content-full block-content-sm text-end border-top">
                        <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">
                            Отмена
                        </button>
                        <button type="button" class="btn btn-danger" onclick="requestDelete()">
                            Удалить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--</editor-fold>-->

@endsection

@section('js_after')
    <script>
        // region Modal
        class ListingModal {
            // region Modal Static
            static modalDOM = $('#modal')
            static formID = '#modal-form'
            static form = $('#modal-form')
            static name = $('#name')
            static shortName = $('#short_name')
            static shortNameLabel = $('#short_name_label')
            static idInput = $('#placeID')
            static parentIdInput = $('#parent_id')
            static colorInput = $('#color_input')
            static colorInputLabel = $('#color_input_label')
            static activeDiv = $('#active_div')
            static activeInput = $('#active')
            static csrf = '{{ csrf_token() }}'
            // endregion
            // region Modal Variables
            postURL;
            renderArea;
            renderURL;
            // endregion

            /**
             *  @param { number } id
             *  @param { string } name
             *  @param { JQuery } renderArea
             *  @param { string } renderURL
             *  @param { string } postURL
             */
            constructor(id = 0, name = '', renderArea, renderURL, postURL) {
                this.postURL = postURL;
                this.renderArea = renderArea;
                this.renderURL = renderURL;
                //this.fillModal(parent_id, id, name)
            }

            /**
             *  Fill modal with contextual content on opening.
             */
            fillModal(id, name) {
                // region Fill Form Fields
                if (id === 0) {
                    ListingModal.idInput.attr('disabled', 'disabled')
                } else {
                    ListingModal.idInput.removeAttr('disabled')
                }
                ListingModal.name.val(name)
                ListingModal.idInput.val(id)
                // endregion
                // region Bind Submit
                let modalCtx = this
                $(document).off('submit', ListingModal.formID)
                $(document).on('submit', ListingModal.formID, function (event) {
                    event.preventDefault();
                    modalCtx.formSubmit(modalCtx, this)
                })
                // endregion
            }

            render(modalCtx) {
                let url = this.renderURL;

                $.ajax({
                    url: url,
                    _token: ListingModal.csrf,
                    success: function (response) {
                        modalCtx.successFunction(response)
                    },
                    error: function (response) {
                        ListingModal.errorFunction(response)
                    }
                })
            }

            // region Traits
            formSubmit(modalCtx, form) {
                $.ajax({
                    url: modalCtx.postURL, method: 'POST',
                    data: new FormData(form), dataType: 'JSON',
                    contentType: false, cache: false, processData: false,

                    success: function(response) {
                        modalCtx.render(modalCtx);
                        ListingModal.modalDOM.modal('hide')
                        ListingModal.form.trigger("reset")
                        Codebase.helpers('jq-notify', {
                            icon: 'fa fa-check me-5',
                            message: response.result,
                            align: 'center',
                            from: 'bottom',
                            type: 'success',
                        })
                    },
                    error: function(response) {
                        ListingModal.errorFunction(response)
                    }
                })
            }
            static errorFunction(response) {
                if (response.status === 401) window.location.replace("/");
                console.log(response)
                Codebase.helpers('jq-notify', {
                    icon: 'fa fa-times me-5',
                    message: response.responseJSON.message,
                    align: 'center',
                    from: 'bottom',
                    type: 'danger',
                    delay: 100000,
                })
            }
            successFunction(rendered) {
                this.renderArea.html('')
                this.renderArea.html(rendered)
                $('span', this.renderArea).tooltip();
            }
            // endregion
        }
        class CurrencyModal extends ListingModal {
            constructor(id = 0, name = '', shortName = '') {
                let postURL = (id === 0) ? '{{ route('currencies.create') }}' : '{{ route('currencies.update') }}'
                let renderArea = $('#currencies');
                let renderURL = '{{ route('currencies.get') }}'
                super(id, name, renderArea, renderURL, postURL);
                this.fillModal(id, name, shortName)
            }
            fillModal(id, name, shortName) {
                if (id === 0) {
                    $('#modal-title').html('Новая валюта')
                } else {
                    $('#modal-title').html('Редактировать валюту')
                }
                ListingModal.parentIdInput.removeAttr('disabled')
                ListingModal.shortName.removeAttr('disabled')
                ListingModal.shortName.show()
                ListingModal.shortNameLabel.show()
                ListingModal.shortName.val(shortName)
                ListingModal.colorInput.attr('disabled', 'disabled')
                ListingModal.colorInput.hide()
                ListingModal.colorInputLabel.hide()
                ListingModal.activeDiv.hide()
                ListingModal.activeInput.attr('disabled', 'disabled')
                super.fillModal(id, name);
            }
        }
        class PriceUnitModal extends ListingModal {
            constructor(id = 0, name = '') {
                let postURL = (id === 0) ? '{{ route('price-units.create') }}' : '{{ route('price-units.update') }}'
                let renderArea = $('#price_units')
                let renderURL = '{{ route('price-units.get') }}'
                super(id, name, renderArea, renderURL, postURL)
                this.fillModal(id, name)
            }
            fillModal(id, name) {
                if (id === 0) {
                    $('#modal-title').html('Новая единица измерения цены')
                } else {
                    $('#modal-title').html('Редактировать единицу измерения цены')
                }
                ListingModal.parentIdInput.attr('disabled', 'disabled');
                ListingModal.shortName.hide()
                ListingModal.shortNameLabel.hide()
                ListingModal.shortName.attr('disabled', 'disabled')
                ListingModal.colorInput.attr('disabled','disabled');
                ListingModal.colorInput.hide()
                ListingModal.colorInputLabel.hide()
                ListingModal.activeDiv.hide()
                ListingModal.activeInput.attr('disabled', 'disabled')
                super.fillModal(id, name);
            }
        }
        class SaleTagModal extends ListingModal {
            constructor(id = 0, name = '', color = '') {
                let postURL = (id === 0) ? '{{ route('sale-tags.create') }}' : '{{ route('sale-tags.update') }}'
                let renderArea = $('#sale_tags')
                let renderURL = '{{ route('sale-tags.get') }}'
                super(id, name, renderArea, renderURL, postURL);
                this.fillModal(id, name, color)
            }
            fillModal(id, name, color) {
                if (id === 0) {
                    $('#modal-title').html('Новая метка распродажи')
                } else {
                    $('#modal-title').html('Редактировать метка распродажи')
                }
                ListingModal.colorInput.removeAttr('disabled')
                ListingModal.colorInput.val(color)
                ListingModal.colorInput.show()
                ListingModal.colorInputLabel.show()
                ListingModal.shortName.hide()
                ListingModal.shortNameLabel.hide()
                ListingModal.shortName.attr('disabled', 'disabled')
                ListingModal.parentIdInput.attr('disabled', 'disabled')
                ListingModal.activeDiv.hide()
                ListingModal.activeInput.attr('disabled', 'disabled')
                super.fillModal(id, name)
            }
        }
        class PlaceModal extends ListingModal {
            constructor(parent_id, id = 0, name = '', active = 1) {
                let postURL = (id === 0) ? '{{ route('places.create') }}' : '{{ route('places.update') }}'
                let renderArea = $('#places');
                let renderURL = '{{ route('places.get') }}'
                super(id, name, renderArea, renderURL, postURL);
                this.fillModal(parent_id, id, name, active)
            }
            fillModal(parent_id, id, name, active) {
                if (id === 0) {
                    $('#modal-title').html('Новое место')
                } else {
                    $('#modal-title').html('Редактировать место')
                }
                ListingModal.colorInput.attr('disabled', 'disabled')
                ListingModal.colorInput.hide()
                ListingModal.colorInputLabel.hide()
                ListingModal.shortName.hide()
                ListingModal.shortNameLabel.hide()
                ListingModal.shortName.attr('disabled', 'disabled')
                ListingModal.parentIdInput.removeAttr('disabled')
                ListingModal.parentIdInput.val(parent_id)
                ListingModal.activeDiv.show()
                ListingModal.activeInput.removeAttr('disabled')
                if (active === 1) {
                    console.log('active')
                    ListingModal.activeInput.attr('checked', 'checked')
                } else {
                    console.log('inactive')
                    ListingModal.activeInput.removeAttr('checked')
                }

                super.fillModal(id, name)
            }
            successFunction(rendered) {
                super.successFunction(rendered);
                this.renderArea.removeClass('js-table-sections-enabled')
                Codebase.helpers('cb-table-tools-sections')
            }
        }
        let modal = null;
        // endregion
        //region Delete Modal
        function setDeleteModal(mode, id, name) {
            $('#delete-place-id').val(id)
            $('#delete-name').html(name)
            $('#delete-mode').val(mode)
        }
        function requestDelete() {
            let id = $('#delete-place-id').val()
            let mode = $('#delete-mode').val()
            let baseURL = setUrl(mode)
            let url = baseURL + '?id='+id

            $.ajax({
                url: url,
                _token: ListingModal.csrf,
                success: function(response) {
                    $('#modal-delete').modal('hide')
                    $('#delete-place-id').val('')
                    Codebase.helpers('jq-notify', {
                        icon: 'fa fa-check me-5',
                        message: response.result,
                        align: 'center',
                        from: 'bottom',
                        type: 'success',
                    })
                    /* TODO: Дописать поштучное обновление конкретного списка */
                    location.reload();
                },
                error: function(response) {
                    if (response.status === 401) window.location.replace("/");
                    console.log(response)
                    Codebase.helpers('jq-notify', {
                        icon: 'fa fa-times me-5',
                        message: response.responseJSON.message,
                        align: 'center',
                        from: 'bottom',
                        type: 'danger',
                        delay: 100000,
                    })
                }
            })
        }
        function setUrl(mode) {
            switch (mode) {
                case 'CurrencyModal':
                    return '{{ route('currencies.delete') }}'
                    break;
                case 'PriceUnitModal':
                    return '{{ route('price-units.delete') }}'
                    break;
                case 'SaleTagModal':
                    return '{{ route('sale-tags.delete') }}'
                    break;
                case 'PlaceModal':
                    return '{{ route('places.delete') }}'
                    break;
            }
        }
        //endregion
    </script>
    <script src="/js/views/drag-n-drop-single.js"></script>
    <script>Codebase.helpersOnLoad('cb-table-tools-sections');</script>
    <script src="/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script>Codebase.helpersOnLoad('jq-colorpicker');</script>
@endsection
