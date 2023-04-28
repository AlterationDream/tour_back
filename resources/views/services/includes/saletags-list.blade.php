<thead>
<tr>
    <th style="width: 30px"></th>
    <th>Название</th>
    <th>Цвет</th>
    <th class="text-center" style="width: 100px;">Действия</th>
</tr>
</thead>
<tbody>
@php
    $count = 0;
    $saleTags = $saleTags->sortBy('name');
@endphp
@if(count($saleTags) > 0)
    @foreach($saleTags as $saleTag)
        <tr>
            <td class="text-center">
                {{ ++$count }}
            </td>
            <td class="fw-semibold">{{ $saleTag->name }}</td>
            <td><div style="width: 64px; height: 24px; background-color: {{ $saleTag->color }}"></div></td>
            <td class="text-center">
                <!--<editor-fold desc="Action Buttons">-->
                <span data-bs-toggle="tooltip" aria-label="Редактировать" data-bs-original-title="Редактировать">
                    <button type="button" class="btn btn-sm btn-secondary me-2"
                            data-bs-toggle="modal" data-bs-target="#modal"
                            onclick="event.preventDefault(); modal = new SaleTagModal({{ $saleTag->id }}, '{{ $saleTag->name }}', '{{ $saleTag->color }}')"
                    >
                        <i class="fa fa-pencil-alt"></i>
                    </button>
                </span>
                <span data-bs-toggle="tooltip" aria-label="Удалить" data-bs-original-title="Удалить">
                    <button type="button" class="btn btn-sm btn-secondary"
                            data-bs-toggle="modal" data-bs-target="#modal-delete"
                            onclick="event.preventDefault(); setDeleteModal('SaleTagModal', {{ $saleTag->id }}, 'эту метку распродажи');"
                    >
                        <i class="fa fa-times ps-1 pe-1"></i>
                    </button>
                </span>
                <!--</editor-fold>-->
            </td>
        </tr>
    @endforeach
@endif
<tr>
    <td colspan="5" style="text-align: start">
        <button class="btn btn-primary btn-sm ms-2" style="margin-left: 12px"
                onclick="event.preventDefault(); modal = new SaleTagModal()"
                data-bs-toggle="modal" data-bs-target="#modal">
            Добавить новую метку распродажи
        </button>
    </td>
</tr>
</tbody>
