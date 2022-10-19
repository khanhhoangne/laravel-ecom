<main id="main" class="main">

    <div class="pagetitle">
        <h1>Cấp quyền</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item"><a href="{{route('grant-permissions')}}">Cấp quyền</a></li>
                <li class="breadcrumb-item active">Cập nhật</li>
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
                        <h5 class="card-title">Cập nhật cấp quyền</h5>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('grant-permissions')}}" class="btn btn-primary btnRedirect">Tất cả cấp quyền</a>
                    </div>
                </div>

                <!-- Vertical Form -->
                <form class="row g-3" wire:submit.prevent = "updateGrantPermission">
                    <div class="col-12">
                        <label for="status" class="form-label">Quản trị viên</label>
                        <select class="form-select" aria-label="Trạng thái"
                        wire:model='user_id'
                        >
                            <option value="" selected>Danh sách chọn</option>
                            @foreach ($admins as $admin)
                            <option value="{{$admin->id}}">{{ $admin->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="status" class="form-label">Module quản lý</label>
                        <select class="form-select" aria-label="Trạng thái"
                        wire:model='command_id'
                        >
                            <option value="" selected>Danh sách chọn</option>
                            @foreach ($commands as $command)
                            <option value="{{$command->id}}">{{ $command->name }}</option>
                            @endforeach
                        </select>
                        @error('command_id') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="status" class="form-label">Quyền hạn</label>
                        <select class="form-select" aria-label="Trạng thái"
                        wire:model='permission_id'
                        >
                            <option value="" selected>Danh sách chọn</option>
                            @foreach ($permissions as $permission)
                            <option value="{{$permission->id}}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        @error('permission_id') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Ngày hết hạn</label>
                        <input type="datetime-local" class="form-control"
                        wire:model="expired_date"
                        >
                        @error('expired_date') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Mô tả</label>
                        <textarea class = "simpleTextArea" placeholder="Mô tả lý do cấp quyền"
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