<thead>
<tr>
    <th style="width: 30px"></th>
    <th>Название</th>
    <th style="width: 15%;">Статус</th>
    <th class="text-center" style="width: 100px;">Действия</th>
</tr>
</thead>
@if(count($places) > 0)
@php
    $countries = $places->where('parent_id', 0)->sortBy('name');
@endphp
@foreach($countries as $country)
    <tbody class="js-table-sections-header">
        <tr>
            <td class="text-center">
                <i class="fa fa-angle-right"></i>
            </td>
            <td class="fw-semibold">{{ $country->name }}</td>
            <td>
                <span class="badge @if($country->active) bg-success @else bg-danger @endif ">@if($country->active) Активна @else Не активна @endif </span>
            </td>
            <td class="text-center">
                <!--<editor-fold desc="Action Buttons">-->
                <span data-bs-toggle="tooltip" aria-label="Редактировать" data-bs-original-title="Редактировать">
                    <button type="button" class="btn btn-sm btn-secondary me-2"
                            data-bs-toggle="modal" data-bs-target="#modal"
                            onclick="event.preventDefault(); modal = new PlaceModal({{ $country->parent_id }}, {{ $country->id }}, '{{ $country->name }}', {{ $country->active }})"
                    >
                        <i class="fa fa-pencil-alt"></i>
                    </button>
                </span>
                <span data-bs-toggle="tooltip" aria-label="Удалить" data-bs-original-title="Удалить">
                    <button type="button" class="btn btn-sm btn-secondary"
                            data-bs-toggle="modal" data-bs-target="#modal-delete"
                            onclick="event.preventDefault(); setDeleteModal({{ $country->id }}, 'эту страну');"
                    >

                        <i class="fa fa-times ps-1 pe-1"></i>
                    </button>
                </span>
                <!--</editor-fold>-->
            </td>
        </tr>
    </tbody>

    @php
        $subcities = $places->where('parent_id', $country->id)->sortBy('name');
    @endphp
    <tbody>
    @if(count($subcities) > 0)
        @foreach($subcities as $subcity)
            <tr>
                <td></td>
                <td class="fw-semibold">{{ $subcity->name }}</td>
                <td>
                    <span class="badge @if($subcity->active) bg-success @else bg-danger @endif ">@if($subcity->active) Активен @else Не активен @endif </span>
                </td>
                <td class="text-center">
                    <!--<editor-fold desc="Action Buttons">-->
                    <span data-bs-toggle="tooltip" aria-label="Редактировать" data-bs-original-title="Редактировать">
                        <button type="button" class="btn btn-sm btn-secondary me-2"
                                data-bs-toggle="modal" data-bs-target="#modal"
                                onclick="event.preventDefault(); modal = new PlaceModal({{ $subcity->parent_id }}, {{ $subcity->id }}, '{{ $subcity->name }}', {{ $subcity->active }})"
                        >
                            <i class="fa fa-pencil-alt"></i>
                        </button>
                    </span>
                    <span data-bs-toggle="tooltip" aria-label="Удалить" data-bs-original-title="Удалить">
                        <button type="button" class="btn btn-sm btn-secondary"
                                data-bs-toggle="modal" data-bs-target="#modal-delete"
                                onclick="event.preventDefault(); setDeleteModal('PlaceModal', {{ $subcity->id }}, 'этот город');"
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
            <td colspan="4" style="text-align: start">
                <button class="btn btn-primary btn-sm ms-2" style="margin-left: 12px"
                        onclick="event.preventDefault(); modal = new PlaceModal({{ $country->id }})"
                        data-bs-toggle="modal" data-bs-target="#modal">
                    Добавить новый город
                </button>
            </td>
        </tr>
    </tbody>
@endforeach
    <tr>
        <td colspan="4" style="text-align: start">
            <button class="btn btn-primary btn-sm ms-2" style="margin-left: 12px"
                    onclick="event.preventDefault(); modal = new PlaceModal(0)"
                    data-bs-toggle="modal" data-bs-target="#modal">
                Добавить новую страну
            </button>
        </td>
    </tr>
@else
    <tr>
        <td colspan="4" style="text-align: start">
            <p class="mb-2">Ни одной страны не найдено.</p>
            <button class="btn btn-primary btn-sm ms-2" style="margin-left: 12px"
                    onclick="event.preventDefault(); modal = new PlaceModal(0)"
                    data-bs-toggle="modal" data-bs-target="#place-modal">
                Добавить новую страну
            </button>
        </td>
    </tr>
@endif
