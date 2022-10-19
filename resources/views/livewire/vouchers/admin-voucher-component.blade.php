<main id="main" class="main">
    <div class="pagetitle">
        <h1>Danh sách mã giảm giá</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Danh sách mã giảm giá</li>
                <li class="breadcrumb-item active"><a href="{{route('import')}}">Tất cả</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row rowHeader">
                            <div class="col-md-4">
                                <h5 class="card-title">Danh sách mã giảm giá</h5>
                            </div>
                            <div class="col-md-4">


                            </div>
                            <div class="col-md-4">
                                <a href="{{route('addvoucher')}}" class="badge bg-primary p-2 ms-2 btnRedirect create-import">Tạo mã giảm giá</a>
                            </div>
                        </div>


                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table id="listtable" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã
                                        </th>
                                        <th scope="col">Tên

                                        </th>
                                        <th scope="col">Loại

                                        </th>
                                        <th scope="col">Giảm

                                        </th>
                                        <th scope="col">Thời hạn</th>
                                        <th scope="col">Ngày đăng</th>
                                        <th scope="col">Ngày cập nhật</th>
                                        <th scope="col">Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vouchers as $key => $voucher)
                                    <tr class="listViewTableRow">
                                        <th scope="row">{{ $voucher['voucher_code'] }}</th>
                                        <td>{{ $voucher['voucher_name'] }}</td>
                                        <td>
                                            {{ $voucher['voucher_type'] === 'Money' ? 'Tiền mặt' : 'Phần trăm' }}
                                        </td>

                                        <td>
                                            {{ $voucher['discount_value'] }}
                                        </td>
                                        <td>
                                            @if(!$voucher['is_expired'])
                                            @if(!$voucher['is_expired'])
                                            <strong wire:poll.1000ms style="color: red;">
                                            @else
                                            <strong style="color: red;">
                                            @endif
                                                @php
                                                $start = strtotime(date('Y-m-d H:i:s'));
                                                $end = strtotime($voucher['end_date']);

                                                $time = intval($end - $start);

                                                if($time <= 0) {
                                                    echo '0:0:0';
                                                } else {
                                                    $hours = floor($time / 3600);
                                                    $mins = floor($time / 60 % 60);
                                                    $secs = floor($time % 60);
                                                
                                                    $result = $hours.':'.$mins.':'.$secs;
                                                    
                                                    echo $result;
                                                }
                                                @endphp
                                                
                                            </strong>
                                            @else
                                                <button class="badge bg-warning p-2 ms-2">Hết hạn</button>
                                            @endif
                                        </td>
                                        <td>{{ $voucher['created_at'] }}</td>
                                        <td>{{ $voucher['updated_at'] }}</td>
                                        <td>
                                            <a href="{{ route('editvoucher', ['voucher_slug' => $voucher['voucher_slug']]) }}" class="">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a wire:click="removeItem({{ $voucher['id'] }})" href="javascript:void(0)" style="margin-left: 8px;">
                                                <i class="bi bi-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

@push('scripts')
<script>
    Livewire.restart();
    window.addEventListener('alert', event => {
        toastr[event.detail.type](event.detail.message,
            event.detail.title ?? ''), toastr.options = {
            "closeButton": true,
            "progressBar": true,
        }
    });
</script>
@endpush