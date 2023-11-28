<?php

namespace BizPlanner\makepdf;
use function BizPlanner\templates\{render_template};

function custom_pdf_route(){
  add_rewrite_rule( '^print-business-plan/?', 'index.php?print-business-plan=true', 'top' );
}
add_action( 'init', __NAMESPACE__ . '\\custom_pdf_route' );

function custom_query_vars( $vars ) {
  $vars[] = 'print-business-plan';
  return $vars;
}
add_filter('query_vars', __NAMESPACE__ . '\\custom_query_vars' );

function generate_content(){

}

function custom_pdf_output() {
  if ( get_query_var( 'print-business-plan' ) ) {
    // Generate PDF content
    global $current_business_plan;
    $stylesheet_1 = file_get_contents( BP_DIR . 'lib/niceadmin/assets/vendor/bootstrap/css/bootstrap.min.css' );
    $stylesheet_2 = file_get_contents( BP_DIR . 'lib/niceadmin/assets/css/style.css' );
    $stylesheet_3 = 'body{background-color: #fff; font-size: 12px;}';

    $data = [];
    $data['current_business_plan'] = $current_business_plan;
    $data['logo'] = BP_DIR_URI . 'lib/img/ex_logo.jpg';
    $html = render_template('financial-plan-table', $data );

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->setBasePath( home_url( 'print-business-plan/' ) );
    $mpdf->WriteHTML( $stylesheet_1 . $stylesheet_2 . $stylesheet_3, \Mpdf\HTMLParserMode::HEADER_CSS );
    $mpdf->WriteHTML( $html, \Mpdf\HTMLParserMode::HTML_BODY );

    $filename = sanitize_title( $current_business_plan['user']['firstname'] . '-' . $current_business_plan['user']['lastname'] . '_business-plan' );
    $mpdf->Output( $filename, 'I' );
    exit();
  }
}
add_action('template_redirect', __NAMESPACE__ . '\\custom_pdf_output');
