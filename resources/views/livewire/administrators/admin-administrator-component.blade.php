@php
$permissionsOfUser;
@endphp
@if (!empty(Config::get('permissions')))
    @if (!empty(Config::get('permissions')[Config::get('author.command.admin')]))
    @php
    $permissionsOfUser = Config::get('permissions')[Config::get('author.command.admin')];
    @endphp
    @endif
@endif
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Danh sách quản trị viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Danh sách quản trị viên</li>
                <li class="breadcrumb-item active"><a href="{{route('administrators')}}">Tất cả</a></li>
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
                                <h5 class="card-title">Danh sách quản trị viên</h5>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($permissionsOfUser[Config::get('author.permission.create')]))
                                <a href="{{route('addadministrator')}}" class="btn btn-primary btnRedirect">Thêm mới quản trị viên</a>
                                @else
                                <a href="javascript:void(0)" class="btn btn-primary btnRedirect">Thêm mới quản trị viên</a>
                                @endif
                            </div>
                        </div>
                        

                        <!-- Table with stripped rows -->
                        <table class="table" id="listtable">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">#ID</th>
                                    <th width="13%" scope="col">Ảnh đại diện</th>
                                    <th width="15%" scope="col">Tên</th>
                                    <th width="10%" scope="col">Username</th>
                                    <th width="20%" scope="col">Vị trí</th>
                                    <th width="15%" scope="col">Vai trò</th>
                                    <th width="15%" scope="col">Email</th>
                                    <th width="7%" scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($admins as $admin)
                                <tr class="listViewTableRow">   
                                    <th scope="row">{{$admin->id}}</th>
                                    <td>
                                        <img src="{{ $admin->profile_photo_path ? asset('storage/uploads/users/'.$admin->profile_photo_path) : asset('storage/uploads/no-image.jpg') }}" alt="{{$admin->name}}" width = "60"/>
                                    </td>
                                    <td>{{$admin->name}}</td>
                                    <td>{{$admin->username}}</td>
                                    <td>{{$admin->job_title}}</td>
                                    <td>
                                        @foreach ($admin->userHasRoles as $item)
                                            <p class="mb-0">{{ $item->role->name }}</p>
                                        @endforeach 
                                    </td>
                                    <td>{{$admin->email}}</td>
                                    <td  class="listViewAction">
                                        @php
                                        $canUpdate = false;
                                        @endphp
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.update')]))
                                        @php
                                        $canUpdate = true;
                                        @endphp
                                        @endif
                                        <a href="{{ $canUpdate ? route('editadministrator', ['id' => $admin->id]) : 'javascript:void(0)'}}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.delete')]))
                                        <a href="#"  
                                            wire:click.prevent="deleteConfirm({{$admin->id}})"
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
                        {{ $admins->links() }}

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


