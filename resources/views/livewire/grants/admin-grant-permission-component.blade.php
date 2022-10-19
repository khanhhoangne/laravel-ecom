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
        <h1>Cấp quyền</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Cấp quyền</li>
                <li class="breadcrumb-item active"><a href="{{route('grant-permissions')}}">Tất cả</a></li>
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
                                <h5 class="card-title">Danh sách cấp quyền</h5>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($permissionsOfUser[Config::get('author.permission.create')]))
                                <a href="{{route('add-grant-permissions')}}" class="btn btn-primary btnRedirect">Thêm mới cấp quyền</a>
                                @else
                                <a href="javascript:void(0)" class="btn btn-primary btnRedirect">Thêm mới cấp quyền</a>
                                @endif
                            </div>
                        </div>
                        

                        <!-- Table with stripped rows -->
                        <table class="table" id="listtable">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">#ID</th>
                                    <th width="15%" scope="col">Tên</th>
                                    <th width="20%" scope="col">Module quản lý</th>
                                    <th width="10%" scope="col">Quyền hạn</th>
                                    <th width="23%" scope="col">Mô tả</th>
                                    <th width="20%" scope="col">Ngày hết hạn</th>
                                    <th width="7%" scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
            
                            @foreach ($grantPermissions as $grant)
                                <tr class="listViewTableRow">
                                    <th scope="row">{{$grant->id}}</th>
                                    <td>
                                        {{$grant->user->username}}
                                    </td>
                                    <td>{{$grant->command->name}}</td>
                                    <td>{{$grant->permission->name}}</td>
                                    <td>{{$grant->description}}</td>
                                    <td>{{$grant->expired_date}}</td>
                                    <td  class="listViewAction">
                                        @php
                                        $canUpdate = false;
                                        @endphp
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.update')]))
                                        @php
                                        $canUpdate = true;
                                        @endphp
                                        @endif
                                        <a href="{{ $canUpdate ? route('edit-grant-permissions', ['grant_id' => $grant->id]) : 'javascript:void(0)'}}" class="">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if (!empty($permissionsOfUser[Config::get('author.permission.delete')]))
                                        <a href="#"  
                                            wire:click.prevent="deleteConfirm({{$grant->id}})"
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

                        {{$grantPermissions->links()}}
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
