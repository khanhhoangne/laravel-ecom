<main id="main" class="main">

    <div class="pagetitle">
        <h1>Sản phẩm</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item"><a href="{{route('products')}}">Sản phẩm</a></li>
                <li class="breadcrumb-item active">Cập nhật</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">

            <div class="card">
                <div class="card-body">
                <div class="row rowHeader">
                    <div class="col-md-6">
                        <h5 class="card-title">Cập nhật sản phẩm</h5>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('products')}}" class="btn btn-primary btnRedirect">Tất cả sản phẩm</a>
                    </div>
                </div>

                <!-- Vertical Form -->
                <form class="row g-3" wire:submit.prevent = "updateProduct">
                    <div class="col-6">
                        <label for="product_name" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" 
                            wire:model="product_name"
                            wire:keyup="generateSlug"
                        >
                        @error('product_name') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>
                    <!-- End product name -->

                    <div class="col-6">
                        <label for="product_code" class="form-label">Mã sản phẩm</label>
                        <input type="text" class="form-control" placeholder="PROD25814/243" 
                            wire:model="product_code"
                        >
                        @error('product_code') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>
                    <!-- End product code -->

                    <div class="col-6">
                        <label for="product_slug" class="form-label">Liên kết</label>
                        <input type="text" class="form-control" placeholder="Liên kết tĩnh"
                            wire:model="product_slug"
                        >
                        @error('product_slug') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>
                    <!-- End product slug -->

                    <div class="col-6">
                        <label for="is_continued" class="form-label">Trạng thái</label>
                        <select class="form-select" aria-label="Trạng thái"
                            wire:model='is_continued'
                        >
                            <option selected>Mở danh mục chọn</option>
                            <option value="Continued">Còn bán</option>
                            <option value="Discontinued">Ngừng bán</option>
                        </select>
                        @error('is_continued') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>
                    <!-- End product status -->

                    <div class="col-6">
                        <label for="category_id" class="form-label">Danh mục sản phẩm</label>
                        <select class="form-select" aria-label="Danh mục sản phẩm"
                            wire:model='category_id'
                        >
                            <option selected>Mở danh mục chọn</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                        @error('category_id') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>
                    <!-- End product category -->

                    <div class="col-6">
                        <label for="supplier_id" class="form-label">Nhà cung ứng</label>
                        <select class="form-select" aria-label="Nhà cung ứng"
                            wire:model='supplier_id'
                        >
                            <option selected>Mở danh mục chọn</option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                            @endforeach
                        </select>
                        @error('supplier_id') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>
                    <!-- End product supplier -->

                    <div class="col-6">
                        <label for="is_new" class="form-label">Tình trạng sản phẩm</label>
                        <select class="form-select" aria-label="Tình trạng sản phẩm"
                            wire:model='is_new'
                        >
                            <option selected>Mở danh mục chọn</option>
                            <option value="New">Mới</option>
                            <option value="Not new">Bình thường</option>
                        </select>
                        @error('is_new') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>
                    <!-- End product is new -->

                    <div class="col-6">
                        <label for="is_featured" class="form-label">Sản phẩm đặc sắc</label>
                        <select class="form-select" aria-label="Sản phẩm đặc sắc"
                            wire:model='is_featured'
                        >
                            <option selected>Mở danh mục chọn</option>
                            <option value="Featured">Có</option>
                            <option value="Not featured">Không</option>
                        </select>
                        @error('is_featured') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>
                    <!-- End product is featured -->

                    <div class="col-6">
                        <label for="is_option" class="form-label">Sản phẩm biến thể</label>
                        <select class="form-select" aria-label="Sản phẩm biến thể" name = "is_option"
                        >
								<option value="Have option">Có</option>
								<option value="No option" selected>Không</option>
                        </select>
                    </div>
                    <!-- End product have option -->

                    <div id="noOptionPrice" class="col-6">
                        <label for="noOptionPrice" class="form-label">Giá sản phẩm</label>
                        <div class="input-group">
                            <input type="number" class="form-control" placeholder="10000000" name="noOptionPrice"
                                wire:model="noOptionPrice"
                            >
                            <span class="input-group-text">đ</span>
                            @error('noOptionPrice') 
                                <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- End product price -->

                    <div wire:ignore id="productHaveOption" class="col-12">
						<input type="hidden" id = "productOptionDetail" name="productOptionDetail" wire:model="productOptionDetail">
                        <table id="tblProductOption" class="table productOptions" style="width: 100%">
                            <thead>
                                <tr>
                                    <th width="7%" scope="col">STT</th>
                                    <th width="25%" scope="col">Tên</th>
                                    <th width="58%" scope="col">Giá trị</th>
                                    <th width="10%" scope="col" class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row"><input type="hidden" name="deleted[]"><span class="num">1</span></td>
                                    <td> 
                                        <input type="text" name="optionName" class="form-control optionName">
                                    </td>
                                    <td>
                                        <input type="text" name="optionDetail" class="optionDetail" placeholder="Thêm biến thể" 
                                            value="Biến thể" />
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btnDelRow">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <line x1="4" y1="7" x2="20" y2="7" />
                                                <line x1="10" y1="11" x2="10" y2="17" />
                                                <line x1="14" y1="11" x2="14" y2="17" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">
                                        <button type="button" class="btnAddRow btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <line x1="12" y1="5" x2="12" y2="19" />
                                                <line x1="5" y1="12" x2="19" y2="12" />
                                            </svg>
                                            Thêm biến thể
                                        </button>
                                    </th>
                                </tr>
                            </tfoot>
                            <tfoot class="template" style="display: none;">
                                <tr>
                                    <td scope="row"><input type="hidden" name="deleted[]"><span class="num">1</span></td>
                                    <td>
                                        <input type="text" name="optionName" class="form-control optionName">
                                    </td>
                                    <td>
                                        <input type="text" name="optionDetail" class="optionDetail" placeholder="Thêm biến thể" 
                                            value="Biến thể" />
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btnDelRow">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <line x1="4" y1="7" x2="20" y2="7" />
                                                <line x1="10" y1="11" x2="10" y2="17" />
                                                <line x1="14" y1="11" x2="14" y2="17" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="text-center" id="productOptionDetails">
                            <button type="button" class="btn btn-success btnCreateOption">Tạo biến thể</button>
                            <hr>
                            <input type="hidden" id = "optionPriceDetail" name="optionPriceDetail" wire:model="optionPriceDetail">
                            <table id="tblProductOptionDetails" class="table table-striped" style="display: none;">
                                <thead>
                                    <tr>
                                        <th width="5%" scope="col">#</th>
                                        <th width="40%" scope="col">Tên biến thể</th>
                                        <th width="55%" scope="col">Giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                <tfoot class="tblOptionTemplate" style="display: none;">
                                    <tr>
                                        <th class="optionNum" scope="row">1</th>
                                        <td class="optionName"></td>
                                        <td>
                                            <input type="text" class="form-control inputPrice" placeholder="Giá sản phẩm" name ="inputPrice[]">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <label for="newImage" class="form-label">Ảnh đại diện</label>
                        <input type="file" class="form-control" id="formFile"
                        	wire:model="newImage"
                        >

                        @if($newImage)
                            <div wire:loading wire:target="newImage">Đang tải...</div>
                            <img src="{{$newImage->temporaryUrl()}}" width="120" style="margin: 6px 0 0 0"/>
                        @else
                            @if ($image)
                            <img src="{{ asset('storage/uploads/products/'.$image) }}" width="120" style="margin: 6px 0 0 0"/>
                            @else
                            <img src="{{ asset('storage/uploads/no-image.jpg') }}" width="120" style="margin: 6px 0 0 0"/>
							@endif
                        @endif

                        @error('newImage') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-12">
						<label for="newImages" class="form-label">Thư viện ảnh</label>
						<input type="file" class="form-control" id="formFiles" multiple
							wire:model="newImages" 
						>
						
						@if($newImages)
							@if(count($newImages))
								@foreach($newImages as $img)
									<div wire:loading wire:target="newImages">Đang tải...</div>
									<img src="{{$img->temporaryUrl()}}" width="120" style="margin: 6px 0 0 0"/>
								@endforeach
							@endif
                        @else
                            @if ($images)
								@foreach($images as $img)
									<img src="{{ asset('storage/uploads/products/'.$img) }}" width="120" style="margin: 6px 0 0 0"/>
								@endforeach
                            @else
                           		<img src="{{ asset('storage/uploads/no-image.jpg') }}" width="120" style="margin: 6px 0 0 0"/>
							@endif
                        @endif

						@error('newImages') 
							<p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
						@enderror
                    </div>
                    <!-- End products image -->

                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Mô tả ngắn</label>
                        <textarea class = "simpleTextArea" placeholder="Mô tả ngắn"
                        wire:model="short_description"></textarea>

                        @error('short_description') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12" wire:ignore>
                        <label for="description" class="form-label">Chi tiết sản phẩm</label>
                        <textarea class = "simpleTextArea" placeholder="Chi tiết sản phẩm" id = "description"
                        wire:model="description"></textarea>

                        @error('description') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button type="reset" class="btn btn-secondary">Tạo lại</button>
                    </div>
                </form><!-- Vertical Form -->

                </div>
            </div>

            </div>
        </div>
    </section>
</main><!-- End #main -->

<style>
#tblProductOptionDetails .optionName, 
#tblProductOptionDetails thead th {
    text-align: left;
}

#tblProductOptionDetails tbody td {
    vertical-align: middle;
}
</style>

@push('scripts')
    <script src="{{ asset('assets/vendor/DynamicTable/DynamicTable.js') }}"></script>
    <script src="{{ asset('assets/js/ProductHelpers.js') }}"></script>

	<script>		
		let productOptionDetail = @json($productOptionDetail);
		let optionPrice = @json($optionPriceDetail);

		let countOptionDetail = Object.values(productOptionDetail);
		optionPrice = Object.values(optionPrice);

		if (countOptionDetail.length) {
			$('[name="is_option"]').val('Have option');

			let optionIndex = 1;

			setTimeout(() => {
				for (const element in productOptionDetail) {
					if (optionIndex > 1) {
						$('#productHaveOption').find('.btnAddRow').trigger('click');
					}

					$('#productHaveOption').find('tbody tr:last').find('.optionName').val(element);
					$('#productHaveOption').find('tbody tr:last').find('.optionDetail').val(productOptionDetail[element].join(','));

					optionIndex++;
				}
			}, 100);

			setTimeout(() => {
				$('.btnCreateOption').trigger('click');

				$('#tblProductOptionDetails').find('tbody .inputPrice').each(function(index, element) {
					$(this).val(parseInt(optionPrice[index]));
				})
			}, 900);

		}
	</script>

	<script>
		tinymce.init({
            selector: '#description',
            height: '480',
            forced_root_block: false,
            setup: function (editor) {
                editor.on('init change', function () {
                    editor.save();
                });
                editor.on('change', function (e) {
                    @this.set('description', editor.getContent());
                });
            }
        });
    </script>
@endpush