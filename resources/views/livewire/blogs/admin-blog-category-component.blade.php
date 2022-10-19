@php
$permissionsOfUser;
@endphp
@if (!empty(Config::get('permissions')))
    @if (!empty(Config::get('permissions')[Config::get('author.command.blog')]))
    @php
    $permissionsOfUser = Config::get('permissions')[Config::get('author.command.blog')];
    @endphp
    @endif
@endif
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Danh mục bài viết</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Danh mục bài viết</li>
                <li class="breadcrumb-item active"><a href="{{route('blogcategories')}}">Tất cả</a></li>
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
                                <h5 class="card-title">Danh sách danh mục bài viết</h5>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($permissionsOfUser[Config::get('author.permission.create')]))
                                <a href="{{route('addblogcategory')}}" class="btn btn-primary btnRedirect">Thêm mới danh mục bài viết</a>
                                @else
                                <a href="javascript:void(0)" class="btn btn-primary btnRedirect">Thêm mới danh mục bài viết</a>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Table with stripped rows -->
                        <table class="table" id="listtable">
                            <thead>
                                <tr>
                                    <th width="8%" scope="col">Thứ tự</th>
                                    <th width="15%" scope="col">Banner</th>
                                    <th width="20%" scope="col">Tên danh mục</th>
									<th width="20%" scope="col">Thuộc danh mục</th>
                                    <th width="20%" scope="col">Trạng thái</th>
                                    <th width="10%" scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1
                            @endphp
                            @foreach ($blogCategories as $category)
                                <tr class="listViewTableRow">
                                    <th scope="row">{{$i}}</th>
                                    <td>
                                    <img src="{{ $category->banner ? asset('storage/uploads/blogcategories/'.$category->banner) : asset('storage/uploads/no-image.jpg') }}" alt="{{$category->name}}" width = "60"/>
                                    </td>
                                    <td>{{$category->name}}</td>
									<td>
										@if ($category->parent_id)
											{{$getParentName($category->parent_id)}}
										@endif
									</td>
                                    <td>
                                        @if ($category->status == '1')
                                            Hoạt động
                                        @else
                                            Ngừng hoạt động
                                        @endif
                                    </td>
                                    <td  class="listViewAction">
                                        @php
                                        $canUpdate = false;
                                        @endphp
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.update')]))
                                        @php
                                        $canUpdate = true;
                                        @endphp
                                        @endif
                                        <a href="{{ $canUpdate ? route('editblogcategory', ['category_slug' => $category->slug]) : 'javascript:void(0)'}}" class="">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.delete')]))
                                        <a href="#"  
                                            wire:click.prevent="deleteConfirm({{$category->id}})"
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
                                $i++
                            @endphp

                            @endforeach

                            </tbody>
                        </table>

                        {{$blogCategories->links()}}
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

@push('scripts')
    <!-- <script>
        Livewire.restart();
    </script> -->
@endpush
