<?php if( is_user_logged_in() && is_single() && 'question' == get_post_type() ): ?>
<!-- Footer -->
<footer id="footer" class="footer fixed-bottom d-print-none">
  <div class="container text-center">
    <div class="row align-items-center">
      <div class="col"><?= do_shortcode( '[nextprev type="previous"]' ) ?></div>
      <div class="col"><?= do_shortcode( '[page_numbers]' ) ?></div>
      <div class="col"><?= do_shortcode( '[nextprev type="next"]' ) ?></div>
    </div>
  </div>
</footer><!-- End Footer -->
<?php endif; ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/quill/quill.min.js"></script>
  <script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= BP_DIR_URI ?>lib/niceadmin/assets/js/main.js"></script>
  <?php wp_footer() ?>
</body>
</html>