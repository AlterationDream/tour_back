@extends('layouts.backend')

@section('title')
    Туры
@endsection

@section('css_after')
    <!--<editor-fold desc="Styles">-->
    <style>
        .nav-pills .nav-link {
            border-width: 1px;
            border-style: solid;
            border-color: #f2f2f2;
        }

        .nav-pills .nav-link.active {
            border-color: #0080de;
        }

        .rounded-12 {
            border-radius: 12px;
        }

        .search-form {
            max-width: 345px;
            margin: 12px auto 0 !important;
        }

        .pagination {
            justify-content: center;
        }
    </style>
    <!--</editor-fold>-->
@endsection

@section('content')
    <div class="content">
        <!--<editor-fold desc="Tours Header">-->
        <div class="mb-4 text-center">
            <h2 class="fw-bold mb-2">
                Туры
            </h2>
            <h3 class="fs-base fw-medium text-muted mb-0">
                Сейчас у Вас {{ count($tours) }} {{ Lang::choice('тур|тура|туров', count($tours)) }}.
            </h3>
            <button class="btn btn-primary mt-3" onclick="location.href='{{ route('tours.create') }}'">
                <i class="fa fa-plus opacity-50 me-1"></i>Добавить
            </button>
        </div>
        <!--</editor-fold>-->
        <div class="px-4 py-3 bg-body-extra-light rounded push">
            <!--<editor-fold desc="Nav Pills (Categories)">-->
            <ul class="nav nav-pills justify-content-center space-x-1">
                <li class="nav-item">
                    <a class="nav-link active category-switch" href="javascript:void(0)" data-category="">
                        <i class="fa fa-fw fa-th-large opacity-50 me-1"></i> Все
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link category-switch" href="javascript:void(0)" data-category="sochi">
                        Сочи
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link category-switch" href="javascript:void(0)" data-category="abhazia">
                        Абхазия
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link category-switch" href="javascript:void(0)" data-category="vip">
                        VIP
                    </a>
                </li>
            </ul>
            <!--</editor-fold>-->
            <!--<editor-fold desc="Search">-->
            <form class="push search-form" action="/tours/search" method="POST" role="search">
                {{ csrf_field() }}
                <div class="input-group input-group-lg">
                    <input type="text" class="form-control" id="search" placeholder="Поиск по турам.." autocomplete="off">
                </div>
            </form>
            <!--</editor-fold>-->
        </div>
        <!--<editor-fold desc="Tour List">-->
        <div class="row items-push tour-list">
            @include('tours.tiles')
        </div>

        <input type="hidden" name="page" value="1" autocomplete="off">
        <input type="hidden" name="category" value="" autocomplete="off">
        <!--</editor-fold>-->
    </div>
@endsection

@section('js_after')
    <script>
        // region Search Tours
        function searchTours() {
            let page = $('input[name="page"]').val();
            let query = $('#search').val();
            let category = $('input[name="category"]').val();

            $.ajax({
                url:"/tours/search?page="+page+"&query="+query+"&category="+category,
                success:function(tours)
                {
                    $('.tour-list').html('')
                    $('.tour-list').html(tours)
                }
            })
        }
        // endregion
        // region Search, Category click and Pagination click Events
        $(document).on('keyup', '#search', searchTours);
        $(document).on('click', '.category-switch', function () {
            let category = $(this).attr('data-category')
            if ($('input[name="category"]').val() == category) return false
            $('input[name="category"]').val(category)

            $('.category-switch').removeClass('active')
            $(this).addClass('active')

            searchTours()
        })
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();

            let page = $(this).attr('href').split('page=')[1]
            if ($('input[name="page"]').val() == page) return false
            $('input[name="page"]').val(page)

            $('.pagination li').removeClass('active')
            $(this).parent().addClass('active')

            searchTours()
        });
        // endregion
    </script>
@endsection
