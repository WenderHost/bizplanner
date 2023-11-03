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
    'type'        => null,
    'name'        => null,
    'placeholder' => null,
    'prompt'      => null,
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

  if( is_null( $args['prompt'] ) ){
    $prompt = get_field( 'prompt', $post->ID );
    if( ! empty( $prompt ) ){
      $args['prompt'] = $prompt;
    } else {
      $name = str_replace( [ '_','-' ], ' ', strtolower( $args['name'] ) );
      switch( $args['type'] ){
        case 'radio':
        case 'checkbox':
          $args['prompt'] = 'Select your ' . $name . ':';
          break;

        case 'textarea':
          $args['prompt'] = 'Enter a detailed ' . $name . ':';
          break;

        default:
          $args['prompt'] = 'Enter your ' . $name . ':';
          break;
      }
    }
    //$args['prompt'] = ( ! empty( $prompt ) )? $prompt : 'Enter your answer here.' ;
  }

  if( is_null( $args['placeholder'] ) ){
    $placeholder = get_field( 'placeholder', $post->ID );
    $args['placeholder'] = ( ! empty( $placeholder ) )? $placeholder : 'Type your answer here.' ;
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
    'prompt'          => $args['prompt'],
    'placeholder'     => $args['placeholder'],
    'placeholder_esc' => esc_attr( $args['placeholder'] ),
    'input_name'      => $args['name'],
    'input_name_esc'  => esc_attr( $args['name'] ),
    'value'           => $value,
  ];

  $additional_help = get_field( 'additional_help', $post->ID );
  if( ! is_null( $current_business_plan ) )
    $additional_help = str_replace( ['{{product}}'], [ $current_business_plan['product'] ], $additional_help );
  if( $additional_help )
    $data['additional_help'] = $additional_help;


  //uber_log('🔔 $args = ' . print_r( $args, true ) );
  //uber_log('🔔 $value = ' . print_r( $value, true ) );
  switch( $args['type'] ){
    case 'checkbox':
    case 'radio':
      if( taxonomy_exists( $args['name'] ) ){
        $terms = get_terms([ 'taxonomy' => $args['name'], 'hide_empty' => false ]);
        //if( 'startup_funding_source' == $args['name'] )
          //uber_log('🔔 `startup_funding_source` $terms = '. print_r( $terms, true ) );
        if( $terms ){
          // ELEMENTOR
          $parents = [];
          $children = [];
          $options = [];

          foreach( $terms as $term ){

            if( isset( $value ) && is_array( $value ) && 0 < count( $value ) ){
              $checked = ( array_key_exists( $term->term_id, $value ) )? ' checked' : null ;
            } else {
              $checked = checked( $value, $term->term_id, false );
            }

            // Get cost
            $cost = get_field( 'cost', $term );
            $cost_formatted = ( $cost )? number_format( $cost ) : null ;

            // If entered, use the $term->description in place of the $term->name
            $name = ( ! empty( $term->description ) )? $term->description : $term->name ;

            if( 0 == $term->parent ){
              $parents[ $term->term_id ] = [
                'term_id'         => $term->term_id,
                'checked'         => $checked,
                'slug'            => $term->slug,
                'slug_esc'        => esc_attr( $term->slug ),
                'input_name'      => $args['name'],
                'input_name_esc'  => esc_attr( $args['name'] ),
                'name'            => $name,
                'name_esc'        => esc_attr( $term->name ),
                'cost'            => $cost,
                'cost_formatted'  => $cost_formatted,
              ];
            } elseif ( 0 < $term->parent ) {
              $children[ $term->parent ][] = [
                'term_id'         => $term->term_id,
                'checked'         => $checked,
                'slug'            => $term->slug,
                'slug_esc'        => esc_attr( $term->slug ),
                'input_name'      => $args['name'],
                'input_name_esc'  => esc_attr( $args['name'] ),
                'name'            => $name,
                'name_esc'        => esc_attr( $term->name ),
                'cost'            => $cost,
                'cost_formatted'  => $cost_formatted,
                'parent'          => $term->parent,
              ];
            }
            /*
            $options[] = [
              'term_id'         => $term->term_id,
              'checked'         => $checked,
              'slug'            => $term->slug,
              'slug_esc'        => esc_attr( $term->slug ),
              'input_name'      => $args['name'],
              'input_name_esc'  => esc_attr( $args['name'] ),
              'name'            => $name,
              'name_esc'        => esc_attr( $term->name ),
              'cost'            => $cost,
              'cost_formatted'  => $cost_formatted,
            ];
            /**/
          }
          if( empty( $children ) ){
            $options = $parents;
          } else {
            foreach( $parents as $term_id => $parent ){
              $parents[ $term_id ]['children'] = $children[ $term_id ];
            }
            $options = $parents;
          }

          $data['options'] = $options;
          //uber_log( '🪵 $data = ' . print_r( $data, true ) );

          $html = render_template( 'form.field-type-' . $args['type'], $data );
        }
      } else {
        $html = 'I could not find a taxonomy named <code>' . $args['name'] . '</code>';
      }
      break;

    case 'number':
      $field_object = get_field_object( $args['name'], $business_plan['ID'] );

      // Setup prepend/append display
      if( $field_object && array_key_exists( 'prepend', $field_object ) && ! empty( $field_object['prepend'] ) ){
        $data['prepend'] = ( array_key_exists( 'prepend', $field_object ) && ! empty( $field_object['prepend'] ) )? $field_object['prepend'] : '' ;
      } else if( in_array( $args['name'], [ 'product_price' ] ) ){
        $data['prepend'] = '$';
      }

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
  $data['html'] = $html;
  $data['avatar'] = get_stylesheet_directory_uri() . '/lib/img/bizplanner-avatar_01.png';

  return render_template( 'form', $data );
}
add_shortcode( 'question_form', __NAMESPACE__ . '\\question_form' );
