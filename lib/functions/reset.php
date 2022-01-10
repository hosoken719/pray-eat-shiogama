<?php
//REST APIのURLを非表示にする
remove_action('wp_head', 'rest_output_link_wp_head');

//外部ブログツールからの投稿を受け入れ
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

//バージョン表記を削除する
remove_action('wp_head', 'wp_generator');

//短縮URLを削除する
remove_action('wp_head', 'wp_shortlink_wp_head');

//wlwmanifestを非表示にする
remove_action('wp_head', 'wlwmanifest_link');

// EditURIを非表示にする
remove_action('wp_head', 'rsd_link');

//<meta charset="utf-8">canonicalタグの削除
remove_action('wp_head', 'rel_canonical');

//admin barを非表示にする
add_filter( 'show_admin_bar', '__return_false' );

//WordPressのバージョンが付与されたver=〜 を非表示にする
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

//ウィジェット「最近のコメント」を非表示にする
function remove_recent_comment_css() {
    global $wp_widget_factory;
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
add_action( 'widgets_init', 'remove_recent_comment_css');

//Gutenberg用CSSを非表示にする
function dequeue_plugins_style() {
    wp_dequeue_style('wp-block-library');
}
add_action( 'wp_enqueue_scripts', 'dequeue_plugins_style', 9999);

//dns-prefetchを非表示にする
function remove_dns_prefetch( $hints, $relation_type ) {
  if ( 'dns-prefetch' === $relation_type ) {
    return array_diff( wp_dependencies_unique_hosts(), $hints );
  }
  return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );

//contact7用のCSSを非表示にsる
function remove_cf7_js_css() {
    add_filter( 'wpcf7_load_js', '__return_false' );
    add_filter( 'wpcf7_load_css', '__return_false' );
}
add_action( 'after_setup_theme', 'remove_cf7_js_css' );

//絵文字を非表示にする
function remove_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );     
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'remove_emojis' );

//RSSの配信停止とリンクを非表示にする
remove_action('do_feed_rdf', 'do_feed_rdf');
remove_action('do_feed_rss', 'do_feed_rss');
remove_action('do_feed_rss2', 'do_feed_rss2');
remove_action('do_feed_atom', 'do_feed_atom');

remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
