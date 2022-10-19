<main id="main" class="main">
    <div class="pagetitle">
        <h1>Danh sách nhập hàng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Danh sách nhập hàng</li>
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
                                <h5 class="card-title">Danh sách nhập</h5>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between flex-column">
                                    <div>
                                        <label for="date">Lọc theo thời gian</label>
                                        <input type="date" wire:model="date" id="date" name="date">
                                        <button class="badge bg-success p-2 ms-2" wire:click="filterByDate">Tìm</button>

                                    </div>
                                    @if (count($imports) > 1)
                                    <!-- <div>
                                        <label>Hiển thị</label>
                                        <input type="range" style="height: 9px" class="form-control-range" >
                                        <span id="rangeval" class="font-weight-bold">
                                           
                                        </span>
                                    </div> -->
                                    <div class="range-container">
                                        <label for="range">Hiển thị</label>
                                        <input style="height: 9px" class="multi-range" type="range" name="range" id="range" value="{{ count($imports) }}" min=1 max="{{ count($imports) }}" id="formControlRange" wire:change="filterByRange($event.target.value)" onInput="$('#rangeval').html($(this).val())" />
                                        <label for="range">{{ $take }}</label>
                                    </div>
                                    @endif
                                </div>

                            </div>
                            <div class="col-md-4">
                                <a href="{{route('addimport')}}" class="badge bg-primary p-2 ms-2 btnRedirect create-import">Tạo phiếu nhập</a>
                            </div>
                        </div>


                        <!-- Table with stripped rows -->
                        <table id="listtable" class="table-custom">
                            <thead>
                                <tr>
                                    <th scope="col">ID
                                        @if($sortType === 'desc')
                                        <svg wire:click="filterByCol('id')" role="button" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z" />
                                            <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z" />
                                        </svg>
                                        @else
                                        <svg wire:click="filterByCol('id')" role="button" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-up" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z" />
                                            <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zm-8.46-.5a.5.5 0 0 1-1 0V3.707L2.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L4.5 3.707V13.5z" />
                                        </svg>
                                        @endif

                                    </th>
                                    <th scope="col">Thuộc cửa hàng

                                    </th>
                                    <th scope="col">Người nhập

                                    </th>
                                    <th scope="col">Ngày nhập
                                        @if($sortType === 'desc')
                                        <svg wire:click="filterByCol('import_date')" role="button" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z" />
                                            <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z" />
                                        </svg>
                                        @else
                                        <svg wire:click="filterByCol('import_date')" role="button" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-up" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z" />
                                            <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zm-8.46-.5a.5.5 0 0 1-1 0V3.707L2.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L4.5 3.707V13.5z" />
                                        </svg>
                                        @endif
                                    </th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php if($sortType === 'asc') $indexBegin = $importsTotal - $take;  @endphp
                                @foreach($imports as $key => $import)
                                @php if($take == $key && $sortType === 'desc') break; @endphp
                                @php if($sortType === 'asc' && $key < $indexBegin) continue; @endphp
                                <tr class="listViewTableRow">
                                    <th scope="row">{{ $import['id'] }}</th>
                                    <td>{{ $import['store_name'] }}</td>
                                    <td>
                                        Hoàng Gia Khánh
                                    </td>

                                    <td>
                                        {{ $import['import_date'] }}
                                    </td>

                                    <td>
                                        <i type="button" wire:click="getImportDetail({{$import['id']}})" class="bi bi-eye-fill text-primary view-order-btn"></i>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($show == 1)
                        <div class="modal fade show" id="viewOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false" style="font-size: 0.8rem;display: block; background-color: rgb(0 0 0 / 33%);">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close btn" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                            <span aria-hidden="true"><i class="bi bi-x-lg"></i></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table-custom">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Tên sản phẩm</th>
                                                    <th scope="col">Biến thể</th>
                                                    <th scope="col">Số lượng</th>
                                                    <th scope="col">Giá nhập</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($importDetails as $key => $detail)
                                                <tr>
                                                    <th scope="row">{{ ++$key }}</th>
                                                    <td>{{ $detail['product_name'] }}</td>
                                                    <td>{{ $detail['option_name'] }}</td>
                                                    <td>{{ $detail['quantity'] }}</td>
                                                    <td>{{ number_format(intval($detail['unit_price']), 3) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" wire:click="closeModal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
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
    $('#multi').mdbRange({
        single: {
            active: true,
            multi: {
                active: true,
                rangeLength: 1
            },
        }
    });
</script>
@endpush