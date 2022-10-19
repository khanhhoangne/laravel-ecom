<main id="main" class="main">

    <div class="pagetitle">
        <h1>Phương thức thanh toán</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item"><a href="{{route('payments')}}">Phương thức thanh toán</a></li>
                <li class="breadcrumb-item active">Cập nhật: {{$payment_name}}</li>
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
                        <h5 class="card-title">Thêm mới phương thức thanh toán</h5>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('payments')}}" class="btn btn-primary btnRedirect">Tất cả phương thức thanh toán</a>
                    </div>
                </div>

                <!-- Vertical Form -->
                <form class="row g-3" wire:submit.prevent = "updatePayment">
                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Tên phương thức thanh toán</label>
                        <input type="text" class="form-control" placeholder="Nhập tên phương thức thanh toán" 
                        wire:model="payment_name"
                        wire:keyup="generateslug"
                        >
                        @error('payment_name') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Liên kết</label>
                        <input type="text" class="form-control" placeholder="Liên kết tĩnh"
                        wire:model="payment_slug"
                        >
                        @error('payment_slug') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Ảnh mô tả</label>
                        <input type="file" class="form-control" id="formFile"
                        wire:model="newImage"
                        >

                        @if($newImage)
                            <div wire:loading wire:target="newThumbnail">Đang tải...</div>
                            <img src="{{$newImage->temporaryUrl()}}" width="120" />
                        @else
                            <img src="{{$image ? asset('storage/uploads/payments/'. $image) : '' }}" width="120" />
                        @endif

                        @error('newImage') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Mô tả</label>
                        <textarea class = "simpleTextArea" placeholder="Mô tả phương thức thanh toán"
                        wire:model="description"></textarea>

                        @error('description') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button class="btn btn-danger">
                            <a class="cancelColor" href="{{route('payments')}}">Hủy bỏ</a>
                        </button>
                    </div>
                </form><!-- Vertical Form -->

                </div>
            </div>

            </div>
        </div>
    </section>
</main><!-- End #main -->
