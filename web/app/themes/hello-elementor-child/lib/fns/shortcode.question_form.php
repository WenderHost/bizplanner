<?php
namespace BizPlanner\shortcodes;
use function BizPlanner\templates\{render_template};

function question_form( $atts ){
  global $post, $current_business_plan;

  // Don't view the Question Form if ! $current_business_plan
  if(
    ( ! is_admin() && ! $current_business_plan ) ||
    ( ! is_admin() && is_array( $current_business_plan ) && ! array_key_exists( 'ID', $current_business_plan ) )
  ){
    wp_redirect( home_url(), 302 );
    exit;
  }

  $args = shortcode_atts( [
    'type' => null,
    'name' => null,
    'placeholder' => null,
  ], $atts, $shortcode = '' );

  if( is_null( $args['name'] ) ){
    if( is_single( $post ) ){
      $args['name'] = str_replace( ['-'], ['_'], $post->post_name );
    }
  }

  if( is_null( $args['type'] ) ){
    $type = get_field( 'type', $post->ID );
    if( ! empty( $type ) )
      $args['type'] = $type;
  }

  if( is_null( $args['placeholder'] ) ){
    $placeholder = get_field( 'placeholder', $post->ID );
    $args['placeholder'] = ( ! empty( $placeholder ) )? $placeholder : 'Enter your answer here.' ;
  }

  $value = false;
  if( $current_business_plan ){
    $business_plan = $current_business_plan;
    if( array_key_exists( $args['name'], $business_plan ) )
      $value = $business_plan[ $args['name'] ];
  }
  $html = '';

  // Initialize the data we send to our Handlebars templates
  $data = [
    'placeholder'     => $args['placeholder'],
    'placeholder_esc' => esc_attr( $args['placeholder'] ),
    'input_name'      => $args['name'],
    'input_name_esc'  => esc_attr( $args['name'] ),
    'value'           => $value,
  ];

  switch( $args['type'] ){
    case 'checkbox':
    case 'radio':
      if( taxonomy_exists( $args['name'] ) ){
        $terms = get_terms([ 'taxonomy' => $args['name'], 'hide_empty' => false ]);

        if( $terms ){
          // ELEMENTOR
          $options = [];
          foreach( $terms as $term ){
            if( isset( $value ) && is_array( $value ) && 0 < count( $value ) ){
              $checked = ( array_key_exists( $term->term_id, $value ) )? ' checked="checked"' : null ;
            } else {
              $checked = checked( $value, $term->term_id, false );
            }

            // Get cost
            $cost = get_field( 'cost', $term );

            $options[] = [
              'term_id'         => $term->term_id,
              'checked'         => $checked,
              'slug'            => $term->slug,
              'slug_esc'        => esc_attr( $term->slug ),
              'input_name'      => $args['name'],
              'input_name_esc'  => esc_attr( $args['name'] ),
              'name'            => $term->name,
              'name_esc'        => esc_attr( $term->name ),
              'cost'            => $cost,
            ];
          }
          $data['options'] = $options;

          $html = render_template( 'form.field-type-' . $args['type'], $data );
        }
      } else {
        $html = 'I could not find a taxonomy named <code>' . $args['name'] . '</code>';
      }
      break;

    case 'number':
      $field_object = get_field_object( $args['name'], $business_plan['ID'] );

      // Setup prepend/append display
      $data['prepend'] = ( $field_object && array_key_exists( 'prepend', $field_object ) && ! empty( $field_object['prepend'] ) )? '<span class="prepend">' . $field_object['prepend'] . '</span>' : '' ;
      $data['append'] = ( $field_object && array_key_exists( 'append', $field_object ) && ! empty( $field_object['append'] ) )? '<span class="append">' . $field_object['append'] . '</span>' : '' ;

      // Setup min/max attributes
      $min = get_field( 'min', $post->ID );
      $data['min_attr'] = ( ! empty( $min ) )? ' min="' . $min . '"' : null ;
      $max = get_field( 'max', $post->ID );
      $data['max_attr'] = ( ! empty( $max ) )? ' max="' . $max . '"' : null ;

      $html = render_template( 'form.field-type-number', $data );
      break;

    case 'textarea':
      $html = render_template( 'form.field-type-textarea', $data );
      break;

    default:
      $html = render_template( 'form.field-type-text', $data );
      break;
  }

  return render_template( 'form', [ 'html' => $html ] );
}
add_shortcode( 'question_form', __NAMESPACE__ . '\\question_form' );
