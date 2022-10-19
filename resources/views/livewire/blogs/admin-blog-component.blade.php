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
        <h1>Bài viết</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Bài viết</li>
                <li class="breadcrumb-item active"><a href="{{route('blogs')}}">Tất cả</a></li>
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
                                <h5 class="card-title">Danh sách Bài viết</h5>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($permissionsOfUser[Config::get('author.permission.create')]))
                                <a href="{{route('addblog')}}" class="btn btn-primary btnRedirect">Thêm mới bài viết</a>
                                @else
                                <a href="javascript:void(0)" class="btn btn-primary btnRedirect">Thêm mới bài viết</a>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Table with stripped rows -->
                        <table class="table" id="listtable">
                            <thead>
                                <tr>
                                    <th width="8%" scope="col">#ID</th>
                                    <th width="15%" scope="col">Ảnh tiêu đề</th>
                                    <th width="25%" scope="col">Tiêu đề bài viết</th>
									<th width="15%" scope="col">Danh mục</th>
                                    <th width="20%" scope="col">Trạng thái</th>
                                    <th width="10%" scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($blogs as $blog)
                                <tr class="listViewTableRow">
                                    <th scope="row">{{$blog->id}}</th>
                                    <td>
                                    	<img src="{{ $blog->thumbnail ? asset('storage/uploads/blogs/'.$blog->thumbnail) : asset('storage/uploads/no-image.jpg') }}" alt="{{$blog->title}}" width = "60"/>
                                    </td>
                                    <td>{{$blog->title}}</td>
									<td>
                                        @foreach ($blog->blogDetails as $detail)
                                        <p class="mb-0">{{ $detail->blogCategory->name }}</p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($blog->status == '1')
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
                                        <a href="{{ $canUpdate ? route('editblog', ['blog_slug' => $blog->slug]) : 'javascript:void(0)'}}" class="">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.delete')]))
                                        <a href="#"  
                                            wire:click.prevent="deleteConfirm({{$blog->id}})"
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

                        {{$blogs->links()}}
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
