<?php
get_template_part( 'lib/partials/layout', 'head' );
get_template_part( 'lib/partials/layout', 'header' );
get_template_part( 'lib/partials/layout', 'sidebar' );
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1><?= get_the_title( $post ) ?></h1>
      <nav>
        <ol class="breadcrumb d-print-none">
          <li class="breadcrumb-item"><a href="<?= home_url() ?>">Home</a></li>
          <li class="breadcrumb-item active"><?= do_shortcode( '[title_bar]' ) ?></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <?php
        $type = get_field( 'type', $post->ID );
        switch( $type ){
          case 'dashboard':
            get_template_part( 'lib/partials/question', 'dashboard' );
            break;

          default:
            get_template_part( 'lib/partials/question', 'form' );
        }
        ?>
      </div><!-- .row -->
    </section>

  </main><!-- End #main -->
<?php
get_template_part( 'lib/partials/layout', 'footer' );
?>
