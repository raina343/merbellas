<?php
/*
Plugin Name: Merbella Products
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Configures the Products page
Version: 0.1
Author: Raina Matthews
Author URI: 
License: A "Slug" license name e.g. GPL2
*/
add_action('admin_menu', 'Merbella_Products');
//add_action('wp_ajax_MerbellaLink','Merbella_edit_ajax');
//add_action('wp_ajax_MerbellaLinkSave','Merbella_SaveLink_ajax');
//add_action('wp_ajax_MerbellaGetTable','Merbella_GetTable_ajax');
//add_action('wp_ajax_MerbellaLinkDelete','Merbella_DeleteLink_ajax');
add_shortcode('MerbellaProducts', 'Products_footag_func');
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox');
wp_enqueue_script('media-upload');  
function Merbella_Products_GetTable_ajax(){
//This gets and displays the Main links table.  Called via Ajax to allow for dynamic refreshing
	global $wpdb;
	$myrows = $wpdb->get_results("SELECT id,banner,name,link,description,enabled FROM wp_merbella_links");
	foreach ( $myrows as $row ) {
	        print '<tr>';
	        print '<td><input name="delete" value="'.$row->id.'" type="checkbox" id="delete'.$row->id.'"></td>';
	        print '<td onclick="populatelinkdata(\''.$row->id.'\')"><img src="'.$row->banner.'" height="42" width="146"></td>';
	        print '<td onclick="populatelinkdata(\''.$row->id.'\')">'.$row->name.'</td>';
	        print '<td onclick="populatelinkdata(\''.$row->id.'\')">'.$row->link.'</td>';
	        print '<td onclick="populatelinkdata(\''.$row->id.'\')">'.$row->description.'</td>';
	        print '<td onclick="populatelinkdata(\''.$row->id.'\')">';
		if ($row->enabled=="0"){
			print 'Disabled</td>';
		}else{
			print 'Enabled</td>';
		}
	        print '</tr>';
	}
exit;
}
function Merbella_Products_SaveLink_ajax(){
	//Save link code
	global $wpdb;
	if ($_POST['Enabled']=="false"){
		$_POST['Enabled']=0;
	}else {
		$_POST['Enabled']=1;
	}
	if($_POST['id']==""){
		$dbQuery = "INSERT into wp_merbella_links(banner,name,link,description,enabled) VALUES (";
		$dbQuery .="'".mysql_real_escape_string($_POST['Banner'])."',";
		$dbQuery .="'".mysql_real_escape_string($_POST['Name'])."',";
		$dbQuery .="'".mysql_real_escape_string($_POST['Link'])."',";
		$dbQuery .="'".mysql_real_escape_string($_POST['Desc'])."',";
		$dbQuery .="'".mysql_real_escape_string($_POST['Enabled'])."')";
		$wpdb->query( $wpdb->prepare($dbQuery));
		//Saving new Entry
	}else {
		$dbQuery = "Update wp_merbella_links SET ";
		$dbQuery .="banner='".mysql_real_escape_string($_POST['Banner'])."', ";
		$dbQuery .="name='".mysql_real_escape_string($_POST['Name'])."', ";
		$dbQuery .="link='".mysql_real_escape_string($_POST['Link'])."', ";
		$dbQuery .="description='".mysql_real_escape_string($_POST['Desc'])."', ";
		$dbQuery .="enabled='".mysql_real_escape_string($_POST['Enabled'])."' ";
		$dbQuery .=" WHERE id='".mysql_real_escape_string($_POST['id'])."'";
		$wpdb->query( $wpdb->prepare($dbQuery));
		//Updating Entry
	}
exit;
}
function Merbella_ProductsDeleteLink_ajax(){
	//Deleting links from the table.  Muliple selections are allowed
	global $wpdb;
	foreach ($_POST['id'] as $y){
		$dbQuery = "DELETE FROM wp_merbella_links WHERE id='".$y."'";
		$wpdb->query( $wpdb->prepare($dbQuery));
	}
exit;
}
function Merbella_Products_editLink_ajax(){
	//The main add/edit portion.  Done with Ajax, so I can more easily show/hide the field.  also because I like ajax
	global $wpdb;
	$dbQuery = "SELECT id,banner,name,link,description,enabled FROM wp_merbella_links WHERE id='".$_POST['id']."'";
	$row = $wpdb->get_row($dbQuery);
	print '<h3> Add/Edit Site</h3>';
	print '<table class="form-table">';
	print '<tbody>';
	print '<tr valign="top">';
	print '<th scope="row"><label for="Name">Site Name<span> *</span>: </label></th><td><input id="Name" maxlength="255" size="50" name="Name" value="'.$row->name.'" /></td></tr>';
	print '<tr valign="top">';
	print '<th scope="row"><label for="Description">Description<span> </span>: </label></th><td>	<input id="Description" maxlength="255" size="50" name="Description" value="'.$row->description.'" /></td></tr>';
	print '<tr valign="top">';
	print '<th scope="row"><label for="Link">Link URL<span> *</span>: </label></th><td>	<input id="Link" maxlength="255" size="50" name="Link" value="'.$row->link.'" /></td></tr>';
	print '<tr valign="top">';
	print '<th scope="row"><label for="Enabled">Enabled<span> </span>: </label></th><td>	<input id="enabled" type="checkbox"';
	if ($row->enabled=="0"){
	}else {
		print ' checked="checked" ';
	}
	print ' /></td></tr>';
	print '<tr valign="top">';
	print '<th scope="row"><label for="Name">Banner<span> *</span>: </label></th><td>';
	?>
	<input type="text" id="upload_image" name="theme_wptuts_options[logo]" value="<?php echo $row->banner; ?>" />  
        <input id="upload_image_button" type="button" class="button" onclick="uploadbanner()" value="<?php _e( 'Upload Logo', 'wptuts' ); ?>" />  
        <span class="description"><?php _e('Upload an image for the banner.', 'wptuts' ); ?></span></td></tr>
	<tr valign="top"><td></td><td>
	<? if($row->banner==""){
		print '<img id="upload_image2" height="42" width="146" align="absmiddle">';
	}else {
		print '<img id="upload_image2" src="'.$row->banner.'" height="42" width="146" align="absmiddle">';
	}
	print '</td></tr>';
	print '</tbody></table>';
	print '<input type="hidden" id="id" value="'.$row->id.'">';
	print '<input class="button-primary" type="button" name="Save" value="Save Link" id="submitbutton" onclick="saveentry();"/>';
exit;
}
function Merbella_Products() {
$icon_url="../wp-content/plugins/MerbellaLinks/icon-links-orange.png";
	//Adds the plugin to the admin menu
	add_menu_page( 'Merbella Products', 'Merbella Products', 'manage_options', 'MerbellaProductsOptions', 'Merbella_Products_options', $icon_url, $position );
}

function Products_footag_func($atts) {
	global $wpdb;
	$dbQuery = "SELECT ProductName,Price,ShortDesc,MainImage FROM wp_merbella_products WHERE enabled='1'";
	$row = $wpdb->get_results($dbQuery);
	$code = '';
	$x=0;
	foreach ( $row as $row ) {
		$code .='<div style="display:inline-block;height:300px;width:150px;margin-right:10px;" id="link-id'.$row->id.'">';
		$code .='<div id="link-Picture" style="padding-right:10px;width:145px;height:45px;"><img width="160" height="160" src="'.$row->MainImage.'"></div>';
		$code .='<div id="text" style="border-style:solid;border-width:1px;position:relative;height:300px;top:120px;text-align:center;line-height:10px;"><span style="width:100%;font-size:12px;font-family:BlackChancery,Georgia,serif">'.$row->ProductName.'<br></span>';
		$code .='<span style="width:100%">'.$row->Price.'</span><br>'.$row->ShortDesc.'</div>';
		$code .='</a>';
		$code .='</div>';
	}
	$code .='</table>';
	return $code;
}

function MerbellaProducts_func() {
	echo "page code";
}
function Merbella_Products_options() {
//Main Admin Page Code
	print '<div class="wrap">';
	print '<div id="icon-edit" class="icon32"></div><h2>Links Setup</h2>';
	?>
	<div id="editarea" style="padding:10px;"></div>
	<h3>Site Links</h3>
	<table class="widefat">
	<thead>
	<tr>
        <th width="25">&nbsp;</th>
        <th width="40">Banner</th>
        <th>Name</th>      
        <th>Link URL</th>
        <th>Description</th>
        <th>Status</th>
	</tr>
	</thead>
	<tfoot>
        <th width="25">&nbsp;</th>
        <th>Banner</th>
        <th>Name</th>      
        <th>Link URL</th>
        <th>Description</th>
        <th>Status</th>
	</tfoot>
	<tbody id="tablebody">
	<?
	print '</tbody>';
	print '</table>';
	print '<br>';
	print '<input class="button-primary" type="button" name="Save" value="New Link" id="submitbutton" onclick="populatelinkdata();"/>';
	print '&nbsp;';
	print '<input class="button-primary" type="button" name="Save" value="Delete Selected" id="submitbutton" onclick="deletelinkdata();"/>';
	print '</div>';
	?>
	<script language="javascript">
	jQuery(document).ready(function() {
		jQuery('#upload_image_button').click(function() {
			formfield = jQuery('#upload_image').attr('name');
			tb_show('', 'media-upload.php?type=image&TB_iframe=true');
			return false;
		});
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			jQuery('#upload_image').val(imgurl);
			jQuery('#upload_image2').attr("src", imgurl);
			tb_remove();
		}
	});
	function gettable(){
		jQuery.ajax({type:'POST',data:{action:'MerbellaGetTable'},url: "admin-ajax.php",success: function(value) {
		jQuery("#tablebody").empty();
		jQuery("#tablebody").append(value);
		}});
	}
	gettable();
	function populatelinkdata(id){
		var poststr2="id="+id;
		jQuery.ajax({type:'POST',data:{action:'MerbellaLink',id:id},url: "admin-ajax.php",success: function(value) {
		jQuery("#editarea").empty();
		jQuery("#editarea").append(value);
		}});
	}
	function saveentry(id){
		var id = document.getElementById('id').value;
		var Name = document.getElementById('Name').value;
		var Banner = document.getElementById('upload_image').value;
		var Description = document.getElementById('Description').value;
		var Link = document.getElementById('Link').value;
		var Enabled = document.getElementById('enabled').checked;
		if ((Name=="")||(Banner=="")||(Link=="")){
			alert('You must complete the fields marked with an asterix');
			return false;
		}else {
			jQuery.ajax({type:'POST',data:{action:'MerbellaLinkSave',Enabled:Enabled,Banner:Banner,id:id,Name:Name,Link:Link,Desc:Description},url: "admin-ajax.php",success: function(value) {
			jQuery("#editarea").empty();
			gettable();
			}});
		}
	}
	function deletelinkdata(){
		var selected = new Array();
	        jQuery("input:checkbox[name=delete]:checked").each(function() {
	                selected.push(jQuery(this).val());
	        });
		if (selected.length<1){
			alert('You must select an entry to delete');
			return false
		}else{
			var answer = confirm ('Are you sure you wish to delete the selected entry?');
			if (answer){
				jQuery.ajax({type:'POST',data:{action:'MerbellaLinkDelete',id:selected},url: "admin-ajax.php",success: function(value) {
				jQuery("#editarea").empty();
				gettable();
				}});
			}else {
				return false;
			}
		}
	}
	function uploadbanner(id){
		formfield = jQuery('#upload_image').attr('name');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		return false;
	}
	</script>
	<?
}
function code_MerbellaProducts($config=array()) {
}
?>
