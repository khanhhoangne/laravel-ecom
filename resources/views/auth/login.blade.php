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

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Đăng nhập tài khoản quản trị</h5>
                    <p class="text-center small">Nhập tên đăng nhập và mật khẩu của bạn</p>
                  </div>
                  <x-jet-validation-errors class="mb-4" />
                  <form name="frm-login" method = "POST" class="row g-3 needs-validation" action="{{route('login')}}">
                    @csrf
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="frm-login-uname" required
                        :value="old('email')" autofocus>
                        <div class="invalid-feedback">Nhập Email</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Mật khẩu</label>
                      <input type="password" name="password" class="form-control" id="frm-login-pass" required autocomplete="current-password">
                      <div class="invalid-feedback">Nhập mật khẩu!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Đăng nhập</button>
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