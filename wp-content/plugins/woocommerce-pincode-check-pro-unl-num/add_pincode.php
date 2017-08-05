<?php
function add_pincodes_f()
{
	?>
		<div class="wrap">
	<?php
	
	global $table_prefix, $wpdb;
	
	if(isset($_POST['submit']))
	{
		
		$pincode = sanitize_text_field( $_POST['pincode'] );
		$city = sanitize_text_field( $_POST['city'] );
		$state = sanitize_text_field( $_POST['state'] );
		$dod = sanitize_text_field( $_POST['dod'] );
		$cod = sanitize_text_field( $_POST['cod'] );
		
		$safe_zipcode = $pincode;
		
		$safe_dod = intval( $dod );
		
		if (  $safe_zipcode && $safe_dod )
		{
		
			$num_rows = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM `".$table_prefix."check_pincode_p` where `pincode` = %s", $pincode ) );

			if($num_rows == 0)
			{

				$result = $wpdb->query( "INSERT INTO `".$table_prefix."check_pincode_p` (`pincode`, `city`, `state`, `dod`, `cod`) VALUES ('$pincode', '$city', '$state', $dod, '$cod')" );
				
				if($result == 1)
				{
				?>

					<div class="updated below-h2" id="message"><p>Added Successfully.</p></div>

				<?php
				}
				else
				{
					?>
						<div class="error below-h2" id="message"><p> Something Went Wrong Please Try Again With Valid Data.</p></div>
					<?php
					
				}
			}
			else
			{
				?>

					<div class="error below-h2" id="message"><p> This Pincode Already Exists.</p></div>

				<?php
			}
		}
		else
		{
			?>

				<div class="error below-h2" id="message"><p> Please Fill Valid Data.</p></div>

			<?php
		}
	}
	?>
			<div id="icon-users" class="icon32"><br/></div>

				<h2>Add Zip Code</h2>

					<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->

				<form action="" method="post" id="azip_form" name="azip_form">


					<table class="form-table">

					<tbody>

						<tr class="user-user-login-wrap">

							<th><label for="user_login">Pincode</label></th>

							<td><input type="text" required="required" class="regular-text" id="pincode" name="pincode"></td>

						</tr>

						<tr class="user-first-name-wrap">

							<th><label for="first_name">City</label></th>

							<td><input type="text" required="required" class="regular-text" id="city" name="city"></td>

						</tr>

						<tr class="user-last-name-wrap">

							<th><label for="last_name">State</label></th>

							<td><input type="text" required="required" class="regular-text" id="state" name="state"></td>

						</tr>

						<tr class="user-nickname-wrap">

							<th><label for="nickname">Delivery within days</label></th>

							<td><input type="number" min="1" step="1" value="1" class="regular-text" id="dod" name="dod"></td>

						</tr>

						<tr class="user-nickname-wrap">

							<th><label for="nickname">Enable Cash on delivery For This Pincode</label></th>

							<th><label for="nickname"><input type="radio" value="no" checked="checked" name="cod">No</label>

							<label for="nickname"><input type="radio" value="yes" name="cod">Yes</label></th>


						</tr>


					</tbody>

				</table>

					<p class="submit"><a class="button" href="?page=list_pincodes">Back</a>&nbsp;&nbsp;<input type="submit" value="Add" class="button button-primary" id="submit" name="submit"></p>

			</form>
		</div>
	<?php
}
?>