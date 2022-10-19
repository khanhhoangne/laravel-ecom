<main id="main" class="main">

    <div class="pagetitle">
        <h1>Danh mục bài viết</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item"><a href="{{route('blogcategories')}}">Danh mục bài viết</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
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
                        <h5 class="card-title">Thêm mới danh mục</h5>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('blogcategories')}}" class="btn btn-primary btnRedirect">Tất cả danh mục</a>
                    </div>
                </div>

                <!-- Vertical Form -->
                <form class="row g-3" wire:submit.prevent = "storeCategory">
                    <div class="col-12">
                        <label for="name" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" placeholder="Nhập tên danh mục" 
                        wire:model="name"
                        wire:keyup="generateslug"
                        >
                        @error('name') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="slug" class="form-label">Liên kết</label>
                        <input type="text" class="form-control" placeholder="Liên kết tĩnh"
                        wire:model="slug"
                        >
                        @error('slug') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="banner" class="form-label">Ảnh mô tả</label>
                        <input type="file" class="form-control" id="formFile"
                        wire:model="banner"
                        >

                        @if($banner)
                            <div wire:loading wire:target="banner">Đang tải...</div>
                            <img src="{{$banner->temporaryUrl()}}" width="120" style="margin: 6px 0 0 0"/>
                        @endif

                        @error('banner') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" aria-label="Trạng thái"
                        wire:model='status'
                        >
                            <option selected>Danh sách chọn</option>
                            <option value="1">Hoạt động</option>
                            <option value="0">Ngừng hoạt động</option>
                        </select>
                        @error('status') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

					<div class="col-12">
                        <label for="parent_id" class="form-label">Thuộc danh mục</label>
                        <select class="form-select" aria-label="Thuộc danh mục"
                            wire:model='parent_id'
                        >
                            <option selected>Mở danh mục chọn</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>

                        @error('parent_id') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>
                    <!-- End blog category -->

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