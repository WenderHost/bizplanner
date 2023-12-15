<?php if( is_user_logged_in() && is_single() && 'question' == get_post_type() ): ?>
<!-- Footer -->
<style>
  #juniorachievement-blackandwhite-logo, #hollingsworth-logo{max-width: 120px;}
</style>
<footer id="footer" class="footer fixed-bottom d-print-none" style="padding: 0;">
  <div class="container-fluid text-center">
    <div class="row align-items-center row-nextprev" style="border-bottom: 2px solid #fff; padding: 1em;">
      <div class="col"><?= do_shortcode( '[nextprev type="previous"]' ) ?></div>
      <div class="col" style="color: #14448C;"><?= do_shortcode( '[page_numbers]' ) ?></div>
      <div class="col"><?= do_shortcode( '[nextprev type="next"]' ) ?></div>
    </div>
    <div class="row justify-content-center row-logos" style="padding: 1em 0;">
      <div class="col-2"><?php get_template_part( 'lib/partials/juniorachievement', 'blackandwhitelogo' ); ?></div>
      <div class="col-2"><?php get_template_part( 'lib/partials/hef', 'logowhite' ); ?></div>
    </div>
  </div>
</footer><!-- End Footer -->
<?php endif; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <!--<script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/apexcharts/apexcharts.min.js"></script>-->
  <script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!--<script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/chart.js/chart.umd.js"></script>-->
  <!--<script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/echarts/echarts.min.js"></script>-->
  <script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/quill/quill.min.js"></script>
  <!--<script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/simple-datatables/simple-datatables.js"></script>-->
  <!--<script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/tinymce/tinymce.min.js"></script>-->
  <!--<script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/php-email-form/validate.js"></script>-->

  <!-- Template Main JS File -->
  <script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/js/main.js"></script>
  <?php wp_footer() ?>
</body>
</html>