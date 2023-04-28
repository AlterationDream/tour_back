@if(count($tours) > 0)
    @foreach($tours as $tour)
        <div class="col-sm-6 col-xl-4">
            <a class="block shadow-none border-start border-5 <?php
            if($tour->active) {
                echo 'border-primary';
            } else { echo 'border-danger';
            } ?>
                              bg-image rounded-12 overflow-hidden ratio ratio-16x9 mb-0"
               style="background-image: url('{{ $tour->image }}');"
               href="{{ route('tours.edit', ['id' => $tour->id]) }}">
                <div class="block-content block-content-full bg-black-50 h-100">
                    <h3 class="h4 text-white fw-bold mb-1">
                        {{ $tour->name }}
                    </h3>
                    @if($tour->length)
                        <h4 class="text-white-75 fw-medium fs-sm">
                                <span class="me-2">
                                    <i class="fa fa-shoe-prints opacity-75 me-1"></i> {{ $tour->length }}
                                </span>
                        </h4>
                    @endif
                </div>
            </a>
        </div>
    @endforeach
    {{ $tours->links() }}
@else
    <h1 class="mt-3 text-center">Туров не найдено.</h1>
@endif
