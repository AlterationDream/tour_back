@extends('layouts.backend')

@section('css_after')
    <!--<editor-fold desc="Styles">-->
    <style>
        .alert {
            z-index: 1060 !important;
        }
        #parent-categories button {
            padding: 7px 12px;
        }
        #category-modal .block-content {
            padding: 15px 26px 4px;
        }
        .shapes-select {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
        }
        .shape-container {
            flex-basis: 30%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 12px;
            border: 2px solid #e6e6e655;
            border-radius: 12px;
            cursor: pointer;
        }
        .shape-container.active {
            border-color: #0080de99;
        }
        .shape {
            border-width: 3px;
            border-style: dashed;
        }
        .shape.shape-full {
            aspect-ratio: 1.675;
            width: 100%;
        }
        .shape.shape-half {
            aspect-ratio: 0.79;
            height: 100%;
        }
        .shape.shape-small {
            aspect-ratio: 1.316;
            height: 50%;
        }
        .uploadOuter {
            text-align: center;
            padding: 20px 0 0 0;;
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
            padding: 20px 20px 20px;
            width: 100%;
            text-align: center;
            padding-top: 20px;
        }
        #preview img {
            max-width: 100%;
        }
        .img-category {
            max-width: 256px;
            max-height: 256px;
        }
        #modal-delete {
            top: 30%;
        }
    </style>
    <!--</editor-fold>-->
@endsection

@section('content')
    <div class="content">
        <!--<editor-fold desc="Page Header">-->
        <div class="mb-4 text-center">
            <h2 class="fw-bold mb-2">
                Категории
            </h2>
        </div>
        <!--</editor-fold>-->
        <!--<editor-fold desc="Parent Categories">-->
        <div class="px-4 py-3 bg-body-extra-light rounded push">
            <ul class="nav nav-pills justify-content-center space-x-1" id="parent-categories">
                @include('services.categories.includes.parent-categories')
            </ul>
        </div>
        <!--</editor-fold>-->
        <!--<editor-fold desc="Child Categories">-->
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter js-table-sections table-hover" id="child-categories">
                    @include('services.categories.includes.child-categories')
                </table>
            </div>
        </div>
        <!--</editor-fold>-->
    </div>

    <!--<editor-fold desc="Modal">-->
    <div class="modal fade" id="category-modal" tabindex="-1" aria-labelledby="category-modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-rounded shadow-none mb-0 overflow-hidden">
                    <!--<editor-fold desc="Modal Form">-->
                    <form action="/" name="category-form" id="category-form"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="block-header block-header-default">
                            <h3 class="block-title" id="modal-title">Родительская категория</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Закрыть">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content fs-sm row items-push">
                            <input type="hidden" id="categoryID" name="id" value="">
                            <div class="form-check form-switch" id="active_div">
                                <input class="form-check-input" type="checkbox" value="1" id="active" name="active" checked="" autocomplete="off">
                                <label class="form-check-label" for="active">Актив</label>
                            </div>
                            <label for="name">Название</label>
                            <input class="form-control mb-2" name="name" id="name" autocomplete="off">
                            <!--<editor-fold desc="Category Order (includes order-select)">-->
                            <label for="category-order">После</label>
                            <select class="form-select mb-2" name="after" id="category-order">

                            </select>
                            <!--</editor-fold>-->
                            <!--<editor-fold desc="Shape Select">-->
                            <div id="form-shapes" class="g-0">
                                <label for="parent-name">Форма</label>
                                <input class="form-control" type="hidden" name="shape" id="shape" autocomplete="off">
                                <div class="shapes-select mb-2">
                                    <div class="shape-container active" onclick="ChildrenModal.selectShape('full')" data-shape="full">
                                        <div class="shape shape-full border-secondary"></div>
                                    </div>
                                    <div class="shape-container" onclick="ChildrenModal.selectShape('half')" data-shape="half">
                                        <div class="shape shape-half border-secondary"></div>
                                    </div>
                                    <div class="shape-container" onclick="ChildrenModal.selectShape('small')" data-shape="small">
                                        <div class="shape shape-small border-secondary"></div>
                                    </div>
                                </div>
                            </div>
                            <!--</editor-fold>-->
                            <!--<editor-fold desc="Image Upload">-->
                            <div class="uploadOuter" id="image-upload">
                                <span class="dragBox">
                                      Перетащите изображение сюда
                                    <input type="file" onChange="dragNdrop(event)" ondragover="drag()" ondrop="drop()"
                                           id="uploadFile" name="image" autocomplete="off"/>
                                </span>
                            </div>
                            <div id="preview" class="shadow-sm rounded-3"></div>
                            <input type="hidden" name="parent_id" id="parent_id" value="0" autocomplete="off">
                            <!--</editor-fold>-->
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
                        <h3 class="block-title">Удаление категории</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        <p>Вы уверены, что хотите удалить категорию?</p>
                        <input type="hidden" id="delete-category-id" value="0">
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
        // region Category Modal
        class CategoryModal {
            // region Modal Static
            static modalDOM = $('#category-modal')
            static formID = '#category-form'
            static form = $('#category-form')
            static categoryID = $('#categoryID');
            static name = $('#name')
            static after = $('#category-order')
            static parentIdInput = $('#parent_id')
            static activeDiv = $('#active_div')
            static activeInput = $('#active')
            static csrf = '{{ csrf_token() }}'
            // endregion
            // region Modal Variables
            currentCategory;
            postURL;
            mode;
            renderArea;
            parent_id;
            // endregion

            /**
             *  @param { ParentCategoriesArea|ChildCategoriesArea } renderArea
             *  @param { number } parent_id
             *  @param { number } currentCategory
             */
            constructor(renderArea, parent_id, currentCategory) {
                if (this.constructor === CategoryModal) throw new Error('Trying to instantiate abstract class.')
                this.currentCategory = currentCategory
                this.postURL = (currentCategory === 0) ? '{{ route('services.categories.create') }}' : '{{ route('services.categories.update') }}'
                this.mode = (currentCategory === 0) ? 'create' : 'update'
                this.renderArea = renderArea
                this.parent_id = parent_id
            }

            /**
             *  Fill modal with contextual content on opening.
             */
            fillModal() {
                CategoryModal.parentIdInput.val(this.parent_id)
                categoriesSelect.renderCategories(this.parent_id, this.currentCategory)

                if (this.mode == 'update') {
                    CategoryModal.name.val(CategoriesArea.getCategoryInfo('name', this.currentCategory))
                    CategoryModal.categoryID.val(this.currentCategory);
                } else {
                    CategoryModal.name.val('')
                }

                let modalCtx = this
                $(document).off('submit', CategoryModal.formID)
                $(document).on('submit', CategoryModal.formID, function (event) {
                    event.preventDefault();
                    modalCtx.formSubmit(modalCtx, this)
                })
            }

            // region Traits
            formSubmit(modalCtx, form) {
                $.ajax({
                    url: modalCtx.postURL, method: 'POST',
                    data: new FormData(form), dataType: 'JSON',
                    contentType: false, cache: false, processData: false,

                    success: function(response) {
                        modalCtx.renderArea.renderCategories();
                        CategoryModal.modalDOM.modal('hide')
                        CategoryModal.form.trigger("reset")
                        Codebase.helpers('jq-notify', {
                            icon: 'fa fa-check me-5',
                            message: response.result,
                            align: 'center',
                            from: 'bottom',
                            type: 'success',
                        })
                    },
                    error: function(response) {
                        CategoryModal.errorFunction(response)
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
            // endregion
        }
        class ParentModal extends CategoryModal {
            constructor(currentCategory = 0) {
                super(parentCategoriesArea, 0, currentCategory)
                this.init()
                super.fillModal()
            }

            init() {
                $('#modal-title').html('Родительская категория')
                $('#image-upload').hide()
                $('#preview').hide()
                $('#uploadFile').attr('disabled', 'disabled')
                $('#form-shapes').hide()
                $('#shape').attr('disabled', 'disabled')
                CategoryModal.activeDiv.hide()
                CategoryModal.activeInput.attr('disabled', 'disabled')
                if (this.mode === 'create') {
                    CategoryModal.categoryID.attr('disabled', 'disabled')
                } else {
                    CategoryModal.categoryID.removeAttr('disabled')
                }
            }
        }
        class ChildrenModal extends CategoryModal {
            constructor(parent_id = 0, currentCategory = 0) {
                if (parent_id === 0) parent_id = parentCategoriesArea.activeCategory
                super(childCategoriesArea, parent_id, currentCategory);
                this.init()
                super.fillModal()
            }

            init() {
                $('#modal-title').html('Дочерняя категория')
                $('#image-upload').show()
                $('#preview').show()
                $('#uploadFile').removeAttr('disabled')
                $('#form-shapes').show()
                $('#shape').removeAttr('disabled')
                CategoryModal.activeDiv.show()
                CategoryModal.activeInput.removeAttr('disabled')



                ChildrenModal.clearImg()
                if (this.mode === 'create') {
                    CategoryModal.activeInput.attr('checked', 'checked')
                    ChildrenModal.selectShape('full')
                    CategoryModal.categoryID.attr('disabled', 'disabled')
                } else {
                    ChildrenModal.setActive(CategoriesArea.getCategoryInfo('active', this.currentCategory))
                    ChildrenModal.selectShape(CategoriesArea.getCategoryInfo('shape', this.currentCategory))
                    ChildrenModal.appendImg(CategoriesArea.getCategoryInfo('image', this.currentCategory))
                    CategoryModal.categoryID.removeAttr('disabled')
                }
            }
            static clearImg() {
                $('#preview').html('')
            }
            static appendImg(src) {
                let preview = document.getElementById("preview");
                let previewImg = document.createElement("img");
                previewImg.setAttribute('src', src);
                preview.appendChild(previewImg);
            }
            static selectShape(size) {
                $('.shape-container').each(function () {
                    $(this).removeClass('active')
                    $('.shape-container[data-shape="' + size + '"]').addClass('active')
                })
                $('input[name="shape"]', CategoryModal.modalDOM).val(size)
            }
            static setActive(status) {
                if (status === '1') {
                    CategoryModal.activeInput.attr('checked', 'checked')
                } else {
                    CategoryModal.activeInput.removeAttr('checked')
                }
            }
        }
        let categoryModal = null;
        // endregion
        //region Delete Modal
        function setDeleteModal(id) {
            $('#delete-category-id').val(id)
        }
        function requestDelete() {
            let id = $('#delete-category-id').val()
            let url = '{{ route('services.categories.delete') }}?id='+id

            $.ajax({
                url: url,
                _token: CategoryModal.csrf,
                success: function(response) {
                    $('#modal-delete').modal('hide')
                    $('#delete-category-id').val('')
                    Codebase.helpers('jq-notify', {
                        icon: 'fa fa-check me-5',
                        message: response.result,
                        align: 'center',
                        from: 'bottom',
                        type: 'success',
                    })
                    parentCategoriesArea.renderCategories()
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
        //endregion
    </script>
    <script>
        // region CategoriesArea
        class CategoriesArea {
            constructor(areaDOM, renderTemplate, renderVariable) {
                if (this.constructor === CategoriesArea) throw new Error('Trying to instantiate abstract class.')
                this.areaDOM = areaDOM
                this.renderTemplate = renderTemplate
                this.renderVariable = renderVariable
            }

            renderCategories(parent_id, currentCategory = 0) {
                let areaCtx = this
                let url = '{{ route('services.categories.get-categories') }}'+
                    '?current=' + currentCategory +
                    '&parent_id=' + parent_id +
                    '&varname=' + areaCtx.renderVariable +
                    '&include=' + areaCtx.renderTemplate

                $.ajax({
                    url: url,
                    _token: CategoryModal.csrf,
                    success: function(categories) {
                        areaCtx.successFunction(categories)
                    },
                    error: function (response) {
                        CategoryModal.errorFunction(response)
                    }
                })
            }
            successFunction(categories) {
                this.areaDOM.html('')
                this.areaDOM.html(categories)
            }
            static getCategoryInfo(name, id) {
                let categoryInfoBlock = $('div[data-category-info="' + id + '"]')
                return $('input[name="' + name +'"]', categoryInfoBlock).val()
            }
        }
        class ParentCategoriesArea extends CategoriesArea {
            activeCategory = {{ (count($parentCategories) > 0) ? $parentCategories->first()->id : '' }};
            categoriesRendered = true;

            constructor() {
                super($('#parent-categories'),
                    'services.categories.includes.parent-categories',
                    'parentCategories');
            }

            /**
             * Rerender parent categories.
             */
            renderCategories() {
                let currentCategory = 0
                let parent_id = 0
                super.renderCategories(parent_id, currentCategory);
                this.categoriesRendered = false;
                this.awaitRender()
            }

            /**
             * Set active parent category
             * @param id - Category ID
             */
            setActiveCategory(id) {
                let categories = $('#parent-categories a')
                for (let category of categories) category.classList.remove('active')
                $('#parent-categories a[data-category="' + id +'"]').addClass('active')
                if (id !== '') {
                    if (this.activeCategory === '') {
                        $('#new-child-category').show();
                    }
                } else {
                    $('#new-child-category').hide();
                }
                parentCategoriesArea.activeCategory = id
                childCategoriesArea.renderCategories()
            }

            enterEdit() {
                $('#parent-categories .category-switch').each(function () {
                    let ID = $(this).attr('data-category')
                    let after = $(this).attr('data-category-after')
                    let name = $(this).html().trim();
                    $(this).replaceWith('' +
                        '<div class="parent-edit btn-group me-3" role="group">' +
                        '<div class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#category-modal"' +
                        'onclick="event.preventDefault(); categoryModal = new ParentModal(' + ID + ')">' +
                        '<i class="fa fa-pencil me-2"></i>' + name +
                        '</div>' +
                        '<div class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-delete" ' +
                        'onclick="event.preventDefault(); setDeleteModal(' + ID + ');">' +
                        '<i class="fa fa-times"/></i>' +
                        '</div>' +
                        '</div>' +
                        '<div style="display: none" data-category-info="' + ID + '">' +
                        '<input name="name" type="hidden" value="' + name + '">' +
                        '<input name="after" type="hidden" value="' + after + '">' +
                        '</div>')
                })
                $('#parent-categories li').has('button').remove()
                let closeBtn = '<div class="btn btn-danger" data-bs-toggle="tooltip" aria-label="Отмена" ' +
                    'data-bs-original-title="Отмена" onclick="parentCategoriesArea.renderCategories()">' +
                    '   <i class="fa fa-ban"></i>' +
                    '</div>';
                $('#parent-categories').append($.parseHTML(closeBtn))
            }

            awaitRender() {
                let areaCtx = this;
                let checkRendered = setInterval(function () {
                    if (!areaCtx.categoriesRendered) {
                        return;
                    }
                    let categoriesList = $('li a', areaCtx.areaDOM)
                    let newActive = (categoriesList.length) ? $('li:first a', areaCtx.areaDOM).attr('data-category') : ''
                    areaCtx.setActiveCategory(newActive)
                    clearInterval(checkRendered)
                }, 100)
            }
        }
        class ChildCategoriesArea extends CategoriesArea {
            constructor() {
                super($('#child-categories'),
                    'services.categories.includes.child-categories',
                    'childCategories');
                this.init()
            }

            init() {
                if (parentCategoriesArea.activeCategory === '') {
                    $('#new-child-category').hide()
                }
            }

            renderCategories() {
                let currentCategory = 0
                let parent_id = parentCategoriesArea.activeCategory
                super.renderCategories(parent_id, currentCategory);
            }

            successFunction(categories) {
                super.successFunction(categories);
                this.areaDOM.removeClass('js-table-sections-enabled')
                Codebase.helpers('cb-table-tools-sections')
                $('span', this.areaDOM).tooltip();
                $('a[data-bs-toggle="popover"]', this.areaDOM).popover();
            }
        }
        class CategoriesSelect extends CategoriesArea {
            constructor() {
                super($('#category-order'),
                    'services.categories.includes.order-select',
                    'categories');
            }

            renderCategories(parent_id = 0, currentCategory = 0) {
                super.renderCategories(parent_id, currentCategory);
            }
        }

        let parentCategoriesArea = new ParentCategoriesArea()
        let childCategoriesArea = new ChildCategoriesArea()
        let categoriesSelect = new CategoriesSelect()
        // endregion
    </script>
    <script src="/js/views/drag-n-drop-single.js"></script>
    <script>Codebase.helpersOnLoad('cb-table-tools-sections');</script>
@endsection
