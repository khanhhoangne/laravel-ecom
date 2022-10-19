@php
$permissionsOfUser;
@endphp
@if (!empty(Config::get('permissions')))
    @if (!empty(Config::get('permissions')[Config::get('author.command.payment')]))
    @php
    $permissionsOfUser = Config::get('permissions')[Config::get('author.command.payment')];
    @endphp
    @endif
@endif
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Danh sách phương thức thanh toán</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Danh sách phương thức thanh toán</li>
                <li class="breadcrumb-item active"><a href="{{route('payments')}}">Tất cả</a></li>
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
                                <h5 class="card-title">Danh sách phương thức thanh toán</h5>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($permissionsOfUser[Config::get('author.permission.create')]))
                                <a href="{{route('addpayment')}}" class="btn btn-primary btnRedirect">Thêm mới phương thức thanh toán</a>
                                @else
                                <a href="javascript:void(0)" class="btn btn-primary btnRedirect">Thêm mới phương thức thanh toán</a>
                                @endif
                            </div>
                        </div>
                        

                        <!-- Table with stripped rows -->
                        <table class="table" id="listtable">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">Thứ tự</th>
                                    <th width="15%" scope="col">Ảnh</th>
                                    <th width="20%" scope="col">Tên</th>
                                    <th width="23%" scope="col">Mô tả</th>
                                    <th width="7%" scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($payments as $payment)
                                <tr class="listViewTableRow">
                                    <th scope="row">{{$i}}</th>
                                    <td>
                                        <img src="{{ $payment->image ? asset('storage/uploads/payments/'.$payment->image) : asset('storage/uploads/no-image.jpg') }}" alt="{{$payment->payment_name}}" width = "60"/>
                                    </td>
                                    <td>{{$payment->payment_name}}</td>
                                    <td>{{$payment->description}}</td>
                                    <td  class="listViewAction">
                                        @php
                                        $canUpdate = false;
                                        @endphp
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.update')]))
                                        @php
                                        $canUpdate = true;
                                        @endphp
                                        @endif
                                        <a href="{{ $canUpdate ? route('editpayment', ['paymenttype_slug' => $payment->payment_slug]) : 'javascript:void(0)'}}" class="">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.delete')]))
                                        <a href="#"  
                                            wire:click.prevent="deleteConfirm({{$payment->id}})"
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
                                @php
                                $i++;
                                @endphp                            
                            @endforeach

                            </tbody>
                        </table>

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

