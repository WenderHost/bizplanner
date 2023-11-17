<?php
global $current_business_plan;
$current_user = wp_get_current_user();
$current_user_id = get_current_user_id();
$avatar = get_user_meta( $current_user_id, 'avatar', true );
if( ! is_int( $avatar ) )
  $avatar = 0;
$avatar_url = BP_DIR_URI . 'lib/img/bizplanner-avatar_' . $avatar . '.png';
?>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center d-print-none"<?php if( is_admin_bar_showing() ){ echo ' style="margin-top: 26px;"';} ?>>

    <div class="d-flex align-items-center justify-content-between">
      <a href="<?= home_url() ?>" class="logo d-flex align-items-center">
        <?php get_template_part( 'lib/partials/bizplanner', 'icon' ) ?>
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

        <?php if( is_user_logged_in() ): ?>
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?= $avatar_url ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= $current_user->display_name ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6 style="text-align: left;"><?= $current_user->user_firstname ?> <?= $current_user->user_lastname ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <!--<li>
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
            </li>-->
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
        <?php endif; ?>

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->