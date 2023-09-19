<?php
namespace BizPlanner\shortcodes;

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
  //$html.= '<pre>type: '.$args['type'].'<br>name: ' . $args['name'] . '<br>placeholder: ' . $args['placeholder'] . '</pre>';

  switch( $args['type'] ){
    case 'checkbox':
    case 'radio':
      if( taxonomy_exists( $args['name'] ) ){
        $terms = get_terms([ 'taxonomy' => $args['name'], 'hide_empty' => false ]);

        if( $terms ){
          // BREAKDANCE
          $html.= '<div class="breakdance-form-field breakdance-form-field--' . $args['type'] . '">
            <fieldset role="' . $args['type'] . 'group" aria-label="' . esc_attr( $args['placeholder'] ) . '">
              <legend class="breakdance-form-field__label">' . $args['placeholder'] . '</legend>';

          foreach( $terms as $term ){
            if( isset( $value ) && is_array( $value ) && 0 < count( $value ) ){
              $checked = ( array_key_exists( $term->term_id, $value ) )? ' checked="checked"' : null ;
            } else {
              $checked = checked( $value, $term->term_id, false );
            }

            $html.= '<div class="breakdance-form-' . $args['type'] . '">
                <input type="' . $args['type'] . '" name="' . esc_attr( $args['name'] ) . '[]" value="' . $term->term_id . '" id="' . esc_attr( $term->slug ) . '" ' . $checked . '>
                <label class="breakdance-form-radio__text" for="' . esc_attr( $term->slug ) . '">' . $term->name . '</label>
              </div>';
          }
          $html.= '</fieldset></div>';
        }
      } else {
        $html.= 'I could not find a taxonomy named <code>' . $args['name'] . '</code>';
      }
      break;

    case 'number':
      $field_object = get_field_object( 'business_plan_' . $args['name'], $business_plan['ID'] );
      $prepend = ( $field_object && array_key_exists( 'prepend', $field_object ) && ! empty( $field_object['prepend'] ) )? '<span class="prepend">' . $field_object['prepend'] . '</span>' : '' ;
      $append = ( $field_object && array_key_exists( 'append', $field_object ) && ! empty( $field_object['append'] ) )? '<span class="append">' . $field_object['append'] . '</span>' : '' ;

      $min = get_field( 'min', $post->ID );
      $min_attr = ( ! empty( $min ) )? ' min="' . $min . '"' : null ;
      $max = get_field( 'max', $post->ID );
      $max_attr = ( ! empty( $max ) )? ' max="' . $max . '"' : null ;
      $html = '<style>.input-row{display: flex; align-items: center; width: 100%;} .input-row span.prepend{background-color: #eee; border-radius: 3px 0 0 3px; display: block; height: 100%; padding: 12px; font-size: 16px;}</style><div class="breakdance-form-field breakdance-form-field--number"><label class="breakdance-form-field__label" for="' . esc_attr( $args['name'] ) . '">
            ' .  $args['placeholder'] . '</label><div class="input-row">' . $prepend . '
    <input class="breakdance-form-field__input" id="' . esc_attr( $args['name'] ) . '" aria-describedby="' . esc_attr( $args['name'] ) . '" type="number" name="' . esc_attr( $args['name'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" value="' . esc_attr( $value ) . '"' . $min_attr . $max_attr . '>' . $append . '</div><!-- /.input-row --></div>';
      break;

    case 'textarea':
      $html = '<div class="breakdance-form-field breakdance-form-field--textarea" id="question-form-textarea">
            <label class="breakdance-form-field__label" for="message">' . $args['placeholder'] . '<span class="breakdance-form-field__required">*</span></label>
    <textarea class="breakdance-form-field__input" id="message" aria-describedby="message" type="textarea" name="' . esc_attr( $args['name'] ) . '" placeholder="" required="">' . $value . '</textarea></div>';
      $html.= '<style>#question-form-textarea textarea{font-family: Arial, Helvetica, sans-serif;}</style>';
      break;

    default:
      $html = '<div class="breakdance-form-field breakdance-form-field--text"><label class="breakdance-form-field__label" for="' . esc_attr( $args['name'] ) . '">' . $args['placeholder'] . '</label><input class="breakdance-form-field__input" id="' . esc_attr( $args['name'] ) . '" aria-describedby="' . esc_attr( $args['name'] ) . '" type="text" name="' . esc_attr( $args['name'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" value="' . esc_attr( $value ) . '" required=""/></div>';
      break;
  }

  return '<form class="breakdance-form breakdance-form--vertical" id="bizplanner-form">' . $html . '<footer class="breakdance-form-field breakdance-form-footer" style="flex-direction: column; align-items: start;">
            <button type="submit" class="button-atom button-atom--primary breakdance-form-button breakdance-form-button__submit" id="form-submit"><span class="button-atom__text">Save</span></button><div id="response-message"></div></footer></form>';
}
add_shortcode( 'question_form', __NAMESPACE__ . '\\question_form' );
