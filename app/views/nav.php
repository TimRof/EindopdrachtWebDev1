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
                    <?php if (!isset($_SESSION['user_id'])) : ?>
                        <li class="nav-item">
                            <a href="/login" class="btn login-btn btn-link px-3 me-2" role="button">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="/signup" class="btn btn-primary me-3 rounded-pill" role="button">Sign up</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="/logout" class="btn btn-primary me-3 rounded-pill" role="button">Logout</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="basic-color badge badge-pill rounded-circle"></span>
                            <span><i class="basic-color fa-solid fa-cart-shopping" style="font-size: 1.5em;"></i></span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>


        <!-- Navbar -->