@php
$permissionsOfUser;
@endphp
@if (!empty(Config::get('permissions')))
    @if (!empty(Config::get('permissions')[Config::get('author.command.product')]))
    @php
    $permissionsOfUser = Config::get('permissions')[Config::get('author.command.product')];
    @endphp
    @endif
@endif
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Danh sách sản phẩm</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Danh sách sản phẩm</li>
                <li class="breadcrumb-item active"><a href="{{route('products')}}">Tất cả</a></li>
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
                                <h5 class="card-title">Danh sách sản phẩm</h5>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($permissionsOfUser[Config::get('author.permission.create')]))
                                <a href="{{route('addproduct')}}" class="btn btn-primary btnRedirect">Thêm mới sản phẩm</a>
                                @else
                                <a href="javascript:void(0)" class="btn btn-primary btnRedirect">Thêm mới sản phẩm</a>
                                @endif
                            </div>
                        </div>
                        

                        <!-- Table with stripped rows -->
                        <table class="table" id="listtable">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">#ID</th>
                                    <th width="10%" scope="col">Ảnh đại diện</th>
                                    <th width="30%" scope="col">Tên</th>
                                    <th width="7%" scope="col">Mã</th>
                                    <th width="15%" scope="col">Loại</th>
                                    <th width="15%" scope="col">Nhà cung cấp</th>
                                    <th width="10%" scope="col">Trạng thái</th>
                                    <th width="7%" scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $product)
                                <tr class="listViewTableRow">   
                                    <th scope="row">{{$product->id}}</th>
                                    <td>
                                        <img src="{{ $product->image ? asset('storage/uploads/products/'.$product->image) : asset('storage/uploads/no-image.jpg') }}" width = "70" alt="">
                                    </td>
                                    <td>{{$product->product_name}}</td>
                                    <td>{{$product->product_code}}</td>
                                    <td>{{$product->category->category_name}}</td>
                                    <td>{{$product->supplier->supplier_name}}</td>
                                    <td>{{$product->is_continued}}</td>
                                    <td  class="listViewAction">
                                        @php
                                        $canUpdate = false;
                                        @endphp
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.update')]))
                                        @php
                                        $canUpdate = true;
                                        @endphp
                                        @endif
                                        <a href="{{ $canUpdate ? route('editproduct', ['product_slug' => $product->product_slug]) : 'javascript:void(0)'}}" class="">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.delete')]))
                                        <a href="#"  
                                            wire:click.prevent="deleteConfirm({{$product->id}})"
                                            style="margin-left: 8px;" 
                                        >
                                            <i class="bi bi-trash text-danger"></i>
                                        </a>
                                        @else
                                        <a href="javascript:void(0)"  
                                            style="margin-left: 8px;" 
                                        >
                                            <i class="bi bi-trash text-danger"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>                         
                            @endforeach

                            </tbody>
                        </table>
                        {{ $products->links() }}

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


