<main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">Đơn hàng mới <span>| {{ $ordersCount['type'] }}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $ordersCount['curCount'] }}</h6>
                      @php
                      $classColor = 'text-danger';
                      @endphp
                      @if ($ordersCount['prevCount'] === 0)
                        @php
                        $classColor = 'text-success';
                        @endphp
                      @endif
                      @if ($ordersCount['prevCount'] < $ordersCount['curCount'])
                      @php
                        $classColor = 'text-success';
                      @endphp
                      @endif
                      @if ($ordersCount['prevCount'] === 0)
                      <span class="{{ $classColor }} small pt-1 fw-bold">
                        100 %
                      </span> 
                      @else
                      <span class="{{ $classColor }} small pt-1 fw-bold">
                        {{ number_format(($ordersCount['curCount'] / $ordersCount['prevCount'] - 1 ) * 100, 2) }}
                        %
                      </span> 
                      @endif
                      @if ($classColor === 'text-success')
                      <span class="text-muted small pt-2 ps-1">Tăng</span>
                      @else
                      <span class="text-muted small pt-2 ps-1">Giảm</span>
                      @endif
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">Doanh thu <span>| {{ $revenue['type'] }}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ number_format($revenue['curTotal']) }} vnđ</h6>
                      @php
                      $classColor = 'text-danger';
                      @endphp
                      @if ($revenue['prevTotal'] === 0)
                        @php
                        $classColor = 'text-success';
                        @endphp
                      @endif
                      @if ($revenue['prevTotal'] < $revenue['curTotal'])
                      @php
                        $classColor = 'text-success';
                      @endphp
                      @endif
                      @if ($revenue['prevTotal'] === 0)
                      <span class="{{ $classColor }} small pt-1 fw-bold">
                        100 %
                      </span> 
                      @else
                      <span class="{{ $classColor }} small pt-1 fw-bold">
                        {{ number_format(($revenue['curTotal'] / $revenue['prevTotal'] - 1 ) * 100, 2) }}
                        %
                      </span>
                      @endif
                      @if ($classColor === 'text-success')
                      <span class="text-muted small pt-2 ps-1">Tăng</span>
                      @else
                      <span class="text-muted small pt-2 ps-1">Giảm</span>
                      @endif
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">Khách hàng <span>| {{ $customersCount['type'] }}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $customersCount['curCount'] }}</h6>
                      @php
                      $classColor = 'text-danger';
                      @endphp
                      @if ($customersCount['prevCount'] === 0)
                        @php
                        $classColor = 'text-success';
                        @endphp
                      @endif
                      @if ($customersCount['prevCount'] < $customersCount['curCount'])
                      @php
                        $classColor = 'text-success';
                      @endphp
                      @endif
                      @if ($customersCount['prevCount'] === 0)
                      <span class="{{ $classColor }} small pt-1 fw-bold">
                        100 %
                      </span> 
                      @else
                      <span class="{{ $classColor }} small pt-1 fw-bold">
                        {{ number_format(($customersCount['curCount'] / $customersCount['prevCount'] - 1 ) * 100, 2) }}
                        %
                      </span>
                      @endif
                      @if ($classColor === 'text-success')
                      <span class="text-muted small pt-2 ps-1">Tăng</span>
                      @else
                      <span class="text-muted small pt-2 ps-1">Giảm</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Hôm nay</a></li>
                    <li><a class="dropdown-item" href="#">Tháng này</a></li>
                    <li><a class="dropdown-item" href="#">Năm nay</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">Báo cáo <span>/Năm nay</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      let countCustomersByMonth = "{{ $countCustomersByMonth }}"
                      let countOrdersByMonth = "{{ $countOrdersByMonth }}"
                      let totalRevenueByMonth = "{{ $totalRevenueByMonth }}"
                      countCustomersByMonth = countCustomersByMonth.split(",")
                      countOrdersByMonth = countOrdersByMonth.split(",")
                      totalRevenueByMonth = totalRevenueByMonth.split(",")
                      countCustomersByMonth = countCustomersByMonth.map(item => parseInt(item))
                      countOrdersByMonth = countOrdersByMonth.map(item => parseInt(item))
                      totalRevenueByMonth = totalRevenueByMonth.map(item => parseInt(item))
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Doanh thu',
                          type: 'column',
                          data: totalRevenueByMonth,
                        }, {
                          name: 'Đơn hàng thành công',
                          type: 'line',
                          data: countOrdersByMonth,
                        }, {
                          name: 'Khách hàng',
                          type: 'line',
                          data: countCustomersByMonth
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                          fontFamily: 'Times New Roman, Arial, sans-serif'
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#2eca6a','#4154f1', '#ff771d'],
                        fill: {
                          type: ['gradient', 'solid', 'solid'],
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.8,
                            opacityTo: 1,
                            stops: [0, 90, 100],
                            colorStops: []
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          title: {
                            text: 'Tháng',
                            style: {
                              fontSize: '16px',
                            }
                          },
                          categories: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                          labels: {
                            style: {
                              fontSize: '16px',
                              fontWeight: 600,
                            }
                          },
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        },
                        yaxis: [{
                          title: {
                            text: 'Doanh thu',
                            style: {
                              color: '#07551D',
                              fontSize: '14px',
                            }
                          },
                          axisBorder: {
                            show: true,
                            color: '#07551D',
                          },
                          labels: {
                            style: {
                              colors: '#07551D',
                              fontSize: '14px',
                              fontWeight: 500,
                            }
                          },
                        }, {
                          opposite: true,
                          title: {
                            text: 'Đơn hàng thành công',
                            style: {
                              color: '#0E4599',
                              fontSize: '14px',
                            }
                          },
                          axisBorder: {
                            show: true,
                            color: '#0E4599'
                          },
                          labels: {
                            style: {
                              colors: '#0E4599',
                              fontSize: '15px',
                              fontWeight: 500,
                            }
                          },
                        },
                        {
                          opposite: true,
                          title: {
                            text: 'Khách hàng',
                            style: {
                              color: '#9C3A06',
                              fontSize: '14px',
                            }
                          },
                          axisBorder: {
                            show: true,
                            color: '#9C3A06'
                          },
                          labels: {
                            style: {
                              colors: '#9C3A06',
                              fontSize: '15px',
                              fontWeight: 500,
                            }
                          },
                        } 
                      ]
                      }).render();
                    });
                  </script> 
                  <!-- End Line Chart -->

                </div>

              </div>
            </div>
            <!-- End Reports -->

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales">

                <div class="filter">
                  <a class="nav-link" href="#" data-bs-toggle="dropdown">Xem tất cả</a>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Đơn hàng mới nhất <span>| {{ $typeOrders }}</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Phương thức thanh toán</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Trạng thái</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($orders as $key => $order)
                      @php
                      $orderItem = $order->toArray();
                      @endphp
                      <tr>
                        <th scope="row"><a href="#">#{{ $orderItem['id'] }}</a></th>
                        <td>{{ $orderItem['customer']['fullname'] }}</td>
                        <td><a href="#" class="text-primary">{{ $orderItem['payment']['payment_name'] }}</a></td>
                        @php
                        $total = 0
                        @endphp
                        @foreach($orderItem['orderdetails'] as $detail)
                          @php
                            $total += $detail['quantity'] * $detail['unit_price'] - $detail['discount_amount']  
                          @endphp
                        @endforeach
                        <td>{{ number_format($total) }}</td>
                        @if ($orderItem['order_status'] === 1)
                        <td><span class="badge bg-primary">Đang xử lý</span></td>
                        @elseif ($orderItem['order_status'] === 2)
                        <td><span class="badge bg-danger">Đã hủy</span></td>
                        @elseif ($orderItem['order_status'] === 3)
                        <td><span class="badge bg-info">Đang vận chuyển</span></td>
                        @else
                        <td><span class="badge bg-success">Đã giao</span></td>
                        @endif
                      </tr>
                      @endforeach
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

            <!-- Top Selling -->
            <div class="col-12">
              <div class="card top-selling">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body pb-0">
                  <h5 class="card-title">Top bán chạy <span>| {{ $typeTopSells }}</span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Loại</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng bán</th>
                        <th scope="col">Doanh thu</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($topSells as $key => $top)
                      <tr>
                        <th scope="row"><a href="#"><img src="{{ $top['image'] ? asset('public/storage/uploads/products/'. $top['image']) : asset('storage/uploads/no-image.jpg') }}" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">{{ $top['product_name'] }}</a></td>
                        <td>{{ $top['option'] }}</td>
                        <td>{{ number_format($top['unit_price']) }}</td>
                        <td class="fw-bold">{{ $top['quantity'] }}</td>
                        <td>{{ number_format($top['total']) }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <!-- <div class="col-lg-4"> -->

          <!-- Recent Activity -->
          <!-- <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Recent Activity <span>| Today</span></h5>

              <div class="activity">

                <div class="activity-item d-flex">
                  <div class="activite-label">32 min</div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                  </div>
                </div> -->
                <!-- End activity item-->

                <!-- <div class="activity-item d-flex">
                  <div class="activite-label">56 min</div>
                  <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                  <div class="activity-content">
                    Voluptatem blanditiis blanditiis eveniet
                  </div>
                </div> -->
                <!-- End activity item-->

                <!-- <div class="activity-item d-flex">
                  <div class="activite-label">2 hrs</div>
                  <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                  <div class="activity-content">
                    Voluptates corrupti molestias voluptatem
                  </div>
                </div> -->
                <!-- End activity item-->

                <!-- <div class="activity-item d-flex">
                  <div class="activite-label">1 day</div>
                  <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                  <div class="activity-content">
                    Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                  </div>
                </div> -->
                <!-- End activity item-->

                <!-- <div class="activity-item d-flex">
                  <div class="activite-label">2 days</div>
                  <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                  <div class="activity-content">
                    Est sit eum reiciendis exercitationem
                  </div>
                </div> -->
                <!-- End activity item-->

                <!-- <div class="activity-item d-flex">
                  <div class="activite-label">4 weeks</div>
                  <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                  <div class="activity-content">
                    Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                  </div>
                </div> -->
                <!-- End activity item-->

              <!-- </div>

            </div>
          </div> -->
          <!-- End Recent Activity -->

          <!-- Budget Report -->
          <!-- <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Budget Report <span>| This Month</span></h5>

              <div id="budgetChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  var budgetChart = echarts.init(document.querySelector("#budgetChart")).setOption({
                    legend: {
                      data: ['Allocated Budget', 'Actual Spending']
                    },
                    radar: {
                      // shape: 'circle',
                      indicator: [{
                          name: 'Sales',
                          max: 6500
                        },
                        {
                          name: 'Administration',
                          max: 16000
                        },
                        {
                          name: 'Information Technology',
                          max: 30000
                        },
                        {
                          name: 'Customer Support',
                          max: 38000
                        },
                        {
                          name: 'Development',
                          max: 52000
                        },
                        {
                          name: 'Marketing',
                          max: 25000
                        }
                      ]
                    },
                    series: [{
                      name: 'Budget vs spending',
                      type: 'radar',
                      data: [{
                          value: [4200, 3000, 20000, 35000, 50000, 18000],
                          name: 'Allocated Budget'
                        },
                        {
                          value: [5000, 14000, 28000, 26000, 42000, 21000],
                          name: 'Actual Spending'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div> -->
          <!-- End Budget Report -->

          <!-- Website Traffic -->
          <!-- <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Website Traffic <span>| Today</span></h5>

              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      top: '5%',
                      left: 'center'
                    },
                    series: [{
                      name: 'Access From',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                      data: [{
                          value: 1048,
                          name: 'Search Engine'
                        },
                        {
                          value: 735,
                          name: 'Direct'
                        },
                        {
                          value: 580,
                          name: 'Email'
                        },
                        {
                          value: 484,
                          name: 'Union Ads'
                        },
                        {
                          value: 300,
                          name: 'Video Ads'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div> -->
          <!-- End Website Traffic -->

          <!-- News & Updates Traffic -->
          <!-- <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">News &amp; Updates <span>| Today</span></h5>

              <div class="news">
                <div class="post-item clearfix">
                  <img src="{{ asset('assets/img/news-1.jpg') }}" alt="">
                  <h4><a href="#">Nihil blanditiis at in nihil autem</a></h4>
                  <p>Sit recusandae non aspernatur laboriosam. Quia enim eligendi sed ut harum...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="{{ asset('assets/img/news-2.jpg') }}" alt="">
                  <h4><a href="#">Quidem autem et impedit</a></h4>
                  <p>Illo nemo neque maiores vitae officiis cum eum turos elan dries werona nande...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="{{ asset('assets/img/news-3.jpg') }}" alt="">
                  <h4><a href="#">Id quia et et ut maxime similique occaecati ut</a></h4>
                  <p>Fugiat voluptas vero eaque accusantium eos. Consequuntur sed ipsam et totam...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="{{ asset('assets/img/news-4.jpg') }}" alt="">
                  <h4><a href="#">Laborum corporis quo dara net para</a></h4>
                  <p>Qui enim quia optio. Eligendi aut asperiores enim repellendusvel rerum cuder...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="{{ asset('assets/img/news-5.jpg') }}" alt="">
                  <h4><a href="#">Et dolores corrupti quae illo quod dolor</a></h4>
                  <p>Odit ut eveniet modi reiciendis. Atque cupiditate libero beatae dignissimos eius...</p>
                </div>

              </div> -->
              <!-- End sidebar recent posts-->

            <!-- </div>
          </div> -->
          <!-- End News & Updates -->

        <!-- </div> -->
        <!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->