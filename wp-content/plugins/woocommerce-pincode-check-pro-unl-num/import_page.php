<?php
function import_page_f()
{
	global $table_prefix, $wpdb;
	if(isset($_POST['upload-zip']))
	{
		$filename = $_FILES['pincsv']['name'];
		$allowed =  array('csv','CSV');
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if(!in_array($ext,$allowed) )
		{
			?>
			<div class="error" id="message">
				<p><strong>Please Upload CSV Format.</strong></p>
			</div>
			<?php
		}
		else
		{

			$file_tmp = $_FILES['pincsv']['tmp_name'];

			$filename = dirname(__FILE__) .'/assets/ufile/'.$filename;

			$move_uploaded_file = move_uploaded_file($file_tmp, $filename);
			
			if($move_uploaded_file == 1)
			{
				?>

				<div class="updated" id="message">

					<p><strong>CSV Uploaded.</strong></p>

				</div>
				
				<?php
			}
			else
			{
				?>

				<div class="error" id="message">

					<p><strong>Something Went Wrong, Please Try Again.</strong></p>

				</div>
				
				<?php
			}

				if(file_exists($filename)) 
				{
					/* INSERT Pincode In Table  */
					$file_handle = fopen("$filename","r");

					while(! feof($file_handle))
					{

						$line_of_text = fgetcsv($file_handle, 1024);
						
						//print_r($line_of_text);
						
						$pincode = $line_of_text[0];

						$city = $line_of_text[1];

						$state = $line_of_text[2];

						$dod = $line_of_text[3];
						
						if($dod == '')
						{
							$dod = 1;
						}

						$codc = $line_of_text[4];
						
						if( $codc == 'y' || $codc == 'Y' )
						{
							$cod = 'yes';
						}
						elseif( $codc == 'n' || $codc == 'N' )
						{
							$cod = 'no';
						}
						else
						{
							$cod = 'no';
						}

						if($pincode)
						{
							
							$num_rows = $wpdb->get_var(" SELECT COUNT(*) FROM `".$table_prefix."check_pincode_p` where `pincode` = '$pincode' ");

							if($num_rows == 0)
							{
								
								//echo "INSERT INTO `".$table_prefix."check_pincode_p` (`pincode`, `city`, `state`, `dod`, `cod`) VALUES ('$pincode', '$city', '$state', $dod, '$cod')";
								
								$wpdb->query(" INSERT INTO `".$table_prefix."check_pincode_p` (`pincode`, `city`, `state`, `dod`, `cod`) VALUES ('$pincode', '$city', '$state', $dod, '$cod') ");

							}
							else
							{
								
								//echo "UPDATE `".$table_prefix."check_pincode_p` SET `pincode`='$pincode', `city`='$city', `state`='$state', `dod`='$dod', `cod`='$cod' where `pincode` = '$pincode' ";
								
								$wpdb->query(" UPDATE `".$table_prefix."check_pincode_p` SET `pincode`='$pincode', `city`='$city', `state`='$state', `dod`='$dod', `cod`='$cod' where `pincode` = '$pincode' ");

							}
						}

					}

					fclose($file_handle);

					unlink($filename);

				} 

				else 
				{

				}

		}

	}

	?>

	<div class="wrap">

		<h2>Import Zip Codes in CSV Format</h2>

		<form name="upload_zip_form" id="upload_zip_form" method="post" action="" enctype="multipart/form-data">

			<p>Upload File: &nbsp; <input type="file" name="pincsv" id="pincsv"></p>

			<input type="submit" value="Import" class="button" id="upload-zip" name="upload-zip" >

		</form>		
		<?php 
		$max_upload = (int)(ini_get('upload_max_filesize')); 
		$plugin_dir_url =  plugin_dir_url( __FILE__ );
		?>		
		<p class="max-upload-size">Maximum upload file size: <?php echo $max_upload; ?> MB.</p>
		<p class="upload-html-bypass hide-if-no-js">
		<a href="<?php echo $plugin_dir_url; ?>assets/testfile/test.csv">Example CSV File</a>.
		</p>
	</div>

	<?php

}

?>