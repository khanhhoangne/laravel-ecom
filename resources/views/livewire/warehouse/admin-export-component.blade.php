<main id="main" class="main">
    <div class="pagetitle">
        <h1>Quản lý kho hàng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Quản lý kho hàng</li>
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
                                <h5 class="card-title">Danh sách hàng tồn kho</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 product_option_form">
                                <label for="inputNanme4" class="form-label">Tìm sản phẩm</label>
                                @if(!empty($productSelected))
                                <input type="text" class="form-control" readonly id="input_selected" value=''>
                                @else
                                <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" wire:model.debounce.500ms="product" wire:keydown="handleChange" id="search_input">
                                @endif

                                @if($selected)
                                <div class="product_option_true">
                                    {{ $productSelected['product_name'] ?? null }}
                                    <i class="bi bi-x-circle text-danger" id="remove-option" wire:click="removeSelected()" style="cursor: pointer;"></i>
                                </div>
                                @endif

                                @if(!empty($productSearch) && !$selected)
                                <ul id="option" class="product_option">
                                    @foreach($productSearch as $data)
                                    <li wire:click="selectedProduct({{$data['id']}})">
                                        <p>{{ $data['product_name'] }}</p>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif

                            </div>

                            @if($selected && !empty($importDetail))
                            <table class="table-custom mt-3 table-product-search">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Biến thể</th>
                                        <th scope="col">Số lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($importDetail as $key => $data)
                                    <tr>
                                        <th>{{ ++$key }}</th>
                                        <td>{{ $data['option_name'] }}</td>
                                        <td>{{ $data['total'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif



                            <table class="table-custom mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Biến thể</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @php $take = $takeProduct; @endphp
                                    @php $take = ((count($productStockType) - $take) < 0) ? count($productStockType) : $take; @endphp @php $offset=range((($page - 1) * $take + 1), $page*$take); @endphp @if(!empty($productStockType)) @foreach($offset as $key=> $data)
                                        @if(!empty($productStockType[$data - 1]))
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $productStockType[$data - 1]['product_name'] }}</td>
                                            <td>{{ $productStockType[$data - 1]['option_name'] }}</td>
                                            <td>{{ $productStockType[$data - 1]['total'] }}</td>
                                            @if($checkedStatus == "1")
                                            <td>
                                                <button class="badge bg-warning p-2 ms-2">Sắp hết hàng</button>
                                            </td>
                                            @else
                                            <td>
                                                <button class="badge bg-danger p-2 ms-2">Hết hàng</button>
                                            </td>
                                            @endif
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endif
                                </tbody>
                            </table>

                            <div class="col-md-12 mt-2">
                                <div class="d-flex justify-content-between ">
                                    <div class="d-flex gap-4">
                                        <select class="form-select" id="favcity" name="select" wire:model="status">
                                            <option value="1">Sắp hết hàng</option>
                                            <option value="0">Hết hàng</option>
                                        </select>
                                       
                                        <button wire:click="filterStatus()" class="badge bg-success p-2 ms-2">Lọc danh sách</button>
                                    </div>

                                    <div class="d-flex align-items-center gap-2" style="line-height:0px">
                                        @if($page === 1)
                                        <div class="f-right">
                                            <select class="form-select" wire:model="takeProduct">
                                                @for($i = 1; $i <= count($productStockType); $i +=2) @php if($key> 10) break; @endphp

                                                    <option>{{ $i }}</option>

                                                    @endfor
                                            </select>
                                        </div>
                                        @endif
                                        @if(count($productStockType) > $take)
                                        <div class="range-container">
                                            <label for="range">Trang</label>
                                            <input style="height: 9px" class="multi-range" type="range" name="range" min=1 value="{{ $page }}" max="{{ ceil(count($productStockType) / floatval($take)) }}" id="range" wire:change="filterByRange($event.target.value)" />
                                            <label for="range">{{ $page }} / {{ceil(count($productStockType) / floatval($take))}}</label>
                                            <svg wire:click="resetPage()" style="cursor: pointer" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise refesh-icon" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                                            </svg>
                                        </div>
                                        @endif


                                    </div>

                                </div>

                            </div>

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
    if (document.querySelector('#input_selected') != undefined) {
        document.querySelector('#input_selected').value = '';
    }

    $(window).ready(() => {
        if (document.querySelector('#search_input') != undefined) {
            if (document.querySelector('#search_input').value == '') {
                $("#option").addClass("d-none");
                console.log(22);
            }
        }
    });
</script>
@endpush