<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{$pageTitle}}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/tags-input-tagify/tagify.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">


  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

  @livewireStyles
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/img/logo.png') }}" alt="">
        <span class="d-none d-lg-block">TechChain</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!-- <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Tìm kiếm" title="Nhập từ khóa để tìm kiếm">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div> -->
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>
        <!-- End Search Icon-->

        <!-- <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a> -->
          <!-- End Notification Icon -->

          <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              Bạn có 4 thông báo mới
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Xem tất cả</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul> -->
          <!-- End Notification Dropdown Items -->

        <!-- </li> -->
        <!-- End Notification Nav -->

        <!-- <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a> -->
          <!-- End Messages Icon -->

          <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              Bạn có 3 tin nhắn mới
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Xem tất cả</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="{{ asset('assets/img/messages-1.jpg') }}" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="{{ asset('assets/img/messages-2.jpg') }}" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="{{ asset('assets/img/messages-3.jpg') }}" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul> -->
          <!-- End Messages Dropdown Items -->

        <!-- </li> -->
        <!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ !empty($account) ? ($account->profile_photo_path ? asset('storage/uploads/users/'.$account->profile_photo_path) : asset('assets/img/noavatar.png')) : asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ !empty($account) ? $account->username : '?username?' }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ !empty($account) ? $account->name : '?name?' }}</h6>
              <span>{{ !empty($account) ? $account->job_title : '?job_title?' }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a href="{{route('profile')}}" class="dropdown-item d-flex align-items-center">
                <i class="bi bi-person"></i>
                <span>Thông tin cá nhân</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{route('profile')}}">
                <i class="bi bi-gear"></i>
                <span>Cài đặt</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Trợ giúp</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Đăng xuất</span>
              </a>
            </li>
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
              @csrf
            </form>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    @php
    $commandsOfUserVar = [];
    @endphp
    @if (!empty($commandsOfUser))
    @php
    $commandsOfUserVar = $commandsOfUser;
    @endphp
    @endif

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="/">
          <i class="bi bi-grid"></i>
          <span>Tổng quan</span>
        </a>
      </li><!-- End Dashboard Nav -->

      @php
      $cateModule = false;
      $cateModuleId = 2;
      @endphp
      @if (array_key_exists($cateModuleId,$commandsOfUserVar))
      @php
      $cateModule = true;
      @endphp
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed {{$cateModule ? '' : 'disabled'}}" data-bs-target="#categories-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Danh mục sản phẩm</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="categories-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('categories')}}" class="categories-nav ">
              <i class="bi bi-circle"></i><span>Danh sách danh mục</span>
            </a>
          </li>
          <li>
            <a href="{{route('addcategory')}}" class="categories-add-nav">
              <i class="bi bi-circle"></i><span>Thêm mới danh mục</span>
            </a>
          </li>
        </ul>
      </li><!-- End Category Nav -->

      @php
      $supplierModule = false;
      $supplierModuleId = 3;
      @endphp
      @if (array_key_exists($supplierModuleId,$commandsOfUserVar))
      @php
      $supplierModule = true;
      @endphp
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed {{$supplierModule ? '' : 'disabled'}}" data-bs-target="#suppliers-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Nhà cung ứng</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="suppliers-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('suppliers')}}" class="suppliers-nav ">
              <i class="bi bi-circle"></i><span>Danh sách Nhà cung ứng</span>
            </a>
          </li>
          <li>
            <a href="{{route('addsupplier')}}" class="suppliers-add-nav">
              <i class="bi bi-circle"></i><span>Thêm mới Nhà cung ứng</span>
            </a>
          </li>
        </ul>
      </li><!-- End Supplier Nav -->

      @php
      $productModule = false;
      $productModuleId = 4;
      @endphp
      @if (array_key_exists($productModuleId,$commandsOfUserVar))
      @php
      $productModule = true;
      @endphp
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed {{$productModule ? '' : 'disabled'}}" data-bs-target="#products-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Sản phẩm</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="products-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('products')}}" class="products-nav ">
              <i class="bi bi-circle"></i><span>Danh sách sản phẩm</span>
            </a>
          </li>
          <li>
            <a href="{{route('addproduct')}}" class="products-add-nav">
              <i class="bi bi-circle"></i><span>Thêm mới sản phẩm</span>
            </a>
          </li>
        </ul>
      </li> <!-- End Product Nav -->

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#homeslider-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-card-image"></i><span>Quản lý Slider</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="homeslider-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="">
              <i class="bi bi-circle"></i><span>Danh sách ảnh bìa</span>
            </a>
          </li>
          <li>
            <a href="">
              <i class="bi bi-circle"></i><span>Thêm mới ảnh bìa</span>
            </a>
          </li>
        </ul>
      </li> -->
      <!-- End slider Nav -->

      @php
      $voucherModule = false;
      $voucherModuleId = 10;
      @endphp
      @if (array_key_exists($voucherModuleId,$commandsOfUserVar))
      @php
      $voucherModule = true;
      @endphp
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed {{$voucherModule ? '' : 'disabled'}}" data-bs-target="#vouchers-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-percent"></i></i><span>Mã giảm giá</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="vouchers-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('vouchers')}}" class="vouchers-nav ">
              <i class="bi bi-circle"></i><span>Danh sách mã giảm giá</span>
            </a>
          </li>
        </ul>
      </li> <!-- End Admin Nav -->

      @php
      $orderModule = false;
      $orderModuleId = 5;
      @endphp
      @if (array_key_exists($orderModuleId,$commandsOfUserVar))
      @php
      $orderModule = true;
      @endphp
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed {{$orderModule ? '' : 'disabled'}}" data-bs-target="#orders-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Quản lý đơn hàng</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="orders-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('orders')}}" class="orders-nav ">
              <i class="bi bi-circle"></i><span>Danh sách đơn hàng</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End order nav -->

      @php
      $paymentModule = false;
      $paymentModuleId = 6;
      @endphp
      @if (array_key_exists($paymentModuleId,$commandsOfUserVar))
      @php
      $paymentModule = true;
      @endphp
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed {{$paymentModule ? '' : 'disabled'}}" data-bs-target="#payments-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-credit-card"></i><span>Phương thức thanh toán</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="payments-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('payments')}}" class="payments-nav ">
              <i class="bi bi-circle"></i><span>Danh sách phương thức thanh toán</span>
            </a>
          </li>
          <li>
            <a href="{{route('addpayment')}}" class="payments-add-nav">
              <i class="bi bi-circle"></i><span>Thêm mới phương thức thanh toán</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End payment type nav -->

      @php
      $postModule = false;
      $postModuleId = 7;
      @endphp
      @if (array_key_exists($postModuleId,$commandsOfUserVar))
      @php
      $postModule = true;
      @endphp
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed {{$postModule ? '' : 'disabled'}}" data-bs-target="#blogs-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-newspaper"></i><span>Bài viết</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="blogs-nav" class="nav-content collapse blogcategories-nav" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('blogcategories')}}" class="blogcategories-nav ">
              <i class="bi bi-circle"></i><span>Danh mục bài viết</span>
            </a>
          </li>
          <li>
            <a href="{{route('blogs')}}" class="blogs-nav ">
              <i class="bi bi-circle"></i><span>Bài viết</span>
            </a>
          </li>
        </ul>
      </li> <!-- End Slider Nav -->

      @php
      $wareHouseModule = false;
      $wareHouseModuleId = 11;
      @endphp
      @if (array_key_exists($wareHouseModuleId,$commandsOfUserVar))
      @php
      $wareHouseModule = true;
      @endphp
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed {{$wareHouseModule ? '' : 'disabled'}}" data-bs-target="#warehouse-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Kho hàng</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="warehouse-nav" class="nav-content collapse import-nav export-nav" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('import')}}" class="import-nav">
              <i class="bi bi-circle"></i><span>Danh sách nhập hàng</span>
            </a>
          </li>
          <li>
            <a href="{{route('export')}}" class="export-nav">
              <i class="bi bi-circle"></i><span>Quản lý kho</span>
            </a>
          </li>
        </ul>
      </li> <!-- End Slider Nav -->
      </li> <!-- End Post Nav -->

      @php
      $userModule = false;
      $userModuleId = 1;
      @endphp
      @if (array_key_exists($userModuleId,$commandsOfUserVar))
      @php
      $userModule = true;
      @endphp
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed {{$userModule ? '' : 'disabled'}}" data-bs-target="#customers-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Quản lý Người dùng</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="customers-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('customers')}}" class="customers-nav">
              <i class="bi bi-circle"></i><span>Danh sách người dùng</span>
            </a>
          </li>
        </ul>
      </li><!-- End Admin Account Nav -->

      @php
      $adminModule = false;
      $adminModuleId = 8;
      @endphp
      @if (array_key_exists($adminModuleId,$commandsOfUserVar))
      @php
      $adminModule = true;
      @endphp
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed {{$adminModule ? '' : 'disabled'}}" data-bs-target="#administrators-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-check"></i></i><span>Quản trị viên</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="administrators-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('administrators')}}" class="administrators-nav">
              <i class="bi bi-circle"></i><span>Danh sách quản trị viên</span>
            </a>
          </li>
          <li>
            <a href="{{route('addadministrator')}}" class="administrators-add-nav">
              <i class="bi bi-circle"></i><span>Thêm mới quản trị viên</span>
            </a>
          </li>
        </ul>
      </li> <!-- End Admin Nav -->

      @php
      $authorModule = false;
      $authorModuleId = 9;
      @endphp
      @if (array_key_exists($authorModuleId,$commandsOfUserVar))
      @php
      $authorModule = true;
      @endphp
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed {{$authorModule ? '' : 'disabled'}}" data-bs-target="#authorization-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-signpost-split"></i></i><span>Phân quyền</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="authorization-nav" class="nav-content collapse roles-nav commands-nav permissions-nav grant-permissions-nav" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('roles')}}" class="roles-nav">
              <i class="bi bi-circle"></i><span>Vai trò</span>
            </a>
          </li>
          <li>
            <a href="{{route('commands')}}" class="commands-nav">
              <i class="bi bi-circle"></i><span>Module quản lý</span>
            </a>
          </li>
          <li>
            <a href="{{route('permissions')}}" class="permissions-nav">
              <i class="bi bi-circle"></i><span>Quyền hạn</span>
            </a>
          </li>
          <li>
            <a href="{{route('grant-permissions')}}" class="grant-permissions-nav">
              <i class="bi bi-circle"></i><span>Cấp quyền</span>
            </a>
          </li>
        </ul>
      </li> <!-- End Admin Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  {{$slot}}

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Công ty TNHH Kinh doanh và Buôn bán <strong><span>TechChain</span></strong>
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Thông tin chi tiết <a href="https://techchains-ecommerce.store">TechChain</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/modal.js') }}"></script>
  <script src="{{ asset('assets/vendor/util.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>
  <script src="{{ asset('assets/vendor/jQuery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/tags-input-tagify/jQuery.tagify.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    window.addEventListener('DOMContentLoaded', (event) => {
      // Xử lý hiển thị vị trí navbar-vertical
      var fullUrl = window.location.href;
      var originUrl = window.location.origin
      var cutUrl = fullUrl.replace(originUrl, '')
      var newUrl = cutUrl.slice(1); 
      if (newUrl) {
        arr = newUrl.split('/')
        mainUrl = arr[0];
        idLinkEffectNavbar = mainUrl + '-nav';
        var itemModuleEffect = document.querySelector(`#${idLinkEffectNavbar}`)
        if(!itemModuleEffect) {
          itemModuleEffect = document.querySelector(`.${idLinkEffectNavbar}`)
        }
        if (itemModuleEffect) {
          itemModuleEffect.classList.add('show')
          if (arr[1]) {
            idLinkEffectNavbar = mainUrl + '-' + arr[1] + '-nav';
          }
          let itemLinkEffect = itemModuleEffect.querySelector(`.${idLinkEffectNavbar}`)

          if (!itemLinkEffect) {
            idLinkEffectNavbar = mainUrl + '-nav';
            itemLinkEffect = itemModuleEffect.querySelector(`.${idLinkEffectNavbar}`)
          }

          if (itemLinkEffect) {
            itemLinkEffect.classList.add('active')
          }
        }
      }
    });
  </script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script src="{{ asset('assets/js/jsUtils.js') }}"></script>
  @livewireScripts

  @stack('scripts')
</body>

</html>