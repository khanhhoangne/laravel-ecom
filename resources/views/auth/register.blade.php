<x-guest-layout>
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Techdiz Admin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body" style="width:500px">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Tạo nhanh tài khoản</h5>
                  </div>
                  <x-jet-validation-errors class="mb-4" />
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="col-12 mb-2">
                      <label for="yourFullname" class="form-label">Họ và tên</label>
                      <div class="input-group has-validation">
                        <input type="text" name="name" class="form-control" id="frm-login-uname" required
                        :value="old('name')" autofocus>
                        <div class="invalid-feedback">Nhập Họ và tên</div>
                      </div>
                    </div>
                    <div class="col-12 mb-2">
                      <label for="yourEmail" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="frm-login-uname" required
                        :value="old('email')">
                        <div class="invalid-feedback">Nhập Email</div>
                      </div>
                    </div>
                    <div class="col-12 mb-2">
                      <label for="yourPassword" class="form-label">Mật khẩu</label>
                      <div class="input-group has-validation">
                        <input type="password" name="password" class="form-control" id="frm-login-uname" required
                        :value="old('password')" autocomplete="new-password">
                        <div class="invalid-feedback">Nhập mật khẩu</div>
                      </div>
                    </div>
                    <div class="col-12 mb-2">
                      <label for="yourPassword" class="form-label">Xác nhận mật khẩu</label>
                      <div class="input-group has-validation">
                        <input type="password" name="password_confirmation" class="form-control" id="frm-login-uname" required
                        :value="old('password_confirmation')" autocomplete="new-password">
                        <div class="invalid-feedback">Xác nhận mật khẩu</div>
                      </div>
                    </div>
                    <div class="col-12 mb-2">
                      <label for="yourPhone" class="form-label">Số điện thoại</label>
                      <div class="input-group has-validation">
                        <input type="text" name="phone" class="form-control" id="frm-login-uname" required
                        :value="old('phone')">
                        <div class="invalid-feedback">Nhập số điện thoại</div>
                      </div>
                    </div>
                    <div class="col-12 mb-2">
                      <label for="yourAddress" class="form-label">Địa chỉ</label>
                      <div class="input-group has-validation">
                        <input type="text" name="address1" class="form-control" id="frm-login-uname" required
                        :value="old('address1')">
                        <div class="invalid-feedback">Nhập Địa chỉ</div>
                      </div>
                    </div>
                    <div class="col-12 mb-2">
                      <label for="yourStatus" class="form-label">Trạng thái</label>
                      <div class="input-group has-validation">
                        <select class="form-control" name="status" :value="old('status')" required>
                            <option value="active">Hoạt động</option>
                            <option value="inactive">Không hoạt động</option>
                        </select>
                        <div class="invalid-feedback">Nhập Trạng thái</div>
                      </div>
                    </div>
                    <br>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Tạo nhanh</button>
                    </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->
</x-guest-layout>