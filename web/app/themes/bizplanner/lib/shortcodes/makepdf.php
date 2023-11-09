<?php
namespace BizPlanner\shortcodes;

function makepdf( $atts ){

  $url = home_url( 'view/' );

  if( ini_get( 'allow_url_fopen' ) ){
    $args = [
      'ssl' => [
        'verify_peer'       => false,
        'verify_peer_name'  => false,
      ],
    ];
    $html = file_get_contents( $url, false, stream_context_create( $args ) );
  } else {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt ( $ch , CURLOPT_RETURNTRANSFER , 1 );
    $html = curl_exec($ch);
    curl_close($ch);
  }

  $mpdf = new \Mpdf\Mpdf();
  $mpdf->setBasePath($url);
  $mpdf->WriteHTML($html);

  $mpdf->Output( 'myfile.pdf', 'D' );
}
add_shortcode( 'makepdf', __NAMESPACE__ . '\\makepdf' );