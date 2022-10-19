<main id="main" class="main">
    <div class="pagetitle">
      <h1>Thông tin cá nhân</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
          <li class="breadcrumb-item">Quản trị viên</li>
          <li class="breadcrumb-item active">Thông tin cá nhân</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="{{ $user->profile_photo_path ? asset('storage/uploads/users/'.$user->profile_photo_path) : asset('assets/img/noavatar.png') }}" alt="Profile" class="rounded-circle">
              <h2>{{ $user->name }}</h2>
              <h3>{{ $user->job_title }}</h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link {{ $active_tab === 0 ? 'active' : ''}}" wire:click="updateTab(0)">Thông tin chung</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link {{ $active_tab === 1 ? 'active' : ''}}" wire:click="updateTab(1)">cập nhật thông tin</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link {{ $active_tab === 2 ? 'active' : ''}}" wire:click="updateTab(2)">Cài đặt</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link {{ $active_tab === 3 ? 'active' : ''}}" wire:click="updateTab(3)">Đổi mật khẩu</button>
                </li>

              </ul>
              <div class="tab-content pt-2">
                
                @if ($active_tab === 0)
                <div class="tab-pane show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Về bản thân</h5>
                  <p class="small fst-italic">{{ isset($user->bio) ? $user->bio : '' }}</p>

                  <h5 class="card-title">Thông tin chi tiết</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Họ và tên</div>
                    <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Username</div>
                    <div class="col-lg-9 col-md-8">{{ $user->username }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Vị trí</div>
                    <div class="col-lg-9 col-md-8">{{ $user->job_title }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Địa chỉ</div>
                    <div class="col-lg-9 col-md-8">{{ $user->address1 }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Số điện thoại</div>
                    <div class="col-lg-9 col-md-8">{{ $user->phone }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                  </div>

                  <h5 class="card-title">Vai trò</h5>

                  @php
                  $i = 1;
                  @endphp
                  @foreach ($roleIds as $roleId)
                      @foreach ($roles as $role)
                      @if ($role->id == $roleId)
                      <div class="mb-2"> 
                          <div class="col-12 d-flex text-align-center justify-content-between alert alert-primary my-0">
                              <div>Vai trò {{$i}}: {{ $role->name }}</div>
                              <div class="d-flex text-align-center">
                                  <div class="d-flex align-items-center justify-content-center me-2">
                                      <i type="button" wire:click="getRoleDetailById({{ $role->id }})" class="bi bi-eye-fill text-primary view-order-btn ms-4"></i>
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

                </div>
                @endif

                @if ($active_tab === 1)
                <div class="tab-pane show active profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form wire:submit.prevent = "updateAdmin">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Ảnh đại diện</label>
                      <div class="col-md-8 col-lg-9">
                        @if($newImage)
                            <div wire:loading wire:target="newThumbnail">Đang tải...</div>
                            <img src="{{$newImage->temporaryUrl()}}" alt="Profile" class="rounded-circle"/>
                        @else
                            <img src="{{ $user->profile_photo_path ? asset('storage/uploads/users/'.$user->profile_photo_path) : asset('assets/img/noavatar.png') }}" alt="Profile" class="rounded-circle">
                        @endif
                        <div class="pt-2">
                          <input type="file" class="form-control" id="avatar" name="avatar"
                            wire:model="newImage" style="opacity: 0;overflow: hidden;position: absolute;z-index: 1;width: 5px"
                          >
                          <a class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload" for="avatar"></i></a>
                          <a wire:click="removeAvatar" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Họ và tên</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fullName" type="text" class="form-control" id="fullName" wire:model="name">
                        @error('name') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="about" class="col-md-4 col-lg-3 col-form-label">Giới thiệu</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea name="about" class="form-control" id="about" style="height: 100px">Giới thiệu bản thân.</textarea>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="company" type="text" class="form-control" id="company" wire:model="username">
                        @error('username') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Vị trí</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="job" type="text" class="form-control" id="Job" wire:model="job_title">
                        @error('job_title') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                      </div>
                    </div>

                    <!-- <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="country" type="text" class="form-control" id="Country" value="USA">
                      </div>
                    </div> -->

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Địa chỉ</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="address" type="text" class="form-control" id="Address" wire:model="address">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Số điện thoại</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control" id="Phone" wire:model="phone">
                        @error('phone') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="Email" wire:model="email">
                        @error('email') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                      </div>
                    </div>

                    <!-- <div class="row mb-3">
                      <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="twitter" type="text" class="form-control" id="Twitter" value="https://twitter.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="facebook" type="text" class="form-control" id="Facebook" value="https://facebook.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="instagram" type="text" class="form-control" id="Instagram" value="https://instagram.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="linkedin" type="text" class="form-control" id="Linkedin" value="https://linkedin.com/#">
                      </div>
                    </div> -->

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>
                @endif

                @if ($active_tab === 2)
                <div class="tab-pane show active pt-3" id="profile-settings">

                  <!-- Settings Form -->
                  <!-- <form>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                      <div class="col-md-8 col-lg-9">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="changesMade" checked>
                          <label class="form-check-label" for="changesMade">
                            Changes made to your account
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="newProducts" checked>
                          <label class="form-check-label" for="newProducts">
                            Information on new products and services
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="proOffers">
                          <label class="form-check-label" for="proOffers">
                            Marketing and promo offers
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                          <label class="form-check-label" for="securityNotify">
                            Security alerts
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form> -->
                  <!-- End settings Form -->
                  <p>Tính năng đang xây dựng ...</p>

                </div>
                @endif

                @if ($active_tab === 3)
                <div class="tab-pane show active pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form wire:submit.prevent = "updatePassword">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Mật khẩu hiện tại</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword" wire:model="password">
                        @error('password') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Mật khẩu mới</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword" wire:model="new_password">
                        @error('new_password') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Nhập lại mật khẩu mới</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword" wire:model="renew_password">
                        @error('renew_password') 
                            <p class="text-danger" style="margin: 6px 0 0 0">{{$message}}</p>
                        @enderror
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Thay đổi mật khẩu</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>
                @endif

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

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
                  </div>
                  </div>
              </div>
          </div>
          @endif

        </div>
      </div>
    </section>

</main><!-- End #main -->
