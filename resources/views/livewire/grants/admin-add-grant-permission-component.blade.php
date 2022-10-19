<main id="main" class="main">

    <div class="pagetitle">
        <h1>Cấp quyền</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item"><a href="{{route('grant-permissions')}}">Cấp quyền</a></li>
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
                        <h5 class="card-title">Tạo cấp quyền</h5>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('grant-permissions')}}" class="btn btn-primary btnRedirect">Tất cả cấp quyền</a>
                    </div>
                </div>

                <!-- Vertical Form -->
                <form class="row g-3" wire:submit.prevent = "storeGrantPermission">
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
                        wire:change="addPermission($event.target.value)"
                        wire:model="grantTemp"
                        >
                            <option selected>Danh sách chọn</option>
                            @foreach ($permissions as $permission)
                            <option value="{{$permission->id}}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        @error('grantIds') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                    </div>

                    @php
                    $i = 1;
                    @endphp
                    @foreach ($grantIds as $grantId)
                        @foreach ($permissions as $permission)
                        @if ($permission->id == $grantId)
                        <div class=""> 
                            <div class="col-12 d-flex text-align-center justify-content-between alert alert-primary my-0">
                                <div>Quyền {{$i}}: {{ $permission->name }}</div>
                                <div class="d-flex text-align-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i type="button" wire:click="removePermission({{ $permission->id }})" class="bi bi-trash text-danger"></i>
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