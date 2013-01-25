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
	add_action('wp_ajax_MerbellaProduct','Merbella_Products_editLink_ajax');
	add_action('wp_ajax_MerbellaProductSave','MerbellaProductSave_ajax');
	add_action('wp_ajax_MerbellaGetProductsTable','Merbella_GetProductsTable_ajax');
	add_action('wp_ajax_MerbellaProductDelete','Merbella_DeleteProduct_ajax');
	add_action('wp_ajax_MerbellaShowProduct', 'Products_footag_func');
	add_action('wp_ajax_nopriv_MerbellaShowProduct', 'Products_footag_func');
	add_shortcode('MerbellaProducts', 'Products_footag_func');
	add_image_size( 'Product-Thumb', 50, 50, true );
	add_filter( 'image_size_names_choose', 'custom_image_sizes_choose' );  
	function custom_image_sizes_choose( $sizes ) {  
		$custom_sizes = array(  
			'Product-Thumb' => 'Product Thumbnail'
	        );  
	        return array_merge( $sizes, $custom_sizes );  
	}
	//wp_register_script( 'my-plugin-script', plugins_url('/functions.js', __FILE__) );
//	wp_enqueue_script('MerbellaHistory',  plugins_url('/history/jquery.history.js', __FILE__));
	wp_enqueue_script('MerbellaFunctions',  plugins_url('/functions.js', __FILE__));
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_script('media-upload'); 

function Merbella_GetProductsTable_ajax(){
//This gets and displays the Main links table.  Called via Ajax to allow for dynamic refreshing
	$scaleimage = plugins_url('/scaleimage.php', __FILE__);

	global $wpdb;
	$myrows = $wpdb->get_results("SELECT id,MainImage,ProductName,Price,ShortDesc,enabled FROM wp_merbella_products");
	foreach ( $myrows as $row ) {
	        print '<tr>';
	        print '<td><input name="delete" value="'.$row->id.'" type="checkbox" id="delete'.$row->id.'"></td>';
	        print '<td onclick="populateProductdata(\''.$row->id.'\')"><img src="'.$scaleimage.'?height=50&width=50&image='.base64_encode($row->MainImage).'" height="50" width="50"></td>';
	        print '<td onclick="populateProductdata(\''.$row->id.'\')">'.$row->ProductName.'</td>';
	        print '<td onclick="populateProductdata(\''.$row->id.'\')">'.$row->Price.'</td>';
	        print '<td onclick="populateProductdata(\''.$row->id.'\')">'.$row->ShortDesc.'</td>';
	        print '<td onclick="populateProductdata(\''.$row->id.'\')">';
		if ($row->enabled=="0"){
			print 'Disabled</td>';
		}else{
			print 'Enabled</td>';
		}
	        print '</tr>';
	}
exit;
}
function MerbellaProductSave_ajax(){
	//Save link code
	global $wpdb;
	if ($_POST['Enabled']=="false"){
		$_POST['Enabled']=0;
	}else {
		$_POST['Enabled']=1;
	}
	if($_POST['id']==""){
		//Saving new Entry
		$dbQuery = "INSERT into wp_merbella_products(MainImage,ProductName,Price,ShortDesc,LongDescenabled) VALUES (";
		$dbQuery .="'".mysql_real_escape_string($_POST['Banner'])."',";
		$dbQuery .="'".mysql_real_escape_string($_POST['Name'])."',";
		$dbQuery .="'".mysql_real_escape_string($_POST['Price'])."',";
		$dbQuery .="'".mysql_real_escape_string($_POST['Desc'])."',";
		$dbQuery .="'".mysql_real_escape_string($_POST['LongDescription'])."',";
		$dbQuery .="'".mysql_real_escape_string($_POST['Enabled'])."')";
		$wpdb->query( $wpdb->prepare($dbQuery));
	}else {
		//Updating Entry
		$dbQuery = "Update wp_merbella_products SET ";
		$dbQuery .="MainImage='".mysql_real_escape_string($_POST['Banner'])."', ";
		$dbQuery .="ProductName='".mysql_real_escape_string($_POST['Name'])."', ";
		$dbQuery .="Price='".mysql_real_escape_string($_POST['Price'])."', ";
		$dbQuery .="ShortDesc='".mysql_real_escape_string($_POST['Desc'])."', ";
		$dbQuery .="LongDesc='".mysql_real_escape_string($_POST['LongDescription'])."', ";
		$dbQuery .="enabled='".mysql_real_escape_string($_POST['Enabled'])."' ";
		$dbQuery .=" WHERE id='".mysql_real_escape_string($_POST['id'])."'";
		$wpdb->query( $wpdb->prepare($dbQuery));
	}
exit;
}
function Merbella_DeleteProduct_ajax(){
	//Deleting links from the table.  Muliple selections are allowed
	global $wpdb;
	foreach ($_POST['id'] as $y){
		$dbQuery = "DELETE FROM wp_merbella_products WHERE id='".$y."'";
		$wpdb->query( $wpdb->prepare($dbQuery));
	}
exit;
}
function Merbella_Products_editLink_ajax(){
	//The main add/edit portion.  Done with Ajax, so I can more easily show/hide the field.  also because I like ajax
	$scaleimage = plugins_url('/scaleimage.php', __FILE__);
	global $wpdb;
	$dbQuery = "SELECT id,MainImage,ProductName,Price,ShortDesc,enabled FROM wp_merbella_products WHERE id='".$_POST['id']."'";
	$row = $wpdb->get_row($dbQuery);
	print '<h3> Add/Edit Site</h3>';
	print '<table class="form-table">';
	print '<tbody>';
	print '<tr valign="top">';
	print '<th scope="row"><label for="Name">Product Name<span> *</span>: </label></th><td><input id="Name" maxlength="255" size="50" name="Name" value="'.$row->ProductName.'" /></td></tr>';
	print '<tr valign="top">';
	print '<th scope="row"><label for="Price">Price<span> *</span>: </label></th><td>	<input id="Price" maxlength="255" size="50" name="Price" value="'.$row->Price.'" /></td></tr>';
	print '<tr valign="top">';
	print '<th scope="row"><label for="ShortDescription">Short Description<span> </span>: </label></th><td>	<textarea id="ShortDescription" style="height:100px;width:300px;" maxlength="255" size="255" name="ShortDescription" >'.$row->ShortDesc.' </textarea></td></tr>';
	print '<tr valign="top">';
	print '<th scope="row"><label for="LongDescription">Long Description<span> </span>: </label></th><td>	<textarea id="LongDescription" style="height:300px;width:500px;" maxlength="65536"  name="LongDescription" >'.$row->LongDesc.' </textarea></td></tr>';
	print '<tr valign="top">';
	print '<th scope="row"><label for="Enabled">Enabled<span> </span>: </label></th><td>	<input id="enabled" type="checkbox"';
	if ($row->enabled=="0"){
	}else {
		print ' checked="checked" ';
	}
	print ' /></td></tr>';
	print '<tr valign="top">';
	print '<th scope="row"><label for="Name">Main Product Image<span> *</span>: </label></th><td>';
	?>
	<input type="text" id="upload_image" name="theme_wptuts_options[logo]" value="<?php echo $row->banner; ?>" />  
        <input id="upload_image_button" type="button" class="button" onclick="uploadbanner()" value="<?php _e( 'Upload Image', 'wptuts' ); ?>" />  
        <span class="description"><?php _e('Upload an Picture.', 'wptuts' ); ?></span></td></tr>
	<tr valign="top"><td></td><td>
	<? if($row->MainImage==""){
		print '<img id="upload_image2" height="42" width="146" align="absmiddle">';
	}else {
		print '<img id="upload_image2" src="'.$scaleimage.'?height=100&width=100&image='.base64_encode($row->MainImage).'" height="100" width="100" align="absmiddle">';
	}
	print '</td></tr>';
	print '</tbody></table>';
	print '<input type="hidden" id="id" value="'.$row->id.'">';
	print '<input class="button-primary" type="button" name="Save" value="Save Product" id="submitbutton" onclick="saveentry();"/>';
exit;
}
function Merbella_Products() {
	$icon_url="../wp-content/plugins/MerbellaLinks/icon-links-orange.png";
	//Adds the plugin to the admin menu
	add_menu_page( 'Merbella Products', 'Merbella Products', 'manage_options', 'MerbellaProductsOptions', 'Merbella_Products_options', $icon_url, $position );
}

function Products_footag_func($atts) {
//print_r($_POST);
	global $wpdb;
	$scaleimage = plugins_url('/scaleimage.php', __FILE__);
	if ($_POST['action']=="MerbellaShowProduct"){
		$dbQuery = "SELECT ProductName,Price,LongDesc,MainImage,id FROM wp_merbella_products WHERE id='".$_POST['id']."'";
		$dbQuery2 = "SELECT ImageURL,Thumbnail FROM wp_merbella_products_images WHERE Productid='".$_POST['id']."'";
		$row = $wpdb->get_results($dbQuery);
		$row2 = $wpdb->get_results($dbQuery2);
		$code2 = '<img id="MainImage" width="650" height="350" src="'.$scaleimage.'?height=350&width=650&image='.base64_encode($row[0]->MainImage).'">';
		$code2 .='<A HREF="#">Back to Products</a>';
		$code2 .='<img width="50" height="50" onclick="toggleimage(\'MainImage\',\''.base64_encode($row[0]->MainImage).'\')" src="'.$scaleimage.'?height=50&width=50&image='.base64_encode($row[0]->MainImage).'">';
		foreach ($row2 as $row2){
			$code2 .='<img width="50" height="50" onclick="toggleimage(\'MainImage\',\''.base64_encode($row2->ImageURL).'\')" src="'.$scaleimage.'?height=50&width=50&image='.base64_encode($row2->ImageURL).'">';
		}
		$code2 .='<div id="textcontentarea" style="padding-top:10px;">';
		$code2 .='<br><span style="font-size:25px;font-family:BlackChancery,Georgia,serif;line-height:15px;">'.$row[0]->ProductName.'</span><br>';
		$code2 .='<br><span style="font-size:22px;font-family:BlackChancery,Georgia,serif;padding-left:10px;">'.$row[0]->Price.'</span><br>';
		$code2 .='<br><span style="font-size:16px">'.nl2br($row[0]->LongDesc).'</span><br>';
		$code2 .='</div>';
		print $code2;
		exit;
	}
	
	$dbQuery = "SELECT ProductName,Price,ShortDesc,MainImage,id FROM wp_merbella_products WHERE enabled='1'";
	$row = $wpdb->get_results($dbQuery);
	$code = '';
	$x=0;
	$code .="<table>";
	foreach ( $row as $row ) {
		if (is_int($x/4)){
			$code .="<tr>";
		}
		$code .='<td>';
		$code .='<div id="outer" style="height:310px;width:159px;border-style:solid;border-width:0px;display:inline-block;cursor:pointer" onclick="showproduct(\''.$row->id.'\')">';
		$code .='	<div id="image" style="height:170px;width:150px;border-style:solid;border-width:0px;margin:0 auto;"><img width="160" height="160" src="'.$scaleimage.'?height=160&width=160&image='.base64_encode($row->MainImage).'"></div>';
		$code .='	<div id="text" style="height:130px;width:150px;border-style:solid;border-width:1px;margin:0 auto;text-align:center;line-height:18px;display:block;">';
		$code .='		<span style="width:100%;height:20px;display:block;font-size:18px;font-family:BlackChancery,Georgia,serif;">'.$row->ProductName.'</span><br>';
		$code .='		<span style="width:100%;font-size:16px;font-family:BlackChancery,Georgia,serif">'.$row->Price.'</span><br>';
		$code .='		<span style="display:block;height:75px;overflow:hidden;width:100%;line-height:10px;">'.$row->ShortDesc.'</span>';
		$code .='	</div>';
		$code .='</div>';
		$code .='</td>';
		$x++;
	}
		$code .='<script language="javascript">function showproduct(id){
		jQuery.ajax({type:\'POST\',data:{action:\'MerbellaShowProduct\',id:id},url: "wp-admin/admin-ajax.php",success: function(value) {
                jQuery("#content2").empty();
                jQuery("#content2").append(value);
                }});
	}</script>';
	return $code;
exit;
}

function MerbellaProducts_func() {
	echo "page code";
}
function Merbella_Products_options() {
//Main Admin Page Code
	$scaleimage = plugins_url('/scaleimage.php', __FILE__);
	print '<div class="wrap">';
	print '<div id="icon-edit" class="icon32"></div><h2>Products Setup</h2>';
	?>
	<div id="editarea" style="padding:10px;"></div>
	<h3>Products</h3>
	<table class="widefat">
	<thead>
	<tr>
        <th width="25">&nbsp;</th>
        <th width="40">Image</th>
        <th>Product Name</th>      
        <th>Price</th>
        <th>Description</th>
        <th>Status</th>
	</tr>
	</thead>
	<tfoot>
        <th width="25">&nbsp;</th>
        <th>Image</th>
        <th>Product Name</th>      
        <th>Price</th>
        <th>Description</th>
        <th>Status</th>
	</tfoot>
	<tbody id="tablebody">
	<?
	print '</tbody>';
	print '</table>';
	print '<br>';
	print '<input class="button-primary" type="button" name="Save" value="New Link" id="submitbutton" onclick="populateProductdata();"/>';
	print '&nbsp;';
	print '<input class="button-primary" type="button" name="Save" value="Delete Selected" id="submitbutton" onclick="deleteProductdata();"/>';
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
			imgurl2 = jQuery('img',html).attr('src');
			jQuery('#upload_image').val(imgurl2);
			jQuery('#upload_image2').attr("src", '<?echo $scaleimage;?>?height=100&width=100&image='+base64_encode(imgurl2));
			tb_remove();
		}
	});
	function gettable(){
		jQuery.ajax({type:'POST',data:{action:'MerbellaGetProductsTable'},url: "admin-ajax.php",success: function(value) {
		jQuery("#tablebody").empty();
		jQuery("#tablebody").append(value);
		}});
	}
	gettable();
	function populateProductdata(id){
		var poststr2="id="+id;
		jQuery.ajax({type:'POST',data:{action:'MerbellaProduct',id:id},url: "admin-ajax.php",success: function(value) {
		jQuery("#editarea").empty();
		jQuery("#editarea").append(value);
		}});
	}
	function saveentry(id){
		var id = document.getElementById('id').value;
		var Name = document.getElementById('Name').value;
		var Banner = document.getElementById('upload_image').value;
		var ShortDescription = document.getElementById('ShortDescription').value;
		var LongDescription = document.getElementById('LongDescription').value;
		var Price = document.getElementById('Price').value;
		var Enabled = document.getElementById('enabled').checked;
		if ((Name=="")||(Banner=="")||(Price=="")){
			alert('You must complete the fields marked with an asterix');
			return false;
		}else {
			jQuery.ajax({type:'POST',data:{action:'MerbellaProductSave',Enabled:Enabled,LongDescription:LongDescription,Banner:Banner,id:id,Name:Name,Price:Price,Desc:ShortDescription},url: "admin-ajax.php",success: function(value) {
			jQuery("#editarea").empty();
			gettable();
			}});
		}
	}
	function deleteProductdata(){
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
				jQuery.ajax({type:'POST',data:{action:'MerbellaProductDelete',id:selected},url: "admin-ajax.php",success: function(value) {
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
