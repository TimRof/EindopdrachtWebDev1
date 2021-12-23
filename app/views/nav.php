<div id="page-container">
    <div id="content-wrap">
        <!-- Navbar -->
        <nav class="navbar navbar-light justify-content-between mb-3" id="topnavbar">
            <a class="navbar-brand me-2" href="/">
                <img id="homeLogo" src="/assets/img/bunnylogo.png" alt="The Hare Company Logo" loading="lazy" />
                <span class="ml-5" id="homeNav">The Hare Company</span>
            </a>
            <div class="justify-content-between">
                <ul class="nav ml-auto w-100 justify-content-end">
                    <li class="nav-item">
                        <button class="login-btn btn btn-link px-3 me-2" data-toggle="modal" data-target="#loginModal" role="button">Login</button>
                    </li>
                    <li class="nav-item">
                        <a href="/signup" class="btn btn-primary me-3 rounded-pill" role="button">Sign up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="basic-color badge badge-pill rounded-circle"></span>
                            <span><i class="basic-color fa-solid fa-cart-shopping" style="font-size: 1.5em;"></i></span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="modal fade bd-example-modal-sm basic-color" id="loginModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Login</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="email-addon"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" class="form-control" placeholder="Email address" id="email1" name="email" aria-label="Email" aria-describedby="email-addon">
                            </div>
                            <div class="input-group">
                                <span class="input-group-text" id="password-addon"><i class="fa-solid fa-key"></i></span>
                                <input type="password" class="form-control" placeholder="Password" id="password1" name="password" aria-label="Password" aria-describedby="password-addon">
                            </div>
                            <div class="input-group mt-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3 login_container">
                                <button type="button" class="btn btn-primary login_btn">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <div class="signup-section">Not a member yet? <a href="/signup/"> Sign Up</a>.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navbar -->