<aside id="sidebar" class="sidebar d-print-none" style="<?php if( is_admin_bar_showing() ){ echo 'margin-top: 26px;';} ?>">
  <?php
  if( is_user_logged_in() && is_single() && 'question' == get_post_type() ):
  echo do_shortcode( '[question_sidebar_nav]' );
  endif;
  ?>
</aside><!-- End Sidebar-->