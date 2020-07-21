<?php
defined('ABSPATH') or die('No script kiddies please!');
$post_types = isset($_POST['account_details']['post_types'])?array_map('sanitize_text_field',$_POST['account_details']['post_types']):array();
$category = isset($_POST['account_details']['category'])?array_map('sanitize_text_field',$_POST['account_details']['category']):array();
$account_details = array_map('sanitize_text_field',$_POST['account_details']);
$account_details['post_types'] = $post_types;
$account_details['category'] = $category;
update_option('atap_settings',$account_details);
$_SESSION['atap_message'] = __('Settings saved successfully!','accesspress-twitter-auto-post');
wp_redirect(admin_url('admin.php?page=atap'));
exit();
