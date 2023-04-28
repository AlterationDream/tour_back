@if(count($parentCategories) > 0)
    @foreach($parentCategories as $category)
        <li class="nav-item">
            <a class="nav-link category-switch @if ($loop->first) active @endif" href="javascript:void(0)"
               data-category="{{ $category->id }}" data-category-after="{{ $category->order - 1 }}" onclick="event.preventDefault(); parentCategoriesArea.setActiveCategory({{ $category->id }})">
                {{ $category->name }}
            </a>
        </li>
    @endforeach
    <li class="nav-item">
        <button class="btn btn-primary ms-2" style="margin-left: 12px"
                onclick="categoryModal = new ParentModal()"
                data-bs-toggle="modal" data-bs-target="#category-modal">
            <i class="fa fa-plus"></i>
        </button>
    </li>
    <li class="nav-item">
        <button class="btn btn-primary ms-2" style="margin-left: 12px"
                onclick="parentCategoriesArea.enterEdit()">
            <i class="fa fa-pencil"></i>
        </button>
    </li>
@else
    <li class="nav-item">
        <h4 class="mb-0 mt-2">Нет родительских категорий</h4>
    </li>
    <li class="nav-item">
        <button class="btn btn-primary ms-2" style="margin-left: 12px"
                onclick="categoryModal = new ParentModal()"
                data-bs-toggle="modal" data-bs-target="#category-modal">
            <i class="fa fa-plus me-1"></i>
        </button>
    </li>
@endif
<script>
    if (typeof parentCategoriesArea !== 'undefined') {
        parentCategoriesArea.categoriesRendered = true;
    }
</script>
