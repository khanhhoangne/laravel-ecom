@php
$permissionsOfUser;
@endphp
@if (!empty(Config::get('permissions')))
    @if (!empty(Config::get('permissions')[Config::get('author.command.authorization')]))
    @php
    $permissionsOfUser = Config::get('permissions')[Config::get('author.command.authorization')];
    @endphp
    @endif
@endif
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Danh sách vai trò</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Danh sách vai trò</li>
                <li class="breadcrumb-item active"><a href="{{route('roles')}}">Tất cả</a></li>
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
                                <h5 class="card-title">Danh sách vai trò</h5>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($permissionsOfUser[Config::get('author.permission.create')]))
                                <a href="{{route('addrole')}}" class="btn btn-primary btnRedirect">Thêm mới vai trò</a>
                                @else
                                <a href="javascript:void(0)" class="btn btn-primary btnRedirect">Thêm mới vai trò</a>
                                @endif
                            </div>
                        </div>
                        

                        <!-- Table with stripped rows -->
                        <table class="table" id="listtable">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">#ID</th>
                                    <th width="20%" scope="col">Vai trò</th>
                                    <th width="15%" scope="col">Chi tiết</th>
                                    <th width="20%" scope="col">Slug</th>
                                    <th width="33%" scope="col">Module quản lý</th>
                                    <th width="7%" scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $role)
                                <tr class="listViewTableRow">   
                                    <th scope="row">{{$role->id}}</th>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        <i type="button" wire:click="getRoleDetailById({{$role->id}})" class="bi bi-eye-fill text-primary view-order-btn ms-4"></i>
                                    </td>
                                    <td>{{$role->slug}}</td>
                                    <td>
                                        @foreach ($roleHasCommands as $key => $item)
                                            @if ($key === $role->name)
                                            @foreach ($item as $value)
                                            <p class="mb-0">{{ $value }}</p>
                                            @endforeach
                                            @endif
                                        @endforeach
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
                                        <a href="{{ $canUpdate ? route('editrole', ['role_slug' => $role->slug]) : 'javascript:void(0)'}}" class="">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.delete')]))
                                        <a href="#"  
                                            wire:click.prevent="deleteConfirm({{$role->id}})"
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
                        {{ $roles->links() }}

                        <!-- End Table with stripped rows -->
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
                                    <form class="row g-3" wire:submit.prevent = "updateRole">
                                        <div class="col-12 d-flex">
                                            <div class="col-6 pe-2">
                                                <label for="inputNanme4" class="form-label">Tên vai trò</label>
                                                <input type="text" class="form-control" wire:model="name" disabled>
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
                                    @php
                                    $canUpdate = false;
                                    @endphp
                                    @if (!empty($permissionsOfUser[Config::get('author.permission.update')]))
                                    @php
                                    $canUpdate = true;
                                    @endphp
                                    @endif
                                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Đóng</button>
                                    <a href="{{ $canUpdate ? route('editrole', ['role_slug' => $slug]) : 'javascript:void(0)'}}" type="button" class="btn btn-primary">Chỉnh sửa</a>
                                </div>
                                </div>
                            </div>
                        </div>
                        @endif
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


