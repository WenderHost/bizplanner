<?php
use function BizPlanner\templates\{render_template};

if( ! is_user_logged_in() )
  wp_redirect( home_url() );

get_template_part( 'lib/partials/layout', 'head' );
get_template_part( 'lib/partials/layout', 'header' );
get_template_part( 'lib/partials/layout', 'sidebar' );
?>
<style>
  #juniorachievement-logo, #hollingsworth-logo{max-width: 170px;}
</style>
  <main id="main" class="main">

    <?php if( is_user_logged_in() ): ?>
    <div class="pagetitle">
      <h1><?= get_the_title( $post ) ?></h1>
    </div><!-- End Page Title -->
    <?php endif; ?>

    <section class="section dashboard">
        <div class="row">
          <div class="col-6">
            <?php
            $current_user = wp_get_current_user();
            $data = [
              'firstname'   => $current_user->user_firstname,
              'lastname'    => $current_user->user_lastname,
              'username'    => $current_user->user_login,
              'grade'       => get_user_meta( $current_user->ID, 'grade', true ),
              'school'      => get_user_meta( $current_user->ID, 'school', true ),
              'avatar'      => get_user_meta( $current_user->ID, 'avatar', true ),
              'bp_dir_uri'  => BP_DIR_URI,
              'avatars'     => [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
            ];
            echo render_template( 'registration-and-profile-form', $data );
            ?>
          </div>
        </div>
        <div class="row text-center">
          <div class="col" style="border-top: 1px solid #cdcdcd; padding-top: 1rem; margin-top: 3rem;">
            <p style="font-size: .8rem; color: #999;">&copy; Copyright <?= date('Y') ?> The Hollingsworth Companies. All rights reserved.</p>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-2 text-end"><?php get_template_part( 'lib/partials/juniorachievement', 'logo' ); ?></div>
          <div class="col-2 text-start"><?php get_template_part( 'lib/partials/hollingsworth', 'logo' ); ?></div>
        </div>
    </section>

  </main><!-- End #main -->
<?php
get_template_part( 'lib/partials/layout', 'footer' );
?>
