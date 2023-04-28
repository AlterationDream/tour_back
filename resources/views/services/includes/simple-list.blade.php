<thead>
<tr>
    <th style="width: 30px"></th>
    <th>Название</th>
    @if($modalName == 'CurrencyModal')
    <th>Короткое название</th>
    @endif
    <th class="text-center" style="width: 100px;">Действия</th>
</tr>
</thead>
<tbody>
@php
$count = 0;
$listings = $listings->sortBy('name');
@endphp
@if(count($listings) > 0)
    @foreach($listings as $listing)
        <tr>
            <td class="text-center">
                {{ ++$count }}
            </td>
            <td class="fw-semibold">{{ $listing->name }}</td>
            @if($modalName == 'CurrencyModal')
            <td>{{ $listing->short_name }}</td>
            @endif
            <td class="text-center">
                <!--<editor-fold desc="Action Buttons">-->
                <span data-bs-toggle="tooltip" aria-label="Редактировать" data-bs-original-title="Редактировать">
                    <button type="button" class="btn btn-sm btn-secondary me-2"
                            data-bs-toggle="modal" data-bs-target="#modal"
                            onclick="event.preventDefault(); modal = new {{ $modalName }}({{ $listing->id }}, '{{ $listing->name }}'<?php if ($modalName == 'CurrencyModal'): echo ', \''.$listing->short_name.'\''; endif;?>)"
                    >
                        <i class="fa fa-pencil-alt"></i>
                    </button>
                </span>
                <span data-bs-toggle="tooltip" aria-label="Удалить" data-bs-original-title="Удалить">
                    <button type="button" class="btn btn-sm btn-secondary"
                            data-bs-toggle="modal" data-bs-target="#modal-delete"
                            onclick="event.preventDefault(); setDeleteModal('{{ $modalName }}', {{ $listing->id }}, '{{ $deleteName }}');"
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
                    onclick="event.preventDefault(); modal = new {{ $modalName }}()"
                    data-bs-toggle="modal" data-bs-target="#modal">
                Добавить {{ $newName }}
            </button>
        </td>
    </tr>
</tbody>
