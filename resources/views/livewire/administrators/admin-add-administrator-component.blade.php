<main id="main" class="main">

    <div class="pagetitle">
        <h1>Quản trị viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item"><a href="{{route('administrators')}}">Quản trị viên</a></li>
                <li class="breadcrumb-item active">Thêm mới quản trị viên</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">

            <div class="card">
                <div class="card-body">
                <div class="row rowHeader">
                    <div class="col-md-6">
                        <h5 class="card-title">Thêm mới quản trị viên</h5>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('administrators')}}" class="btn btn-primary btnRedirect">Tất cả quản trị viên</a>
                    </div>
                </div>

                <!-- Vertical Form -->
                <form class="row g-3" wire:submit.prevent = "storeAdmin">
                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Tên quản trị viên</label>
                        <input type="text" class="form-control" placeholder="Nhập tên quản trị viên" 
                        wire:model="name"
                        >
                        @error('name') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Username</label>
                        <input type="text" class="form-control" placeholder="Username"
                        wire:model="username"
                        >
                        @error('username') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" placeholder="Mật khẩu"
                        wire:model="password"
                        >
                        @error('password') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Email</label>
                        <input type="text" class="form-control" placeholder="Email"
                        wire:model="email"
                        >
                        @error('email') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" placeholder="Số điện thoại"
                        wire:model="phone"
                        >
                        @error('phone') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Vị trí</label>
                        <input type="text" class="form-control" placeholder="Vị trí"
                        wire:model="job_title"
                        >
                        @error('job_title') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" aria-label="Trạng thái"
                        wire:model='status'
                        >
                            <option selected value="1">Hoạt động</option>
                            <option value="0">Ngừng hoạt động</option>
                        </select>
                    </div>

                    <div class="col-6">
                        <label for="status" class="form-label">Quản lý</label>
                        <select class="form-select" aria-label="Trạng thái"
                        wire:model='manager_id'
                        >
                            <option value="" selected>Danh sách chọn</option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6">
                        <label for="status" class="form-label">Vai trò</label>
                        <select class="form-select" aria-label="Trạng thái"
                        wire:change="addRole($event.target.value)"
                        wire:model="roleTemp"
                        >
                            <option selected>Danh sách chọn</option>
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('roleIds') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>
                    @php
                    $i = 1;
                    @endphp
                    @foreach ($roleIds as $roleId)
                        @foreach ($roles as $role)
                        @if ($role->id == $roleId)
                        <div class=""> 
                            <div class="col-9 d-flex text-align-center justify-content-between alert alert-primary my-0">
                                <div>Vai trò {{$i}}: {{ $role->name }}</div>
                                <div class="d-flex text-align-center">
                                    <div class="d-flex align-items-center justify-content-center me-2">
                                        <i type="button" wire:click="getRoleDetailById({{ $role->id }})" class="bi bi-eye-fill text-primary view-order-btn ms-4"></i>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i type="button" wire:click="removeRole({{ $role->id }})" class="bi bi-trash text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                        $i++
                        @endphp
                        @endif
                        @endforeach
                    @endforeach

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Thêm</button>
                        <button class="btn btn-danger">
                            <a class="cancelColor" href="{{route('administrators')}}">Hủy bỏ</a>
                        </button>
                    </div>
                </form><!-- Vertical Form -->

                @if ($show)
                <div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block; background-color: rgb(0 0 0 / 33%);">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Chi tiết vai trò</h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="bi bi-x-lg"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3">
                                <div class="col-12 d-flex">
                                    <div class="col-6 pe-2">
                                        <label for="inputNanme4" class="form-label">Tên vai trò</label>
                                        <input type="text" class="form-control" wire:model="nameRole" disabled>
                                    </div>

                                    <div class="col-6">
                                        <label for="inputNanme4" class="form-label">Slug</label>
                                        <input type="text" class="form-control" wire:model="slug" disabled >
                                    </div>
                                </div>

                                @foreach ($arrCommandId as $key => $command)
                                <div class="col-12">
                                    <label for="inputNanme4" class="form-label">{{ $command }}</label>
                                    <div class="col-12 d-flex flex-wrap">
                                        @php
                                        $arrPermissionByCommand = [];
                                        @endphp
                                        @if (!empty($arrPermissionId[$key]))
                                        @php
                                        $arrPermissionByCommand = $arrPermissionId[$key];
                                        @endphp
                                        @endif
                                        @foreach($permissions as $k => $permission)
                                        <div class="col-6">
                                            <div class="form-check">
                                                @php
                                                    $checked = false;
                                                @endphp
                                                @foreach ($arrPermissionByCommand as $t => $per)
                                                @if ($permission->id === $per['permission_id'])
                                                @php
                                                    $checked = true;
                                                @endphp
                                                @endif
                                                @endforeach
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    id="checkDefaultPermission{{ $key }}{{ $k }}"
                                                    {{ $checked === true ? 'checked' : '' }}
                                                    disabled
                                                    style="opacity: 0.8"
                                                    
                                                >
                                                <label class="form-check-label" for="checkDefaultPermission{{ $k }}" style="opacity: 0.8;">
                                                    {{$permission->name}}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </form><!-- Vertical Form -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Đóng</button>
                            <a href="{{route('editrole', ['role_slug' => $slug])}}" type="button" class="btn btn-primary">Chỉnh sửa</a>
                        </div>
                        </div>
                    </div>
                </div>
                @endif
                </div>
                </div>
            </div>

            </div>
        </div>
    </section>
</main><!-- End #main -->

