<main id="main" class="main">

    <div class="pagetitle">
        <h1>Phương thức thanh toán</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item"><a href="{{route('vouchers')}}">Mã khuyến mãi</a></li>
                <li class="breadcrumb-item active">Cập nhật</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">

                <div class="card">
                    <div class="card-body">
                        <div class="row rowHeader">
                            <div class="col-md-6">
                                <h5 class="card-title">Cập nhật mãi khuyến mãi</h5>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('vouchers')}}" class="btn btn-primary btnRedirect">Tất cả mã khuyến mãi</a>
                            </div>
                        </div>

                        <!-- Vertical Form -->
                        <form class="row g-3" wire:submit.prevent="storeVoucher">
                            <div class="col-6">
                                <label for="inputNanme4" class="form-label">Mã giảm giá</label>
                                <input  wire:model="voucher_code" type="text" class="form-control" value="{{ $voucher['voucher_code'] }}" placeholder="Nhập mã giảm giá">
                                @error('voucher_code') 
                                    <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="inputNanme4" class="form-label">Tên mã giảm giá</label>
                                <input type="text" wire:model="voucher_name" class="form-control" value="{{ $voucher['voucher_name'] }}" placeholder="Nhập tên mã giảm giá">
                                @error('voucher_name') 
                                    <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="inputNanme4" class="form-label">Slug</label>
                                <input type="text" wire:model="voucher_slug" class="form-control" value="{{ $voucher['voucher_slug'] }}" placeholder="Liên kết tĩnh">
                                @error('voucher_slug') 
                                    <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="inputNanme4" class="form-label">Mô tả</label>
                                <textarea wire:model="voucher_des" class="simpleTextArea" value="{{ $voucher['description'] }}" placeholder="Mô tả công dụng..."></textarea>
                                @error('voucher_des') 
                                    <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                                @enderror
                            </div>
                            

                            <div class="col-6">
                            <label for="inputNanme4" class="form-label">Loại giảm giá</label>
                                <select wire:model="voucher_type" class="form-select">
                                    @php 
                                        $option = ['Money' => 'Tiền mặt', 'Percent' => 'Phần trăm (%)'];
                                        
                                        $str = '';
                                        foreach($option as $key => $data) {
                                            $str .= ($key === $voucher['voucher_type']) ? '<option selected ' : '<option ';
                                            $str .= 'value="'.$key.'">'.$data.'</option>';
                                        }

                                        echo $str;
                                    @endphp
                                    @php
                                    
                                    @endphp
                                </select>
                                @error('voucher_type') 
                                    <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="inputNanme4" class="form-label">Giá trị</label>
                                <input wire:model="voucher_price" type="text" class="form-control" value="{{ $voucher['discount_value'] }}" placeholder="Nhập giá trị">
                                @error('voucher_price') 
                                    <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="inputNanme4" class="form-label">Số lượng</label>
                                <input wire:model="voucher_max_uses" type="number" value="{{ $voucher['max_uses'] }}" class="form-control" placeholder="Nhập giá trị">
                                @error('voucher_max_uses') 
                                    <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="inputNanme4" class="form-label">Số lần tối đa sử dụng</label>
                                <input wire:model="voucher_max_uses_user" type="number" value="{{ $voucher['max_uses_user'] }}"  class="form-control" placeholder="Nhập giá trị">
                                @error('voucher_max_uses_user') 
                                    <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="inputNanme4" class="form-label">Ngày bắt đầu</label>
                                <input wire:model="voucher_date_begin" type="date" value="{{ (explode(' ', $voucher['start_date'])[0]) }}" class="form-control" placeholder="Nhập giá trị">
                                @error('voucher_date_begin') 
                                    <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                                @enderror
                            </div>
                            
                            <div class="col-6">
                                <label for="inputNanme4" class="form-label">Ngày kết thúc</label>
                                <input wire:model="voucher_date_end" type="date" value="{{ (explode(' ', $voucher['end_date'])[0]) }}" class="form-control" placeholder="Nhập giá trị">
                                @error('voucher_date_end') 
                                    <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                                @enderror
                            </div>
                           
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                                <button type="reset" class="btn btn-secondary">Tạo lại</button>
                            </div>
                        </form><!-- Vertical Form -->

                    </div>
                </div>

            </div>
        </div>
    </section>
</main><!-- End #main -->