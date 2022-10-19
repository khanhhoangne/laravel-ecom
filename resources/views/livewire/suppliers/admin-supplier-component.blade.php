@php
$permissionsOfUser;
@endphp
@if (!empty(Config::get('permissions')))
    @if (!empty(Config::get('permissions')[Config::get('author.command.supplier')]))
    @php
    $permissionsOfUser = Config::get('permissions')[Config::get('author.command.supplier')];
    @endphp
    @endif
@endif
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Nhà cung ứng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Nhà cung ứng</li>
                <li class="breadcrumb-item active"><a href="{{route('suppliers')}}">Tất cả</a></li>
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
                                <h5 class="card-title">Danh sách nhà cung ứng</h5>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($permissionsOfUser[Config::get('author.permission.create')]))
                                <a href="{{route('addsupplier')}}" class="btn btn-primary btnRedirect">Thêm mới nhà cung ứng</a>
                                @else
                                <a href="javascript:void(0)" class="btn btn-primary btnRedirect">Thêm mới nhà cung ứng</a>
                                @endif
                            </div>
                        </div>
                        

                        <!-- Table with stripped rows -->
                        <table class="table" id="listtable">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">#ID</th>
                                    <th width="15%" scope="col">Ảnh</th>
                                    <th width="20%" scope="col">Nhà cung ứng</th>
                                    <th width="10%" scope="col">Trạng thái</th>
                                    <th width="23%" scope="col">Mô tả</th>
                                    <th width="7%" scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
            
                            @foreach ($suppliers as $supplier)
                                <tr class="listViewTableRow">
                                    <th scope="row">{{$supplier->id}}</th>
                                    <td>
                                        <img src="{{ $supplier->image ? asset('storage/uploads/suppliers/'.$supplier->image) : asset('storage/uploads/no-image.jpg') }}" alt="{{$supplier->supplier_name}}" width = "60"/>
                                    </td>
                                    <td>{{$supplier->supplier_name}}</td>
                                    <td>
                                        @if ($supplier->status === 'Collab')
                                            Hợp tác
                                        @else
                                            Ngừng hợp tác
                                        @endif
                                    </td>
                                    <td>{{$supplier->description}}</td>
                                    <td  class="listViewAction">
                                        @php
                                        $canUpdate = false;
                                        @endphp
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.update')]))
                                        @php
                                        $canUpdate = true;
                                        @endphp
                                        @endif
                                        <a href="{{ $canUpdate ? route('editsupplier', ['sup_slug' => $supplier->supplier_slug]) : 'javascript:void(0)'}}" class="">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.delete')]))
                                        <a href="#"  
                                            wire:click.prevent="deleteConfirm({{$supplier->id}})"
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

                        {{$suppliers->links()}}
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
