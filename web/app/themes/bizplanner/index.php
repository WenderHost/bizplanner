<?php
get_template_part( 'lib/partials/layout', 'head' );
get_template_part( 'lib/partials/layout', 'header' );
get_template_part( 'lib/partials/layout', 'sidebar' );
?>

  <main id="main" class="main">

    <?php if( is_user_logged_in() ): ?>
    <div class="pagetitle">
      <h1><?= get_the_title( $post ) ?></h1>
    </div><!-- End Page Title -->
    <?php endif; ?>

    <section class="section dashboard">
      <?php
      if( is_user_logged_in() ){
        echo '<div class="row">' . do_shortcode( '[new_business_plan_button]' ) . '</div>';
      } else {
        get_template_part( 'lib/partials/index', 'loginregister' );
      }
      ?>
    </section>

  </main><!-- End #main -->
<?php
get_template_part( 'lib/partials/layout', 'footer' );
?>
