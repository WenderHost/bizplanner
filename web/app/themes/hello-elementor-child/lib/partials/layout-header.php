  <?php
  $current_user = wp_get_current_user();
  $avatar_url = get_avatar_url( $current_user->user_email );
  ?>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center"<?php if( is_admin_bar_showing() ){ echo ' style="margin-top: 26px;"';} ?>>

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <svg width="32" id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><style>.st0{fill:#085b8a}.st1{fill:#0b7fc1}.st2{fill:#fff}</style><path class="st0" d="M211 223.7c0 5.5-4.5 10-10 10H67.4c-5.5 0-10-4.5-10-10V44.9c0-5.5 4.5-10 10-10H201c5.5 0 10 4.5 10 10v178.8z"/><path class="st1" d="M198.6 211.1c0 5.5-4.5 10-10 10H55c-5.5 0-10-4.5-10-10V32.3c0-5.5 4.5-10 10-10h133.6c5.5 0 10 4.5 10 10v178.8z"/><path class="st2" d="M181.8 52.4c0 4.1-3.6 7.5-8 7.5h-104c-4.4 0-8-3.4-8-7.5s3.6-7.5 8-7.5h104c4.4 0 8 3.3 8 7.5zM170.6 86.4c0 4.1-3.6 7.5-8 7.5H69.8c-4.4 0-8-3.4-8-7.5s3.6-7.5 8-7.5h92.8c4.4 0 8 3.4 8 7.5zM158 120.5c0 4.1-3.6 7.5-8 7.5H69.8c-4.4 0-8-3.4-8-7.5s3.6-7.5 8-7.5H150c4.4 0 8 3.3 8 7.5zM158 154.5c0 4.1-3.6 7.5-8 7.5H69.8c-4.4 0-8-3.4-8-7.5s3.6-7.5 8-7.5H150c4.4 0 8 3.4 8 7.5zM134.7 188.6c0 4.1-3.6 7.5-8 7.5h-57c-4.4 0-8-3.4-8-7.5s3.6-7.5 8-7.5h57c4.4 0 8 3.3 8 7.5z"/></svg>
        <span class="d-none d-lg-block">BizPlanner</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?= $avatar_url ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= $current_user->display_name ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $current_user->user_firstname ?> <?= $current_user->user_lastname ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= wp_logout_url( home_url() ) ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->