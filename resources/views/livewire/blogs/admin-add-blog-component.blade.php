<main id="main" class="main">

    <div class="pagetitle">
        <h1>Bài viết</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item"><a href="{{route('blogs')}}">Bài viết</a></li>
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
                        <h5 class="card-title">Thêm mới bài viết</h5>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('blogs')}}" class="btn btn-primary btnRedirect">Tất cả bài viết</a>
                    </div>
                </div>

                <!-- Vertical Form -->
                <form class="row g-3" wire:submit.prevent = "storeBlog">
                    <div class="col-12">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" placeholder="Tiêu đề" 
							wire:model="title"
							wire:keyup="generateslug"
                        >
                        @error('title') 
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

					<div class="col-12">
                        <label for="subtitle" class="form-label">Tiêu đề phụ</label>
                        <input type="text" class="form-control" placeholder="Tiêu đề phụ" 
							wire:model="subtitle"
                        >
                        @error('subtitle') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

					<div class="col-6">
                        <label for="category_id" class="form-label">Danh mục</label>
                        <select class="form-select" aria-label="Danh mục"
                            wire:model='category_id'
                        >
                            <option selected>Mở danh mục chọn</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>
                    <!-- End blog category -->

                    <div class="col-6">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" aria-label="Trạng thái"
                        wire:model='status'
                        >
                            <option selected>Danh sách chọn</option>
                            <option value="1">Đăng tải</option>
                            <option value="0">Ngừng đăng tải</option>
                        </select>
                        @error('status') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

					<div class="col-12">
                        <label for="thumbnail" class="form-label">Ảnh mô tả</label>
                        <input type="file" class="form-control" id="formFile"
                        	wire:model="thumbnail"
                        >

                        @if($thumbnail)
                            <div wire:loading wire:target="thumbnail">Đang tải...</div>
                            <img src="{{$thumbnail->temporaryUrl()}}" width="120" style="margin: 6px 0 0 0"/>
                        @endif

                        @error('thumbnail') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

					<div class="col-12" wire:ignore>
                        <label for="content" class="form-label">Nội dung</label>
                        <textarea class = "form-control content" id = "content"
                        	wire:model="content"></textarea>

                        @error('content') 
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

@push('scripts')
    <script>
		tinymce.init({
            selector: '#content',
            forced_root_block: false,
            setup: function (editor) {
                editor.on('init change', function () {
                    editor.save();
                });
                editor.on('change', function (e) {
                    @this.set('content', editor.getContent());
                });
            }
        });
    </script>
@endpush