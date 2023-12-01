<?php

namespace BizPlanner\templates;
use function BizPlanner\utilities\{get_alert};
use LightnCandy\LightnCandy;

/**
 * Renders a Handlebars template.
 *
 * Requires `zordius/lightncandy` Composer library for
 * PHP Handlebars template processing.
 *
 * @param      string  $filename  The filename
 * @param      array   $data      The data passed to the handlebars template.
 *
 * @return     string    The rendered template.
 */
function render_template( $filename = '', $data = [] ){
  if( empty( $filename ) )
    return false;

  // Remove file extension
  $extensions = ['.hbs', '.htm', '.html'];
  $filename = str_replace( $extensions, '', $filename );

  $compile = 'false';

  $theme_path = \get_stylesheet_directory();
  $theme_template = \trailingslashit( $theme_path ) . 'lib/templates/' . $filename . '.hbs';
  $theme_template_compiled = \trailingslashit( $theme_path ) . 'lib/templates/compiled/' . $filename . '.php';

  if( file_exists( $theme_template ) ){
    if( ! file_exists( $theme_template_compiled ) ){
      $compile = 'true';
    } else if( filemtime( $theme_template ) > filemtime( $theme_template_compiled ) ){
      $compile = 'true';
    }

    $template = $theme_template;
    $template_compiled = $theme_template_compiled;
  } else if( ! file_exists( $theme_template ) ){
    return false;
  }

  $template = [
    'filename' => $template,
    'filename_compiled' => $template_compiled,
    'compile' => $compile,
  ];

  if( ! file_exists( dirname( $template['filename_compiled'] ) ) )
    \wp_mkdir_p( dirname( $template['filename_compiled'] ) );

  if( 'true' == $template['compile'] ){
    $hbs_template = file_get_contents( $template['filename'] );
    $phpStr = LightnCandy::compile( $hbs_template, array(
      'flags' => LightnCandy::FLAG_SPVARS | LightnCandy::FLAG_PARENT | LightnCandy::FLAG_ELSE | LightnCandy::FLAG_EXTHELPER,
      'helpers' => array(
        'numberformat' => __NAMESPACE__ . '\\LnC_helper_numberformat',
        'processarray' => __NAMESPACE__ . '\\LnC_helper_processarray',
        'selected'     => __NAMESPACE__ . '\\LnC_helper_isSelected',
      ),
    ) );
    if ( ! is_writable( dirname( $template['filename_compiled'] ) ) )
      \wp_die( 'I can not write to the directory.' );
    file_put_contents( $template['filename_compiled'], '<?php' . "\n" . $phpStr . "\n" . '?>' );
  }

  if( ! file_exists( $template['filename_compiled'] ) )
    return false;

  $renderer = include( $template['filename_compiled'] );

  return $renderer( $data );
}

/**
 * Compares the $option_value to the $selected_value
 *
 * @param      string  $option_value    The option value
 * @param      string  $selected_value  The selected value
 *
 * @return     string    Returns ` selected="selected"` when the values match
 */
function LnC_helper_isSelected( $option_value, $selected_value ){
  return ( $option_value == $selected_value )? ' selected="selected"' : false;
}

/**
 * Handlebars helper function for number_format()
 *
 * @param      float  $number  The number
 *
 * @return     string  Formatted number
 */
function LnC_helper_numberformat( $number ){
  settype( $number, 'float' );
  if( is_float( $number ) )
    return number_format( $number );

  return $number;
}

/**
 * Handlebars helper for processing an array of WP Term objects into a comma-delimited string of Term Names.
 *
 * @param      array  $array  The array of terms
 *
 * @return     string  Comma separated string of term names
 */
function LnC_helper_processarray( $array ){
  if( ! is_array( $array ) )
    return $array;

  $term_names = [];
  foreach( $array as $item ){
    if( is_object( $item ) && property_exists( $item, 'term_id') ){
      $term_names[] = $item->name;
    }
  }
  return implode( ', ', $term_names );
}

/**
 * Checks if template file exists.
 *
 * @since 1.4.6
 *
 * @param string $filename Filename of the template to check for.
 * @return bool Returns TRUE if template file exists.
 */
function template_exists( $filename = '' ){
  if( empty( $filename ) )
  return false;

  // Remove file extension
  $extensions = ['.hbs', '.htm', '.html'];
  $filename = str_replace( $extensions, '', $filename );

  $theme_path = \get_stylesheet_directory();
  $theme_template = \trailingslashit( $theme_path ) . 'donation-manager-templates/' . $filename . '.hbs';

  $plugin_template = trailingslashit( DONMAN_PLUGIN_PATH ) . 'lib/templates/' . $filename . '.hbs';

  if( file_exists( $theme_template ) ){
    return true;
  } else if( file_exists( $plugin_template ) ){
    return true;
  } else if( ! file_exists( $plugin_template ) ){
    return false;
  }
}