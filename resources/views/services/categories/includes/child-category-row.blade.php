@if($top)
<tbody class="js-table-sections-header">
@endif
    <tr>
        <td class="text-center">
            @if($top) <i class="fa fa-angle-right"></i> @endif
        </td>
        <td class="fw-semibold">{{ $category->name }}</td>
        <td>
            <!--<editor-fold desc="Category Image">-->
            <a href="javascript:void(0)" data-bs-toggle="popover" data-bs-html="true" data-bs-placement="bottom"
               data-bs-content="<div class='text-center'><img class='img-category' src='{{ $category->image }}'></div>"
               data-bs-original-title="Изображение" data-bs-trigger="hover">
                Наведите, чтобы показать
            </a>
            <!--</editor-fold>-->
        </td>
        <td>
            <span class="badge @if($category->active) bg-success @else bg-danger @endif ">@if($category->active) Активна @else Не активна @endif </span>
        </td>
        <td class="text-center">
            <!--<editor-fold desc="Action Buttons">-->
                <span data-bs-toggle="tooltip" aria-label="Редактировать" data-bs-original-title="Редактировать">
                    <button type="button" class="btn btn-sm btn-secondary me-2"
                            data-bs-toggle="modal" data-bs-target="#category-modal"
                            onclick="event.preventDefault(); categoryModal = new ChildrenModal({{ $category->parent_id }}, {{ $category->id }})"
                    >
                        <i class="fa fa-pencil-alt"></i>
                    </button>
                </span>
                <span data-bs-toggle="tooltip" aria-label="Удалить" data-bs-original-title="Удалить">
                    <button type="button" class="btn btn-sm btn-secondary"
                            data-bs-toggle="modal" data-bs-target="#modal-delete"
                            onclick="event.preventDefault(); setDeleteModal({{ $category->id }});"
                    >

                        <i class="fa fa-times ps-1 pe-1"></i>
                    </button>
                </span>
            <!--</editor-fold>-->
            <!--<editor-fold desc="Category Info Hidden">-->
            <div style="display: none" data-category-info="{{ $category->id }}">
                <input name="active" type="hidden" value="{{ $category->active }}" autocomplete="off">
                <input name="name" type="hidden" value="{{ $category->name }}" autocomplete="off">
                <input name="image" type="hidden" value="{{ $category->image }}" autocomplete="off">
                <input name="shape" type="hidden" value="{{ $category->shape }}" autocomplete="off">
                <input name="after" type="hidden" value="{{ $category->order - 1 }}" autocomplete="off">
            </div>
            <!--</editor-fold>-->
        </td>
    </tr>
@if($top) </tbody> @endif
