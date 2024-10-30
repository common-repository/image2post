<?php
/*
   Plugin Name: Image2Post
   Description: This is just an update so thinks will work with the new version of Wordpress 2.0.1. It has not been tested on any other version. If you are updating from version 1.0 of this plugin, then just activate it and load your home page 2 times. You need to be logged in as admin to do this. See readme.txt for a full description.
   Version: 2.3.2
   Plugin URI: http://kouloumbris.com/weblog/plugins/image2post/
   Author: Constantinos Kouloumbris
   Author URI: http://kouloumbris.com/
*/

/*
Adds an image to the beginning of the content of each post, to the right or to the left or to both sides. Just Activate the plugin and you will see 6 text fields when you are editing a post or writing a new one. In the Left Image and Right Image text box you need to add the image path. The plugin looks for images in the directory '/wp-images/media/'. If you have your images in a folder after that you need to add it, if not the type just the filename with the extension.

Also you can have a link under the image by filling the text boxes (Left/Right) URL and (Left/Right) URL Text. The URL text box is where you type the address and the URL Text text box is where you type the desired text you want to be displayed.

You also need some css code into your stylesheet file, that code is in the file called css.txt
*/

function image2post_checkbox() {
	global $postdata, $post;

	$lvimg = get_post_meta($post->ID, '_img_left', TRUE);
	$lvimgurl = get_post_meta($post->ID, '_imglink_left', TRUE);
	$lvimgtext = get_post_meta($post->ID, '_imglink_text_left', TRUE);

	$rvimg = get_post_meta($post->ID, '_img_right', TRUE);
	$rvimgurl = get_post_meta($post->ID, '_imglink_right', TRUE);
	$rvimgtext = get_post_meta($post->ID, '_imglink_text_right', TRUE);

	echo '<fieldset id="postcustom" class="dbx-box">';
	echo '	<h3 class="dbx-handle">'.__('Image to Post', 'Image2Post').'</h3>';
	echo '	<div class="dbx-content">';
	echo '		<table cellspacing="3" cellpadding="3"><tbody>';
	echo '			<tr><th>Left Image</th><th>Right Image</th></tr>';
	echo '			<tr><td width="50%"><input type="text" name="limg" id="limg" value="'.$lvimg.'" /></td>';
	echo '			<td><input type="text" name="rimg" id="rimg" value="'.$rvimg.'" /></td></tr>';
	echo '			<tr><th>Left URL</th><th>Right URL</th></tr>';
	echo '			<tr><td width="50%"><input type="text" name="limg_url" id="limg_url" value="'.$lvimgurl.'" /></td>';
	echo '			<td><input type="text" name="rimg_url" id="rimg_url" value="'.$rvimgurl.'" /></td></tr>';
	echo '			<tr><th>Left URL Text</th><th>Right URL Text</th></tr>';
	echo '			<tr><td width="50%"><input type="text" name="limg_url_text" id="limg_url_text" value="'.$lvimgtext.'" /></td>';
	echo '			<td><input type="text" name="rimg_url_text" id="rimg_url_text" value="'.$rvimgtext.'" /></td></tr>';
	echo '</tbody></table></div></fieldset>';
}

function image2post_update($id) {
	global $postdata;

	delete_post_meta($id, '_img_left');
	delete_post_meta($id, '_imglink_left');
	delete_post_meta($id, '_imglink_text_left');
	delete_post_meta($id, '_img_right');
	delete_post_meta($id, '_imglink_right');
	delete_post_meta($id, '_imglink_text_right');

	$limg = !($_POST["limg"] == '') ? $_POST["limg"] : '';
	$limgurl = !($_POST["limg_url"] == '') ? $_POST["limg_url"] : '';
	$limgtext = !($_POST["limg_url_text"] == '') ? $_POST["limg_url_text"] : '';

	if ($limg != '') { add_post_meta($id, '_img_left', $limg); } else { delete_post_meta($id, '_img_left'); }
	if ($limgurl != '') { add_post_meta($id, '_imglink_left', $limgurl); } else { delete_post_meta($id, '_imglink_left'); }
	if ($limgtext != '') { add_post_meta($id, '_imglink_text_left', $limgtext); } else { delete_post_meta($id, '_imglink_text_left'); }


	$rimg = !($_POST["rimg"] == '') ? $_POST["rimg"] : '';
	$rimgurl = !($_POST["rimg_url"] == '') ? $_POST["rimg_url"] : '';
	$rimgtext = !($_POST["rimg_url_text"] == '') ? $_POST["rimg_url_text"] : '';

	if ($rimg != '') { add_post_meta($id, '_img_right', $rimg); } else { delete_post_meta($id, '_img_right'); }
	if ($rimgurl != '') { add_post_meta($id, '_imglink_right', $rimgurl); } else { delete_post_meta($id, '_imglink_right'); }
	if ($rimgtext != '') { add_post_meta($id, '_imglink_text_right', $rimgtext); } else { delete_post_meta($id, '_imglink_text_right'); }
}

function i2p_update_v1_2_v2() {
	global $wpdb;

	// Auto-update: Check's to see if you where using version 1 of this script and updates it to v2
	if (0 != $wpdb->get_var("SELECT count(meta_value) FROM $wpdb->postmeta WHERE meta_key = 'img_left'")) {
		if ($posts = $wpdb->get_results("SELECT * FROM $wpdb->posts")) {
			foreach ($posts as $post) {
				$limg = get_post_meta($post->ID, 'img_left', true);
				delete_post_meta($post->ID, 'img_left');
				add_post_meta($post->ID, '_img_left', $limg);

				$limglink = get_post_meta($post->ID, 'imglink_left', true);
				delete_post_meta($post->ID, 'imglink_left');
				add_post_meta($post->ID, '_imglink_left', $limglink);

				$limgtext = get_post_meta($post->ID, 'imglink_text_left', true);
				delete_post_meta($post->ID, 'imglink_text_left');
				add_post_meta($post->ID, '_imglink_text_left', $limgtext);
			}
		}
	}

	if (0 != $wpdb->get_var("SELECT count(meta_value) FROM $wpdb->postmeta WHERE meta_key = 'img_right'")) {
		if ($posts = $wpdb->get_results("SELECT * FROM $wpdb->posts")) {
			foreach ($posts as $post) {
				$rimg = get_post_meta($post->ID, 'img_right', true);
				delete_post_meta($post->ID, 'img_right');
				add_post_meta($post->ID, '_img_right', $rimg);

				$rimglink = get_post_meta($post->ID, 'imglink_right', true);
				delete_post_meta($post->ID, 'imglink_right');
				add_post_meta($post->ID, '_imglink_right', $rimglink);

				$rimgtext = get_post_meta($post->ID, 'imglink_text_right', true);
				delete_post_meta($post->ID, 'imglink_text_right');
				add_post_meta($post->ID, '_imglink_text_right', $rimgtext);
			}
		}
	}
}

function img2post($original) {
	
	$curpath = rtrim($_SERVER['PHP_SELF'], "index.php");
	$img_icon_dir = "/wp-images/media/";
	$server_dir = ABSPATH.$curpath.$img_icon_dir;

	i2p_update_v1_2_v2();

	/* For creating the left img code */
	$values = get_post_custom_values('_img_left');
	$img_left = $values[0];
	$values = get_post_custom_values('_imglink_left');
	$imglink_left = $values[0];
	$values = get_post_custom_values('_imglink_text_left');
	$imglink_text_left = $values[0];

	if ($imglink_text_left == '') { $imglink_text_left = 'Link'; }

	if(!empty($imglink_left)) {
		$imglink_dir_left = '<a href="' . $imglink_left . '" title="'.$imglink_text_left.'">' . $imglink_text_left . '</a>';
	}
	else { $imglink_dir_left = ''; }

	if(!empty($img_left)) {

		$i2p_limgurl = get_settings('siteurl');
		$i2p_limgurl .= $img_icon_dir;
		$i2p_limgurl .= $img_left;

		$lserver_dir = $server_dir.$img_left;

		$limg_size = getimagesize($lserver_dir);

		$output .= "<div class=\"leftbox\"><img src=\"$i2p_limgurl\" alt=\"$img_left\" title=\"$img_left\" $limg_size[3] />$imglink_dir_left</div>";
	}
	else { $output .= ''; }

	/* For creating the right img code */
	$values = get_post_custom_values('_img_right');
	$img_right = $values[0];
	$values = get_post_custom_values('_imglink_right');
	$imglink_right = $values[0];
	$values = get_post_custom_values('_imglink_text_right');
	$imglink_text_right = $values[0];

	if ($imglink_text_right == '') { $imglink_text_right = 'Link'; }

	if(!empty($imglink_right)) {
		$imglink_dir_right = '<a href="' . $imglink_right . '" title="'.$imglink_text_right.'">' . $imglink_text_right . '</a>';
	}
	else { $imglink_dir_right = ''; }

	if(!empty($img_right)) {

		$i2p_rimgurl = get_settings('siteurl');
		$i2p_rimgurl .= $img_icon_dir;
		$i2p_rimgurl .= $img_right;

		$rserver_dir = $server_dir.$img_right;

		$rimg_size = getimagesize($rserver_dir);

		$output .= "<div class=\"rightbox\"><img src=\"$i2p_rimgurl\" alt=\"$img_right\" title=\"$img_right\" $rimg_size[3] />$imglink_dir_right</div>";
	}
	else { $output .= ''; }

	/* Print original text */
	$output .= $original;
	return $output;
}
function i2p_vercheck() {
	$wpcver = bloginfo('version');
	$status = true;

	if ($wpcver <= 2.0) { $status = false; }

	return $status;
}

if (i2p_version) {
	add_action('dbx_post_advanced', 'image2post_checkbox');
} else {
	add_action('edit_form_advanced', 'image2post_checkbox');
	add_action('simple_edit_form', 'image2post_checkbox');
}
if (i2p_version) {
	add_action('dbx_page_advanced', 'image2post_checkbox');
} else {
	add_action('edit_page_form', 'image2post_checkbox');
}
add_action('save_post', 'image2post_update');
add_action('edit_post', 'image2post_update');
add_action('publish_post', 'image2post_update');
add_filter('the_content', 'img2post');

?>