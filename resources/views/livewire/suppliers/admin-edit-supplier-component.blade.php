<main id="main" class="main">

    <div class="pagetitle">
        <h1>Nhà cung ứng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item"><a href="{{route('suppliers')}}">Nhà cung ứng</a></li>
                <li class="breadcrumb-item active">Cập nhật: {{$supplier_name}}</li>
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
                        <h5 class="card-title">Cập nhật nhà cung ứng</h5>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('suppliers')}}" class="btn btn-primary btnRedirect">Tất cả nhà cung ứng</a>
                    </div>
                </div>

                <!-- Vertical Form -->
                <form class="row g-3" wire:submit.prevent = "updateSupplier">
                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Tên nhà cung ứng</label>
                        <input type="text" class="form-control" placeholder="Nhập tên nhà cung ứng" 
                        wire:model="supplier_name"
                        wire:keyup="generateslug"
                        >
                        @error('supplier_name') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Liên kết</label>
                        <input type="text" class="form-control" placeholder="Liên kết tĩnh"
                        wire:model="supplier_slug"
                        >
                        @error('supplier_slug') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Ảnh mô tả</label>
                        <input type="file" class="form-control" id="formFile"
                        wire:model="newImage"
                        >

                        @if($newImage)
                            <div wire:loading wire:target="newImage">Đang tải...</div>
                            <img src="{{$newImage->temporaryUrl()}}" width="120" style="margin: 6px 0 0 0"/>
                        @else
                            @if ($image)
                            <img src="{{ asset('storage/uploads/suppliers/'.$image) }}" width="120" style="margin: 6px 0 0 0"/>
                            @endif
                            <img src="{{ asset('storage/uploads/no-image.jpg') }}" width="120" style="margin: 6px 0 0 0"/>
                        @endif

                        @error('newImage') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Trạng thái</label>
                        <select class="form-select" aria-label="Trạng thái"
                        wire:model='status'
                        >
                            <option selected>Danh sách chọn</option>
                            <option value="Collab">Hợp tác</option>
                            <option value="Not collab">Ngừng hợp tác</option>
                        </select>
                        @error('status') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Mô tả</label>
                        <textarea class = "simpleTextArea" placeholder="Mô tả nhà cung ứng"
                        wire:model="description"></textarea>

                        @error('description') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button class="btn btn-danger">
                            <a class="cancelColor" href="{{route('suppliers')}}">Hủy bỏ</a>
                        </button>
                    </div>
                </form><!-- Vertical Form -->

                </div>
            </div>

            </div>
        </div>
    </section>
</main><!-- End #main -->
