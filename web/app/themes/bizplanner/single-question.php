<?php
global $post;
get_template_part( 'lib/partials/layout', 'head' );
get_template_part( 'lib/partials/layout', 'header' );
get_template_part( 'lib/partials/layout', 'sidebar' );
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <div class="row">
        <div class="col">
          <h1><?= get_the_title( $post ) ?></h1>
          <nav>
            <ol class="breadcrumb d-print-none">
              <li class="breadcrumb-item"><a href="<?= home_url() ?>">Home</a></li>
              <li class="breadcrumb-item active"><?= do_shortcode( '[title_bar]' ) ?></li>
            </ol>
          </nav>
        </div>
        <div class="col text-end">
          <?php if( 'financial-plan' == $post->post_name ): ?>
          <a href="<?= home_url( 'print-business-plan' ) ?>" target="_blank" class="btn btn-primary"><i class="bi bi-printer"></i> Generate Business Plan</a>
          <?php endif; ?>
        </div>
      </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <?php
        $type = get_field( 'type', $post->ID );
        switch( $type ){
          case 'dashboard':
            ?>
            <style>
            #financial-plan h1{font-size: 1.6rem; margin: 0;}
            #financial-plan h2{font-size: 1.5rem; font-weight: bold; padding-top: .5em; border-top: 1px solid rgb(222, 226, 230);}
            #financial-plan h3{font-size: 1.2rem; font-weight: bold;}
            #financial-plan{padding-top: 1em;}
            #financial-plan .row{margin-bottom: 1rem;}
            </style>
            <?php
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
