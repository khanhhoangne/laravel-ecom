<main id="main" class="main">

    <div class="pagetitle">
        <h1>Vai trò</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item"><a href="{{route('permissions')}}">Vai trò</a></li>
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
                        <h5 class="card-title">Thêm mới vai trò</h5>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('roles')}}" class="btn btn-primary btnRedirect">Tất cả vai trò</a>
                    </div>
                </div>

                <!-- Vertical Form -->
                <form class="row g-3" wire:submit.prevent = "storeRole">
                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Tên vai trò</label>
                        <input type="text" class="form-control" placeholder="Nhập tên vai trò" 
                        wire:model="name"
                        wire:keyup="generateslug"
                        >
                        @error('name') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Slug</label>
                        <input type="text" class="form-control" placeholder="Liên kết tĩnh"
                        wire:model="slug"
                        >
                        @error('slug') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Module quản lý</label>
                        <div class="col-12 d-flex flex-wrap">
                            @foreach($commands as $key => $command)
                            <div class="col-6">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="flexCheckDefault{{ $key }}"
                                        wire:click="handlePrintPermission({{$command}}, $event.target.checked)"
                                    >
                                    <label class="form-check-label" for="flexCheckDefault{{ $key }}">
                                        {{$command->name}}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    @foreach ($arrCommandId as $key => $command)
                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">{{ $command }}</label>
                        <div class="col-12 d-flex flex-wrap">
                            @foreach($permissions as $k => $permission)
                            <div class="col-6">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="checkDefaultPermission{{ $key }}{{ $k }}"
                                        wire:click="handlePermission({{$permission->id}}, {{$key}}, $event.target.checked)"
                                    >
                                    <label class="form-check-label" for="checkDefaultPermission{{ $k }}">
                                        {{$permission->name}}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

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