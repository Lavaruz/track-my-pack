<div class="nav-list">
    <a href="#" role="button" id="login-button" class="navbar-btn">Sign-in <i id="sign-caret" class="fas fa-caret-down"></i></a>
</div>
<div class="login-form" id="login-form">
    <form id="f1">
        <div class="login-form-header">
            <p style="margin: 0px;">Login Form</p>
            <p style="font-size: small;">Masukan kredensial akun anda untuk masuk</p>
        </div>
        <hr style="margin-bottom: 1rem" />
        <div class="input-form">
            <div class="row form-group">
                <div class="col-4">
                    <label for="username">Username: </label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control" name="username" id="login_username" placeholder="Masukan username" />
                </div>
            </div>
            <div class="row form-group">
                <div class="col-4">
                    <label for="password">Password: </label>
                </div>
                <div class="col-8">
                    <input type="password" class="form-control" name="password" id="login_password" placeholder="Masukan password" />
                </div>
            </div>
        </div>
        <button type="button" id="login_submit" class="login-btn float-end">Login</button>
    </form>
</div>