<?php
/**
 * @var $services
 */
?>
@if(count($services) > 0)
    @foreach($services as $service)
        @php
            /**
              * @var $service
              */
            $images = explode(', ', $service->images);
        @endphp
        <div class="col-sm-6 col-xl-4">
            <a class="block shadow-none border-start border-5 <?php
            if($service->active) {
                echo 'border-primary';
            } else { echo 'border-danger';
            } ?>
                              bg-image rounded-12 overflow-hidden ratio ratio-16x9 mb-0"
               style="background-image: url('{{ $images[0] }}');"
               href="{{ route('services.edit', ['id' => $service->id]) }}">
                <div class="block-content block-content-full bg-black-50 h-100">
                    <h3 class="h4 text-white fw-bold mb-1">
                        {{ $service->name }}
                    </h3>
                </div>
            </a>
        </div>
    @endforeach
    {{ $services->links() }}
@else
    <h2 class="mt-8 text-center">Услуг не найдено.</h2>
@endif
