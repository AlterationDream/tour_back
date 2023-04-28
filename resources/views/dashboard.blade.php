@extends('layouts.backend')

@section('title')
    Админ-панель
@endsection

@section('css_after')
    <style>
        .margin-right {
            margin-right: 16px;
        }
        /*.min-height {
            min-height: 42px;
        }*/
        .block-title small {
            margin-left: 8px;
        }
    </style>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="row">
                <div class="col-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
                        <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
                            <div class="d-none d-sm-block margin-right">
                                <i class="fa fa-download fa-2x opacity-25"></i>
                            </div>
                            <div>
                                <div class="fs-3 fw-semibold">500</div>
                                <div class="fs-sm fw-semibold fs-4 min-height">Загрузок приложения</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
                        <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
                            <div class="d-none d-sm-block margin-right">
                                <i class="fa fa-wallet fa-2x opacity-25"></i>
                            </div>
                            <div>
                                <div class="fs-3 fw-semibold">1780</div>
                                <div class="fs-sm fw-semibold fs-4 min-height">Просмотрено товаров</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
                        <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
                            <div class="d-none d-sm-block margin-right">
                                <i class="fa fa-envelope-open fa-2x opacity-25"></i>
                            </div>
                            <div>
                                <div class="fs-3 fw-semibold">150</div>
                                <div class="fs-sm fw-semibold fs-4 min-height">Оформлено туров</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
                        <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
                            <div class="d-none d-sm-block margin-right">
                                <i class="fa fa-users fa-2x opacity-25"></i>
                            </div>
                            <div>
                                <div class="fs-3 fw-semibold">425</div>
                                <div class="fs-sm fw-semibold fs-4 min-height">Оформлено услуг</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="block block-rounded">
                        <div class="block-header">
                            <h3 class="block-title">
                                Просмотры <small>Эта неделя</small>
                            </h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                                <button type="button" class="btn-block-option">
                                    <i class="si si-wrench"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content p-1 bg-body-light">
                            <canvas id="js-chartjs-dashboard-lines" style="display: block; box-sizing: border-box; height: 232px; width: 465px;" width="465" height="232"></canvas>
                        </div>
                        <div class="block-content">
                            <div class="row items-push">
                                <div class="col-6 col-sm-4 text-center text-sm-start">
                                    <div class="fs-sm fw-semibold text-uppercase text-muted">Месяц</div>
                                    <div class="fs-4 fw-semibold">720</div>
                                    <div class="fw-semibold text-success">
                                        <i class="fa fa-caret-up"></i> +16%
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4 text-center text-sm-start">
                                    <div class="fs-sm fw-semibold text-uppercase text-muted">Неделя</div>
                                    <div class="fs-4 fw-semibold">160</div>
                                    <div class="fw-semibold text-danger">
                                        <i class="fa fa-caret-down"></i> -3%
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 text-center text-sm-start">
                                    <div class="fs-sm fw-semibold text-uppercase text-muted">В среднем</div>
                                    <div class="fs-4 fw-semibold">24.3</div>
                                    <div class="fw-semibold text-success">
                                        <i class="fa fa-caret-up"></i> +9%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="block block-rounded">
                        <div class="block-header">
                            <h3 class="block-title">
                                Оформлено заявок <small>Эта неделя</small>
                            </h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                                <button type="button" class="btn-block-option">
                                    <i class="si si-wrench"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content p-1 bg-body-light">
                            <canvas id="js-chartjs-dashboard-lines2" style="display: block; box-sizing: border-box; height: 232px; width: 465px;" width="465" height="232"></canvas>
                        </div>
                        <div class="block-content">
                            <div class="row items-push">
                                <div class="col-6 col-sm-4 text-center text-sm-start">
                                    <div class="fs-sm fw-semibold text-uppercase text-muted">Месяц</div>
                                    <div class="fs-4 fw-semibold">160</div>
                                    <div class="fw-semibold text-success">
                                        <i class="fa fa-caret-up"></i> +4%
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4 text-center text-sm-start">
                                    <div class="fs-sm fw-semibold text-uppercase text-muted">Неделя</div>
                                    <div class="fs-4 fw-semibold">42</div>
                                    <div class="fw-semibold text-danger">
                                        <i class="fa fa-caret-down"></i> -7%
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 text-center text-sm-start">
                                    <div class="fs-sm fw-semibold text-uppercase text-muted">В среднем</div>
                                    <div class="fs-4 fw-semibold">7</div>
                                    <div class="fw-semibold text-success">
                                        <i class="fa fa-caret-up"></i> +35%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection

@section('js_after')
    <script src="/js/plugins/chart.js/chart.min.js"></script>
    <script>
        Codebase.onLoad((() =>class {
            static initDashboardChartJS() {
                Chart.defaults.color = '#818d96',
                    Chart.defaults.scale.grid.color = 'transparent',
                    Chart.defaults.scale.grid.zeroLineColor = 'transparent',
                    Chart.defaults.scale.display = !1,
                    Chart.defaults.scale.beginAtZero = !0,
                    Chart.defaults.elements.line.borderWidth = 2,
                    Chart.defaults.elements.point.radius = 5,
                    Chart.defaults.elements.point.hoverRadius = 7,
                    Chart.defaults.plugins.tooltip.radius = 3,
                    Chart.defaults.plugins.legend.display = !1;
                let e,
                    a,
                    t = document.getElementById('js-chartjs-dashboard-lines'),
                    r = document.getElementById('js-chartjs-dashboard-lines2');
                null !== t && (e = new Chart(t, {
                    type: 'line',
                    data: {
                        labels: [
                            'Пн',
                            'Вт',
                            'Ср',
                            'Чт',
                            'Пт',
                            'Сб',
                            'Вс'
                        ],
                        datasets: [
                            {
                                label: 'Эта неделя',
                                fill: !0,
                                backgroundColor: 'rgba(2, 132, 199, .45)',
                                borderColor: 'rgba(2, 132, 199, 1)',
                                pointBackgroundColor: 'rgba(2, 132, 199, 1)',
                                pointBorderColor: '#fff',
                                pointHoverBackgroundColor: '#fff',
                                pointHoverBorderColor: 'rgba(2, 132, 199, 1)',
                                data: [
                                    25,
                                    21,
                                    23,
                                    38,
                                    36,
                                    35,
                                    39
                                ]
                            }
                        ]
                    },
                    options: {
                        tension: 0.4,
                        scales: {
                            y: {
                                suggestedMin: 0,
                                suggestedMax: 50
                            }
                        },
                        interaction: {
                            intersect: !1
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function (e) {
                                        return ' ' + e.parsed.y + ' Просмотров'
                                    }
                                }
                            }
                        }
                    }
                })),
                null !== r && (a = new Chart(r, {
                    type: 'line',
                    data: {
                        labels: [
                            'Пн',
                            'Вт',
                            'Ср',
                            'Чт',
                            'Пт',
                            'Сб',
                            'Вс'
                        ],
                        datasets: [
                            {
                                label: 'Эта неделя',
                                fill: !0,
                                backgroundColor: 'rgba(101, 163, 13, .45)',
                                borderColor: 'rgba(101, 163, 13, 1)',
                                pointBackgroundColor: 'rgba(101, 163, 13, 1)',
                                pointBorderColor: '#fff',
                                pointHoverBackgroundColor: '#fff',
                                pointHoverBorderColor: 'rgba(101, 163, 13, 1)',
                                data: [
                                    190,
                                    219,
                                    235,
                                    320,
                                    360,
                                    354,
                                    390
                                ]
                            }
                        ]
                    },
                    options: {
                        tension: 0.4,
                        scales: {
                            y: {
                                suggestedMin: 0,
                                suggestedMax: 480
                            }
                        },
                        interaction: {
                            intersect: !1
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function (e) {
                                        return e.parsed.y + ' Заявок'
                                    }
                                }
                            }
                        }
                    }
                }))
            }
            static init() {
                this.initDashboardChartJS()
            }
        }.init()));
    </script>
@endsection
