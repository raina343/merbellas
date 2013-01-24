<?php
/*
Plugin Name: Merbella Links
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Configures the links page
Version: 0.1
Author: Raina Matthews
Author URI: 
License: A "Slug" license name e.g. GPL2
*/
add_action('admin_menu', 'Merbella_Links');
add_action('wp_ajax_MerbellaLink','Merbella_editLink_ajax');
add_shortcode('MerbellaLinks', 'footag_func');

function Merbella_editLink_ajax(){
global $wpdb;
$dbQuery = "SELECT id,banner,name,link,description FROM wp_merbella_links WHERE id='".$_POST['id']."'";
	$myrows = $wpdb->get_results($dbQuery);
	print '<ul>';
      	print ' <li><label for="Name">Site Name<span> *</span>: </label><input id="Name" maxlength="255" size="10" name="Name" value="" /></li>';
       	print ' <li><label for="Description">Description<span> *</span>: </label><input id="Description" maxlength="255" size="10" name="Description" value="" /></li>';
	print ' <li><label for="Link">Link URL<span> *</span>: </label><input id="Link" maxlength="255" size="10" name="Link" value="" /></li>';
	print '</ul>';

print_r($myrows);

}
function Merbella_Links() {
	add_menu_page( 'Merbella Links', 'Merbella Links', 'manage_options', 'MerbellaLinksOptions', 'Merbella_Links_options', $icon_url, $position );
}

function footag_func($atts) {
}

function MerbellaLinks_func() {
	echo "page code";
}
function Merbella_Links_options() {
print '<div class="wrap">';
print '<div id="icon-edit" class="icon32"></div><h2>Links Setup</h2>';
?>
<input class="button-primary" type="submit" name="Save" value="<?php _e('Save Options');?>" id="submitbutton" />
<table class="widefat">
<thead>
    <tr>
        <th>Banner</th>
        <th>Name</th>      
        <th>Link URL</th>
        <th>Description</th>
    </tr>
</thead>
<tfoot>
        <th>Banner</th>
        <th>Name</th>      
        <th>Link URL</th>
        <th>Description</th>
</tfoot>
<tbody>
<?
global $wpdb;
$myrows = $wpdb->get_results("SELECT id,banner,name,link,description FROM wp_merbella_links");
foreach ( $myrows as $row ) {
	print '<tr onclick="populatelinkdata(\''.$row->id.'\')">';
	print '<td>'.$row->banner.'</td>';
	print '<td>'.$row->name.'</td>';
	print '<td>'.$row->link.'</td>';
	print '<td>'.$row->description.'</td>';
	print '</tr>';
}
print '</tbody>';
print '</table>';
print '</div>';
?>
<script language="javascript">
function populatelinkdata(id){
	var poststr2="id="+id;
	jQuery.ajax({type:'POST',data:{action:'MerbellaLink',id:id},url: "admin-ajax.php",success: function(value) {
alert(value);
	}});
}
</script>
<?
}
function code_MerbellaLinks($config=array()) {
	echo "Wheeee";
}
?>
