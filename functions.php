<?php
function postmark_json_encode($to, $subject, $body) {
	
	$postmark_email = array();
	$postmark_email["From"] = get_option( 'pm_wp_mail_address' );
	$postmark_email["To"] = $to;
	$postmark_email["Subject"] = $subject;
	
	if( get_option( 'pm_wp_mail_type' )==1 ) {
		$postmark_email["HtmlBody"] = $body;
		$postmark_email["TextBody"] = strip_tags($body);
	} else {
		$postmark_email["TextBody"] = strip_tags($body);
	}
	
	return json_encode($postmark_email);

}

function postmark_return_log($httpCode,$return) {
	global $wpdb;
		
	$table_name = $wpdb->prefix . "pm_wp_mail_log";
	$wpdb->insert( $table_name, array( 'httpcode' => $httpCode, 'message' => $return ) );
}

function PluginUrl() {
	//Try to use WP API if possible, introduced in WP 2.6
	if (function_exists('plugins_url')) return trailingslashit(plugins_url(basename(dirname(__FILE__))));

	//Try to find manually... can't work if wp-content was renamed or is redirected
	$path = dirname(__FILE__);
	$path = str_replace("\\","/",$path);
	$path = trailingslashit(get_bloginfo('wpurl')) . trailingslashit(substr($path,strpos($path,"wp-content/")));
	return $path;
}
?>