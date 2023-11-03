<?php
get_template_part( 'lib/partials/layout', 'head' );
get_template_part( 'lib/partials/layout', 'header' );
get_template_part( 'lib/partials/layout', 'sidebar' );
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1><?= get_the_title( $post ) ?></h1>
      <nav>
        <ol class="breadcrumb">
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
          ?>
          <div class="col-lg-8">
            <div class="row">
            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Price Per Unit</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-gear"></i>
                    </div>
                    <div class="ps-3">
                      <h6>$12.50</h6>
                      <span class="text-muted small pt-2 ps-1"><em><?= $current_business_plan['product'] ?></em> (qty. 1)</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->
            </div>
          </div>
          <?php
            break;

          default:
          ?>
          <!-- BizPlanner Question Form -->
          <div class="col-12">
            <?= do_shortcode( '[question_form]' ) ?>
          </div><!-- .col-12 -->
          <?php
        }
        ?>
      </div><!-- .row -->
    </section>

  </main><!-- End #main -->
<?php
get_template_part( 'lib/partials/layout', 'footer' );
?>
