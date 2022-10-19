<main id="main" class="main">
    <div class="pagetitle">
        <h1>Quản lý đơn hàng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Quản lý đơn hàng</li>
                <li class="breadcrumb-item active"><a href="{{route('orders')}}">Tất cả</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row rowHeader">
                            <div class="col-md-6">
                                <h5 class="card-title">Danh sách đơn hàng</h5>
                            </div>
                        </div>


                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table" id="listtable">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã đơn</th>
                                        <th scope="col" class="text-center">Chi tiết</th>
                                        <th scope="col">Khách hàng</th>
                                        <th scope="col">Ngày đặt</th>
                                        <!-- <th scope="col">Phương thức thanh toán</th> -->
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($orders['data'] as $order)
                                        <tr class="listViewTableRow">
                                            <th scope="row">{{$order['id']}}</th>
                                            <td class="text-center">
                                                <i type="button" wire:click="getOrderDetail({{$order['id']}})" class="bi bi-eye-fill text-primary view-order-btn"></i>
                                            </td>
                                            <td>{{$order['fullname']}}</td>
                                            <td>
                                                @php
                                                $date=date_create($order['order_date']);
                                                @endphp
                                                {{date_format($date,"d/m/Y")}}
                                            </td>
                                            <!-- <td>{{$order['payment_name']}}</td> -->
                                            <td>
                                                <select class="form-select w-auto" wire:change="changeStatus({{$order['id']}}, $event.target.value)" aria-label="Trạng thái" {{$order['order_status'] == 2 ? 'disabled' : ''}}>
                                                    <option value="1" {{$order['order_status'] == 1 ? 'selected' : ''}}>Đang xử lý</option>
                                                    <option value="2" {{$order['order_status'] == 2 ? 'selected' : ''}}>Đã hủy</option>
                                                    <option value="3" {{$order['order_status'] == 3 ? 'selected' : ''}}>Đang vận chuyển</option>
                                                    <option value="4" {{$order['order_status'] == 4 ? 'selected' : ''}}>Đã giao</option>
                                                </select>
                                            </td>
                                            <td>{{number_format($order['total'])}}</td>
                                        </tr>                            
                                    @endforeach


                                </tbody>
                            </table>
                            <div wire:ignore>
                                {{ $orders->links() }}
                            </div>

                            @if ($show)
                            <div class="modal fade show" id="viewOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false" style="display: block; background-color: rgb(0 0 0 / 33%);">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="order-detail">
                                                <h5>{{ $orderDetails[0]['fullname'] }} #{{$orderDetails[0]['id']}}</h5>
                                                @php
                                                $arrStatus = ['Đang xử lý', 'Đã Hủy', 'Đang vận chuyển', 'Đã giao'];
                                                $arrColor = ['info', 'danger', 'primary', 'success'];
                                                @endphp
                                                <span class="btn btn-{{$arrColor[intval($orderDetails[0]['order_status']) - 1]}}" style="color: #fff;">{{$arrStatus[intval($orderDetails[0]['order_status']) - 1 ]}}</span>
                                            </div>
                                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                                <span aria-hidden="true"><i class="bi bi-x-lg"></i></span>
                                            </button>
                                        </div>
                                        <div class="modal-body order-detail-infor ">
                                            <div class="order-detail-infor-item">
                                                <div>
                                                    <div class="order-detail-infor-div"><strong>Email: </strong><span class="infor-line">{{ $orderDetails[0]['email'] }}</span></div>
                                                    <div class="order-detail-infor-div"><strong>Số điện thoại: </strong><span class="infor-line">{{ $orderDetails[0]['phone'] }}</span></div>
                                                    <div class="order-detail-infor-div"><strong>Địa chỉ: </strong><span>{{ $orderDetails[0]['address'] }}</span></div>
                                                </div>
                                                <div>
                                                    @php
                                                        $orrder_date = date_format(date_create($orderDetails[0]['order_date']),"d/m/Y");
                                                        $shipped_date = '';
                                                        $paid_date = '';
                                                    @endphp
                                                    @if (empty($orderDetails[0]['shipped_date']) === false)
                                                        $shipped_date = date_create($orderDetails[0]['shipped_date']);
                                                    @endif
                                                    @if (empty($orderDetails[0]['paid_date']) === false) {
                                                        $paid_date = date_create($orderDetails[0]['paid_date']);
                                                    @endif
                                                    <div class="order-detail-infor-div"><strong>Ngày đặt hàng: </strong><span>{{$orrder_date}}</span></div>
                                                    <div class="order-detail-infor-div"><strong>Phương thức thanh toán: </strong><span>{{ $orderDetails[0]['payment_name'] }}</span></div>
                                                    <div class="order-detail-infor-div"><strong>Ngày giao hàng: </strong><span>{{$shipped_date}}</span></div>
                                                    <div class="order-detail-infor-div"><strong>Ngày thanh toán: </strong><span>{{$paid_date}}</span></div>
                                                </div>
                                            </div>
                                            <div class="table-responsive mt-5">
                                                <table class="table" style="overflow-y: scroll; height: 400px;">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">
                                                                <i class="bi bi-image"></i>
                                                            </th>
                                                            <th scope="col">Tên sản phẩm</th>
                                                            <th scope="col" class="text-center">Số lượng</th>
                                                            <th scope="col">Đơn giá</th>
                                                            <th scope="col">Tổng giá</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($orderDetails as $order)
                                                        <tr>
                                                            <th scope="row">
                                                                <img style="width: 70px;" src="{{ $order['image'] ? asset('storage/uploads/products/'.$order['image']) : asset('storage/uploads/no-image.jpg') }}" alt="" />
                                                            </th>
                                                            <td style="text-transform: capitalize; font-weight: bold;" class="color-featured">
                                                                {{ $order['product_name'] }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $order['quantity'] }}
                                                            </td>
                                                            <td>{{ number_format($order['unit_price']) }}</td>
                                                            <td>
                                                                <strong>{{ number_format($order['quantity']*$order['unit_price']) }} VND</strong>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal" wire:click="closeModal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                       
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

@push('scripts')
<script>
    Livewire.restart();
</script>
@endpush