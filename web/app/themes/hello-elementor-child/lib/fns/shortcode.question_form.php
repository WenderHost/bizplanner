<?php

function question_form( $atts ){
  $args = shortcode_atts( [
  'type' => 'text',
  'name' => null,
  'placeholder' => 'Enter your answer here.',
  ], $atts, $shortcode = '' );

  $value = false;
  if( defined( 'BUSINESS_PLAN' ) ){
    $business_plan = BUSINESS_PLAN;
    if( array_key_exists( $args['name'], $business_plan ) ){
      $value = $business_plan[ $args['name'] ];
    } else if( array_key_exists( $args['name'] . 's', $business_plan ) ){
      $value = $business_plan[ $args['name'] . 's' ];
    }
  }
  $html = '';
  //$html.= '<pre>type: '.$args['type'].'<br>name: ' . $args['name'] . '<br>placeholder: ' . $args['placeholder'] . '</pre>';

  switch( $args['type'] ){
    case 'radio':
      if( taxonomy_exists( $args['name'] ) ){
        $terms = get_terms([ 'taxonomy' => $args['name'], 'hide_empty' => false ]);
        if( $terms ){
          $html.= '<fieldset><legend>' . $args['placeholder'] . '</legend>';
          foreach ( $terms as $term ) {
            $html.= '<div><input type="radio" name="' . esc_attr( $args['name'] ) . '" id="' . esc_attr( $term->slug ) . '" value="' . esc_attr( $term->name ) . '" ' . checked( $value, $term->name, false ) . '><label for="' . esc_attr( $term->slug ) . '">' . $term->name . '</label></div>';
          }
          $html.= '</fieldset>';
        }
      } else {
        $html.= 'I could not find a taxonomy name <code>' . $args['name'] . '</code>';
      }
      break;

    case 'checkbox':
      /**
       * CONTINUE working here. Write the code to handle `marketing_methods`
       */
      break;

    case 'textarea':
      $html = '<textarea name="' . esc_attr( $args['name'] ) . '" rows="5">' . $value . '</textarea>';
      break;

    default:
      $html = '<input name="' . esc_attr( $args['name'] ) . '" type="text" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" />';
      break;
  }

  return $html;
}
add_shortcode( 'question_form', 'question_form' );
