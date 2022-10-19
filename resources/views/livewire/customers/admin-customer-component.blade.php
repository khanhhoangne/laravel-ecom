<main id="main" class="main">
    <div class="pagetitle">
        <h1>Danh sách khách hàng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Danh sách khách hàng</li>
                <li class="breadcrumb-item active"><a href="{{route('customers')}}">Tất cả</a></li>
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
                                <h5 class="card-title">Danh sách khách hàng</h5>
                            </div>
                            <!-- <div class="d-flex col-md-5">
                                <input class="form-control me-1" type="text" placeholder="Tìm kiếm theo tên" wire:change="updateSearch($event.target.value)">
                                <button class="btn btn-outline-success" type="button">Search</button>
                            </div> -->
                            <div class="col-md-8">
                                <a href="{{ route('customers-export') }}" class="btn btn-primary btnRedirect">Xuất excel</a>
                            </div>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table" id="listtable">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">Mã khách hàng</th>
                                    <th width="15%" scope="col">Ảnh đại diện</th>
                                    <th width="18%" scope="col">Tên khách hàng</th>
                                    <th width="7%" scope="col">Giới tính</th>
                                    <th width="10%" scope="col">Ngày sinh</th>
                                    <th width="10%" scope="col">Số điện thoại</th>
                                    <th width="10%" scope="col">Trạng thái</th>
                                    <th width="25%" scope="col">Địa chỉ</th>
                                </tr>
                            </thead>
                            <tbody>
            
                            @foreach ($customers as $customer)
                                <tr class="listViewTableRow">
                                    <th scope="row">{{$customer->id}}</th>
                                    <td>
                                        <img src="{{ $customer->image ? asset('storage/uploads/customers/'.$customer->image) : asset('storage/uploads/no-image.jpg') }}" alt="{{$customer->customer_name}}" width = "60"/>
                                    </td>
                                    <td>{{$customer->fullname}}</td>
                                    <td>{{$customer->gender}}</td>
                                    <td>
                                        @php
                                        $date=date_create($customer->birthday);
                                        @endphp
                                        {{date_format($date, "d/m/Y")}}
                                    </td>
                                    <td>{{$customer->phone}}</td>
                                    <td>
                                        @if ($customer->status == 'Active')
                                            Hoạt động
                                        @else
                                            Ngừng hoạt động
                                        @endif
                                    </td>
                                    <td>{{ $customer->address }}</td>
                                </tr>                            
                            @endforeach

                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between">  
                            <select class="form-select w-auto" aria-label="Default select example" wire:model="take">
                                <option value="6">6</option>
                                <option value="8">8</option>
                                <option value="10">10</option>
                            </select> 
                            @if ($pageCount > 1)
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item {{ $page - 1 <= 0 ? 'disabled' : ''}}">
                                        <a class="page-link" wire:click="handlePaginate({{$page-1}}, {{$take}})" href="#">Trước</a>
                                    </li>
                                    @for ($i = 1; $i <= $pageCount; $i++)
                                    <li class="page-item {{ $i === $curPage ? 'active' : '' }}">
                                        <a class="page-link" wire:click="handlePaginate({{$i}}, {{$take}})" href="#">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ $page + 1 > $pageCount ? 'disabled' : ''}}">
                                        <a class="page-link" wire:click="handlePaginate({{$page + 1}}, {{$take}})" href="#">Sau</a>
                                    </li>
                                </ul>
                            </nav>
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
