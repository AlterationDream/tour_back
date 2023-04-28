<?php
/**
 * @var $blockFormats
 */
?>
@extends('layouts.backend')

@section('css_after')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!--<editor-fold desc="Styles">-->
    <style>
        .repeater .items {
            padding: 16px 0;
            border-bottom: 1px dashed #a3aab2;
            margin: 0 -14px;
        }
        .repeater .items:last-child {
            margin-bottom: -32px;
            border-bottom: none;
        }
        .repeater .items .row {
            padding: 0 15px;
        }
        .section-container .block-content .repeater-remove-btn {
            margin-top: 29px;
        }
        div[data-name="howWeWorkSection"] .repeater-remove-btn {
            margin-top: -63px;
        }

        .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default,
        .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
            background: #fff;
            border: 1px solid #e1e1e1;
        }
        #content-blocks {
            margin: 0 0 -32px;
        }
        #content-blocks > div {
            margin-bottom: 16px;
        }
        #content-blocks .block-content {
            padding-top: 14px;
        }

        .section-toggle {
            margin-top: 4px;
            transition: transform 0.3s ease-out;
            display: inline-block;
        }
        .section-toggle.closed {
            transform: rotate(90deg);
        }
        .dark-mode .block-options .section-toggle,
        .dark-mode #content-blocks .form-label {
            color: #fff !important;
        }
    </style>
    <!--</editor-fold>-->
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <nav class="breadcrumb push">
                    <span class="breadcrumb-item active">Информационные страницы</span>
                    <span class="breadcrumb-item active">{{ $pageName }}</span>
                </nav>
                <div class="block block-rounded" id="pageEditBlock">
                    <!--<editor-fold desc="Block Header">-->
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Редактировать страницу</h3>
                        <div class="block-options">
                            <button type="submit" class="btn btn-sm btn-primary" id="submit-all" onclick="event.preventDefault(); evaluatePage()">
                                <i class="fa fa-save opacity-50 me-1"></i> Сохранить
                            </button>
                        </div>
                    </div>
                    <!--</editor-fold>-->
                    <div class="block-content block-content-full">
                        <div class="row items-push">
                            <!--<editor-fold desc="Section Select">-->
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select name="block-select" id="block-select" class="form-select"></select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="btn btn-outline-primary" onclick="event.preventDefault(); Section.createSelectedSection()">Добавить секцию</div>
                                    </div>
                                </div>
                            </div>
                            <!--</editor-fold>-->
                            <!--<editor-fold desc="Content Blocks">-->
                            <div class="col-12">
                                <div id="content-blocks">

                                </div>
                            </div>
                            <!--</editor-fold>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="pageUpdate" action="{{ route('info-pages.update') }}" method="POST" enctype="multipart/form-data" style="display:none;">
        @csrf
        <input type="hidden" name="id" value="{{ $pageId }}">
        <input type="hidden" name="json_eval" value="">
    </form>

@endsection

@section('js_after')
    <script src="/js/views/repeater.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        // region Elements Constructor
        class Element {
            static contentBlocks = $('#content-blocks')
            constructor(blockData) {
                if (this.constructor === Element) throw new Error('Trying to instantiate abstract class.')
                this.name = blockData['name'];
                this.type = blockData['type'];
            }

            // region Section Create Traits
            static createSectionContent(data) {
                let container = $('<div>')
                for (let index in data) {
                    let inputGroup = Element.createInputGroup(index, data[index])
                    container.append(inputGroup)
                }
                return container
            }

            static createSectionAPI(data) {
                let container = $('<div>', { class: 'section-container'})
                let buttonsSection = $('<div>', { class: 'mb-3' }).appendTo(container)
                $('<div>', { class: 'section-blocks' }).appendTo(container)
                for (let index of data) {
                    $('<div>', {
                        text: '+ ' + blockList['contents'][index]['name'],
                        class: 'btn btn-outline-dark me-2',
                        click: function () {
                            Section.appendBlock(index.toString(), $(this).parents(".section-container").first().find(".section-blocks"))
                        }
                    }).appendTo(buttonsSection)
                }
                return container
            }

            static createInputGroup(index, group) {
                let groupWrap = $('<div>', {
                    class: 'mb-4',
                    "data-name": index,
                    "data-type": group['type']
                })

                let contents = Element.getTypeContent(group['type'], group)
                for (let element of contents) {
                    groupWrap.append(element)
                }

                return groupWrap
            }

            static createLabel(name) {
                return $('<label>', { class: 'form-label', text: name })
            }

            static getTypeContent(type, group) {
                switch (type) {
                    case 'string':
                        return Element.stringType(group)
                    case 'text':
                        return Element.textType(group)
                    case 'video':
                        return Element.videoType(group)
                    case 'button':
                        return Element.buttonType(group)
                    case 'image':
                        return Element.imageType(group)
                    default: // case 'array'
                        return Element.arrayType(group)
                }
            }

            static createSortableBlock(index, data) {
                let name = ('content' in data) ? data['name'] : data[index]['name']

                let block = $('<div>', { class: 'ui-state-default block block-rounded', "data-name": index })
                if (!('content' in data)) {
                    block.attr('data-type', data[index]['type'])
                }
                let blockHeader = $('<div>', { class: 'block-header'}).appendTo(block)
                $('<h3 class="block-title">' +
                    '<i class="fa fa-up-down-left-right" style="font-size: 18px;"></i> ' +
                    name + '</h3>').appendTo(blockHeader)

                let blockOptions = $('<div>', { class: 'block-options' }).appendTo(blockHeader)
                let blockToggle = $('<a>', {
                    class: 'section-toggle closed me-5',
                    click: function () {
                        $(this).toggleClass('closed')
                        $(this).parents('.block').first().find('.block-content').toggleClass('collapse')
                    }
                }).appendTo(blockOptions)
                $('<i>', { class: 'si si-arrow-down' }).appendTo(blockToggle)

                let blockDelete = $('<div>', {
                    class: 'btn btn-sm btn-outline-danger float-end',
                    click: function () { $(this).parents('.ui-state-default').first().remove() }
                }).appendTo(blockOptions)
                $('<i class="fa fa-trash"></i>').appendTo(blockDelete)

                let blockContent = ('content' in data) ?
                    Section.sectionTypeCreate(data['type'], data['content'])
                    :
                    Element.createSectionContent(data);

                blockContent.addClass('block-content collapse')
                block.append(blockContent)
                return block
            }
            // endregion
            // region Element Types
            static stringType(group) {
                let label = Element.createLabel(group['inputName'])
                let typeElement = $('<input>', { type: 'text', class: 'form-control' })
                return [label, typeElement]
            }

            static textType(group) {
                let label = Element.createLabel(group['inputName'])
                let typeElement = $('<textarea>', { class: 'form-control', rows: '4' })
                return [label, typeElement]
            }

            static videoType(group) {
                let label = Element.createLabel(group['inputName'])
                let typeElement = $('<input>', { type: 'text', class: 'form-control' })
                return [label, typeElement]
            }

            static buttonType(group) {
                let { inputName, actions } = group
                let label = Element.createLabel(inputName)
                let typeElement = $('<input>', {
                    type: 'text',
                    placeholder: 'Текст кнопки',
                    class: 'form-control' })
                let selectLabel = Element.createLabel('Действие кнопки')
                $(selectLabel).addClass('mt-2')
                let selectElement = $('<select>', { class: 'form-select' })

                for (let action in actions) {
                    $('<option>', {
                        value: action,
                        text: actions[action]
                    }).appendTo(selectElement)
                }
                return [label, typeElement, selectLabel, selectElement]
            }

            static imageType(group) {
                let label = Element.createLabel(group['inputName'])
                let typeElement = $('<input>', {
                    type: 'file',
                    class: 'form-control',
                    change: function (event) {
                        readFile(event.currentTarget)
                    }
                })
                let uploadNew = $('<input>', { type: 'hidden', class: 'upload-new' })
                let uploadOld = $('<input>', { type: 'hidden', class: 'upload-old' })
                return [label, typeElement, uploadNew, uploadOld]
            }

            static arrayType(group) {
                let { inputName, format } = group
                let label = Element.createLabel(inputName)

                let row = $('<div>', { class: 'row' })
                for (let index in format) {
                    let repeaterTemplateElement = Element.createInputGroup(index, format[index])
                    repeaterTemplateElement.addClass('col-11')
                    row.append(repeaterTemplateElement)
                }

                let repeater = $('<div>', { class: 'repeater' })
                let repeaterHeading = $('<div>', {
                    class: 'repeater-heading'
                }).appendTo(repeater)
                $('<button>', {
                    class: 'btn btn-outline-primary repeater-add-btn',
                    click: function(event) { event.preventDefault() },
                    text: 'Добавить'
                }).appendTo(repeaterHeading)

                let items = $('<div>', { class: 'items' }).appendTo(repeater)
                items.append(row)
                let removeBtnDiv = $('<div>', {
                    class: 'pull-right repeater-remove-btn col-1'
                }).appendTo(row)
                let removeBtn = $('<button>', {
                    id: 'remove-btn',
                    class: 'btn btn-outline-danger',
                    click: function(event) { event.preventDefault(); $(this).parents('.items').first().remove() }
                }).appendTo(removeBtnDiv)
                $('<i>', { class: 'fa fa-trash' }).appendTo(removeBtn)

                return [label, repeater]
            }

            // endregion
        }
        class Section extends Element {
            static sectionSelect = $('#block-select')

            constructor(blockData) {
                super(blockData);
                this.contentType = blockData['type']
                this.contentTemplate = blockData['content']
            }

            static fillSelect() {
                Section.sectionSelect.html()
                let sections = blockList['sections']
                for (let index in sections) {
                    $('<option>', {
                        text: sections[index]['name'],
                        value: index
                    }).appendTo(Section.sectionSelect)
                }
            }

            static createSelectedSection() {
                let sectionIndex = this.sectionSelect.val()
                Section.addSection(sectionIndex)
            }

            static addSection(sectionIndex) {
                let sectionData = blockList['sections'][sectionIndex]
                let section = Element.createSortableBlock(sectionIndex, sectionData)
                Element.contentBlocks.append(section)
                $('.repeater', section).createRepeater()
                $('.section-blocks', section).sortable()
                return section
            }

            static sectionTypeCreate(sectionType, sectionData) {
                switch (sectionType) {
                    case 'setContent':
                        return Element.createSectionContent(sectionData)
                    default:    // case 'variableContent'
                        return Element.createSectionAPI(sectionData)
                }
            }

            static appendBlock(index, container) {
                let typeData = {}
                typeData[index] = blockList['contents'][index]
                let block = Element.createSortableBlock(index, typeData)

                container.append(block)
                $('.repeater', block).createRepeater()
                return block
            }
        }
        // endregion
    </script>
    <script>
        const blockList = <?php echo json_encode($blockFormats, JSON_UNESCAPED_UNICODE); ?>;
        Section.fillSelect()
        Element.contentBlocks.sortable()
    </script>
    <script>
        // region Page Evaluation
        function evaluatePage() {
            Codebase.block('state_loading', '#pageEditBlock');
            let sectionsDOM = $('#content-blocks').children()
            let json = []
            const fileInputs = $('input[type="file"]').get()

            for (let section of sectionsDOM) {
                let type = $(section).attr('data-name')
                let sectionContent = getSectionContent(section, type)
                json.push({
                    type: type,
                    content: sectionContent
                })
            }
            let jsonStr = JSON.stringify(json)
            $('input[name="json_eval"]').val(jsonStr)
            $('#pageUpdate').submit()
        }

        /*function readFiles(input) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(input.files[0]);
                reader.onload = () => {
                    input.nextElementSibling.value = reader.result
                    return resolve()
                };
                reader.onerror = error => {
                    Codebase.helpers('jq-notify', {
                        icon: 'fa fa-times me-5',
                        message: 'Изображение - обязательное поле',
                        align: 'center',
                        from: 'bottom',
                        type: 'danger',
                    });
                    return reject()
                };
            })
        }*/

        function readFile(fileInput) {
            const reader = new FileReader();
            reader.readAsDataURL(fileInput.files[0]);
            console.log(fileInput.files[0])
            reader.onload = () => {
                fileInput.nextElementSibling.value = reader.result
                return false;
            };
            reader.onerror = error => {
                Codebase.helpers('jq-notify', {
                    icon: 'fa fa-times me-5',
                    message: 'Изображение загрузить не удалось!',
                    align: 'center',
                    from: 'bottom',
                    type: 'danger',
                });
                return false;
            };
        }

        function getSectionContent(section, type) {
            let content = []
            if (blockList['sections'][type]['type'] === 'variableContent') {
                let childElements = $('.ui-state-default', section)
                for (let child of childElements) {
                    let elementType = $(child).attr('data-name')
                    let contentType = $(child).attr('data-type')
                    let elementContent = getElementContent(child, contentType)
                    content.push({
                        type: elementType,
                        content: elementContent
                    })
                }
                return content
            } else {
                let childElements = $('> .block-content > div[data-name]', section)
                for (let child of childElements) {
                    let elementType = $(child).attr('data-name')
                    let contentType = $(child).attr('data-type')
                    let elementContent = getElementContent(child, contentType)
                    content.push({
                        type: elementType,
                        content: elementContent
                    })
                }
                return content
            }
        }
        function getElementContent(element, type) {
            switch (type) {
                case 'string':
                    return getStringContent(element)
                case 'text':
                    return getTextContent(element)
                case 'video':
                    return getVideoContent(element)
                case 'button':
                    return getButtonContent(element)
                case 'image':
                    return getImageContent(element)
                default: //case 'array'
                    return getArrayContent(element)
            }
        }
        function getStringContent(element) {
            return escape($('input', element).val())
        }
        function getTextContent(element) {
            return escape($('textarea', element).val())
        }
        function getVideoContent(element) {
            let videoID = $('input', element).val()
            return {
                videoId: videoID
            }
        }
        function getButtonContent(element) {
            let buttonText = $('input', element).val()
            let buttonAction = $('select', element).val()
            return {
                title: escape(buttonText),
                action: buttonAction
            }
        }
        function getImageContent(element) {
            let uploadNew = $('.upload-new', element).val()
            if (uploadNew != '') return $('.upload-new', element).val()
            return $('.upload-old', element).val()
        }
        function getArrayContent(element) {
            let rows = $('.items', element)
            let result = []
            for (let row of rows) {
                let rowChildren = $('> .row > div[data-name]', row)
                let resRow = {}
                for (let child of rowChildren) {
                    let elementType = $(child).attr('data-name')
                    let contentType = $(child).attr('data-type')
                    resRow[elementType] = getElementContent(child, contentType)
                }
                result.push(resRow)
            }
            return result
        }

        // endregion
    </script>
    <script>
        // region Load Saved Page
        <?php
        /**
         * @var array $page
         */
        ?>
        const oldInfo = JSON.parse('<?php echo $page->content ?>')
        if (oldInfo.length > 0) {
            for (let sectionInfo of oldInfo) {
                let sectionType = sectionInfo['type']
                let sectionContent = sectionInfo['content']
                let sectionTemplateType = blockList['sections'][sectionType]['type'];
                let sectionTemplate = blockList['sections'][sectionType]['content'];
                let section = Section.addSection(sectionType)

                if (sectionTemplateType === 'setContent') {
                    let elementsDom = $('> .block-content', section).children()
                    for (let elementDom of elementsDom) {
                        let elementName = $(elementDom).attr('data-name')
                        let elementType = $(elementDom).attr('data-type')
                        let elementContent = sectionContent.find(obj => obj.type === elementName)['content']
                        fillElementType(elementType, elementDom, elementContent)
                    }
                } else {
                    for (let elementInfo of sectionContent) {
                        let elementType = elementInfo.type
                        let elementContent = elementInfo['content']
                        let element = Section.appendBlock(elementType, $('.section-blocks', section).first())
                        let elementContentType = blockList['contents'][elementInfo.type]['type']
                        fillElementType(elementContentType, element, elementContent)
                    }
                }
            }
        }
        function fillElementType(type, element, value) {
            switch (type) {
                case 'string':
                    return fillStringContent(element, value)
                case 'text':
                    return fillTextContent(element, value)
                case 'video':
                    return fillVideoContent(element, value)
                case 'button':
                    return fillButtonContent(element, value)
                case 'image':
                    return fillImageContent(element, value)
                default: //case 'array'
                    return fillArrayContent(element, value)
            }
        }
        function fillStringContent(element, value) {
            $('input', element).val(unescape(value))
        }
        function fillTextContent(element, value) {
            $('textarea', element).val(unescape(value))
        }
        function fillVideoContent(element, value) {
            $('input', element).val(value['videoId'])
        }
        function fillButtonContent(element, value) {
            $('input', element).val(unescape(value['title']))
            $('select', element).val(value['action'])
        }
        function fillImageContent(element, value) {
            $('.upload-old').val(value)
            let image
            let imageName = value.split('/').at(-1);
            toDataUrl(value,function(x) {
                image = x;
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(new File([image], imageName));
                element.querySelector('input[type="file"]').files = dataTransfer.files
            })
        }
        function fillArrayContent(element, value) {
            for (let rowData of value) {
                let repeater = $('.repeater', element).first()
                $('> .repeater-heading > button', repeater).click()
                let rowDOM = $('> .items:last-child', repeater)
                let formatElements = $('> .row > div[data-name]', rowDOM)
                for (let currentElement of formatElements) {
                    let dataName = $(currentElement).attr('data-name')
                    let dataType = $(currentElement).attr('data-type')
                    let elementContent = rowData[dataName]
                    fillElementType(dataType, currentElement, elementContent)
                }
            }
        }
        function toDataUrl(imagePath, callback) {
            var xhr = new XMLHttpRequest();
            xhr.onload = function() {
                callback(xhr.response);
            };
            xhr.open('GET', '{{ url('') }}' + imagePath);
            xhr.responseType = 'blob';
            xhr.send();
        }
        // endregion
    </script>
@endsection
