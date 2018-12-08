<?php /* Groups Engine - Admin User Settings */
global $wp_version;
if ( $wp_version != null ) { // Verify that user is allowed to access this page
		global $wpdb;
		
		// Get All Group Types
		$enmge_preparredsql = "SELECT * FROM " . $wpdb->prefix . "ge_group_types" . " ORDER BY group_type_id ASC"; 
		$enmge_grouptypes = $wpdb->get_results( $enmge_preparredsql );
?>
<h3>Groups Engine</h3> 

<table class="form-table"> 
	<?php foreach ($enmge_grouptypes as $grouptype) { ?>
	<tr> 
		<th>
			<label for="favorite_post">Get Contact Emails for <?php echo stripslashes($grouptype->group_type_title); ?>?:</label>
		</th> 
		<td>
			<input name="groupsengine_admin_grouptype<?php echo $grouptype->group_type_id; ?>" type="checkbox" id="groupsengine_admin_grouptype<?php echo $grouptype->group_type_id; ?>" value="1" <?php if (${'enmge_gtvalue' . $grouptype->group_type_id}  == 1) { echo 'checked="checked"'; } ?>  />
		</td>
	</tr>
	<?php } ?>
</table>
<?php  // Deny access to sneaky people!
} else {
	exit("Access Denied");
} ?>