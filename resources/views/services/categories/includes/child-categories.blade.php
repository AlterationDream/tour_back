<thead>
<tr>
    <th style="width: 30px"></th>
    <th>Название</th>
    <th style="width: 30%;">Изображение</th>
    <th style="width: 15%;">Статус</th>
    <th class="text-center" style="width: 100px;">Действия</th>
</tr>
</thead>

@if(count($childCategories) > 0)
    @php $idList = $childCategories->pluck('id')->toArray();
    $subCategories = $childCategories->whereIn('parent_id', $idList);

    if (count($subCategories) > 0) {
        $idList = $subCategories->pluck('id')->toArray();
        $topCategories = $childCategories->filter(function ($value, $key) use ($idList) {
            return !(in_array($value->id, $idList));
        });
        $topCategories = $topCategories->sortBy('order');
    } else {
        $topCategories = $childCategories->sortBy('order');;
    } @endphp

    @foreach($topCategories as $category)
        @include('services.categories.includes.child-category-row', ['category' => $category, 'top' => true])

        @php $childCategories = $subCategories->where('parent_id', $category->id)->sortBy('order'); @endphp
        <tbody>
        @if (count($childCategories) > 0)
            @foreach($childCategories as $subCat)
                @include('services.categories.includes.child-category-row', ['category' => $subCat, 'top' => false])
            @endforeach
        @endif
            <tr>
                <td colspan="5" style="text-align: start">
                    <button class="btn btn-primary btn-sm ms-2" style="margin-left: 12px"
                            onclick="event.preventDefault(); categoryModal = new ChildrenModal({{ $category->id }})"
                            data-bs-toggle="modal" data-bs-target="#category-modal">
                        Добавить новую подкатегорию
                    </button>
                </td>
            </tr>
        </tbody>
    @endforeach
    <tr>
        <td colspan="5" style="text-align: end">
            <button class="btn btn-primary btn-sm ms-2" style="margin-left: 12px" id="new-child-category"
                    onclick="event.preventDefault(); categoryModal = new ChildrenModal()"
                    data-bs-toggle="modal" data-bs-target="#category-modal">
                Добавить новую
            </button>
        </td>
    </tr>
@else
    <tr>
        <td colspan="5" style="text-align: center">
            <p class="mb-2">Ни одной категории не найдено.</p>
            <button class="btn btn-primary btn-sm ms-2" style="margin-left: 12px" id="new-child-category"
                    onclick="event.preventDefault(); categoryModal = new ChildrenModal()"
                    data-bs-toggle="modal" data-bs-target="#category-modal">
                Добавить новую
            </button>
        </td>
    </tr>
@endif
