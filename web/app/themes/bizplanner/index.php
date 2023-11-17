<?php
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
            <?php
            if( is_user_logged_in() ){
              echo do_shortcode( '[new_business_plan_button]' ) ;
            } else {
              get_template_part( 'lib/partials/index', 'loginregister' );
            }
            ?>
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
