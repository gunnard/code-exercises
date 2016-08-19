if ( ! function_exists( 'class_wrap' ) ) :
/**
 * Adds a span with specified class and content inside
 *
 * usage: [class_wrap class="className" content="Content to show"]
 * 
 * @param array $atts Attributes for span class and content
 * @return string Completed output to be injected into page
 */

function class_wrap( $atts ) {
    $attributes = shortcode_atts( array(
        'class' => 'default_class',
        'content' => 'placeholder text',
    ), $atts );

    $output = "<span class=\"" . $attributes['class'] ."\">"; 
    $output .= $attributes['content'];
    $output .= '</span>';
    return $output;
}
endif;
add_shortcode( 'class_wrap', 'class_wrap' );

if ( ! function_exists( 'list_repeater' ) ) :
/**
 * Creates an unordered list and lists 'content' as items 'x' amount of times
 *
 * usage: [list_repeater x="5" content="Content to show"]
 * x is the amount of times you would like for the content to repeat
 * 
 * @param array $atts Attributes for how many times to repeat and content for the list 
 * @return string Completed <ul> with content inside
 */

function list_repeater( $atts ) {
    $attributes = shortcode_atts( array(
        'x' => '1',
        'content' => 'placeholder text',
    ), $atts );
    $output = "<ul>\n";
    for ($count = 0; $count < $attributes['x']; $count++) {
        $output .= "<li>" . $attributes['content'] . "</li>\n";
    }
    $output .= "</ul>\n";
    return $output;
}
endif;
add_shortcode( 'list_repeater', 'list_repeater' );
