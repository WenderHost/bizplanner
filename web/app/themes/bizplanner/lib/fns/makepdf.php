<?php

namespace BizPlanner\makepdf;

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
    $post = get_page_by_path( 'view/' );
    $pluginElementor = \Elementor\Plugin::instance();

    ob_start();
    wp_head();
    $html = ob_get_clean();

    $html.= $pluginElementor->frontend->get_builder_content($post->ID);

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->setBasePath( home_url( 'print-business-plan/' ) );
    $mpdf->WriteHTML($html);

    $mpdf->Output( 'myfile.pdf', 'D' );

    //// Set headers for PDF download
    //header('Content-Type: application/pdf');
    //header('Content-Disposition: attachment; filename="custom-pdf.pdf"');

    //// Output PDF content to the browser
    //echo $pdfContent;
    exit();
  }
}
add_action('template_redirect', __NAMESPACE__ . '\\custom_pdf_output');
