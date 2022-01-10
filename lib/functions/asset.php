<?php

// stylesheet
function import_stylesheet(){

    wp_enqueue_style('style','/wp-content/themes/pray-eat-shiogama/assets/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'import_stylesheet' );
