<?php
global $table_prefix, $wpdb;

if(sanitize_text_field( $_GET['action'] ) == 'delete' || sanitize_text_field( $_GET['action2'] ) == 'delete' || sanitize_text_field( $_GET['action'] ) == 'delete-all' )
{
	
	//print_r($_GET);
	
	$id = $_GET['id'];
	
	$product_id = $_GET['product_id'];
	
	if($product_id != '' )
	{
		$phen_pincodes_list = get_post_meta( $product_id, 'phen_pincode_list' );
		
		$phen_pincode_list = $phen_pincodes_list[0];
		
		if( array_key_exists(  $id,$phen_pincode_list ) )
		{
			 
			unset($phen_pincode_list[$id]);

			update_post_meta( $product_id,'phen_pincode_list',$phen_pincode_list );
		}
		
		
		if( sanitize_text_field( $_GET['action'] ) == 'delete-all' )
		{
			
			$phen_pincode_list = array();
			 
			update_post_meta( $product_id,'phen_pincode_list',$phen_pincode_list );
			
		}
		
		
	}
	else
	{
		
		if( isset($id) )
		{

			
			$wpdb->query( $wpdb->prepare( "DELETE FROM `".$table_prefix."check_pincode_p` WHERE `id` = %d", $id ) );
			
			$delete_check = true;


		}

		$ids = $_GET['pincode'];

		if( isset( $ids ) )
		{

			$count = count($ids);

			for($i=0;$i<$count;$i++)

			{


				$_id = $ids[$i];


				$wpdb->query( $wpdb->prepare( "DELETE FROM `".$table_prefix."check_pincode_p` WHERE `id` = %d ", $_id ) );


			}

		}
	
	}

}


if(!class_exists('WP_List_Table')){

    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

}

class TT_Example_List_Tablee extends WP_List_Table {

    function __construct(){

        global $status, $page;

        //Set parent defaults

        parent::__construct( array(

            'singular'  => 'Zipcode',     //singular name of the listed records

            'plural'    => 'Zipcodes',    //plural name of the listed records

            'ajax'      => false        //does this table support ajax?

        ) );

    }

    function column_default($item, $column_name){


    }

    function column_title($item){

        //Build row actions

        $actions = array(

            'edit'      => sprintf('<a href="?page=%s&action=%s&p=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id']),

            'delete'    => sprintf('<a href="?page=%s&action=%s&p=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id']),

        );

        

        //Return the title contents

        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',

            /*$1%s*/ $item['pincode'],

            /*$2%s*/ $item['id'],

            /*$3%s*/ $this->row_actions($actions)

        );

    }

    function column_cb($item){

        return sprintf(

            '<input type="checkbox" name="%1$s[]" value="%2$s" />',

            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")

            /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id

        );

    }

    function get_columns(){

		if( empty($_GET['product_id']) && $_GET['product_id'] == '' ) {
			
			$columns = array(

				'id'        => '<label for="id-select-all-1" class="screen-reader-text">Select All</label><input class="id-select-all-1" type="checkbox" />', //Render a checkbox instead of text

				'pincode'     => 'Pincode',

				'city'    => 'City',

				'state'  => 'State',

				'dod'  => 'Delivery within days',

				'cod'  => 'Cash on delivery'

			);
		
		}
		else
		{
				$columns = array(
				
					'pincode'     => 'Pincode',

					'city'    => 'City',

					'state'  => 'State',

					'dod'  => 'Delivery within days',

					'cod'  => 'Cash on delivery'

			);

		}

        return $columns;

    }


    function get_sortable_columns() {

		if(isset($_GET['product_id']) && $_GET['product_id'] == '' ) {
			
			$sortable_columns = array(

				'pincode'     => array('pincode',false),  //true means it's already sorted

				'city'    => array('city',false),

				'state'  => array('state',false),

				'dod'  => array('dod',false),

				'cod'  => array('cod',false)

			);
			
		}
		else
		{
			
			$sortable_columns = array();
			
		}
		
        

        return $sortable_columns;

    }

    function get_bulk_actions() {

		if(empty( $_GET['product_id'] ) )  {
			
			$actions = array(

				'delete'    => 'Delete'

			);
			
		}
		else
		{
			
			$actions = array();
			
		}
		
        return $actions;

    }

    function process_bulk_action() {

        //Detect when a bulk action is being triggered...

        if( 'delete'===$this->current_action() ) {

            wp_die('Items deleted (or they would be if we had items to delete)!');

        }

    }

    function prepare_items() {

	   global $wpdb, $_wp_column_headers,$table_prefix;

		/* -- Preparing your query -- */

        $query = "SELECT * FROM `".$table_prefix."check_pincode_p`";

		/* -- Ordering parameters -- */

       //Parameters that are going to be used to order the result

       $orderby = !empty($_GET["orderby"]) ? esc_sql($_GET["orderby"]) : 'ASC';

       $order = !empty($_GET["order"]) ? esc_sql($_GET["order"]) : '';

	   if( isset( $_GET['product_id'] ) && $_GET['product_id'] == '' ) {
		   
			if(!empty($orderby) & !empty($order)){ $query.=' ORDER BY '.$orderby.' '.$order; }
		
	    }
		
		/* -- Pagination parameters -- */

        //Number of elements in your table?
		if( empty( $_GET['product_id'] ) )  {
			
			$totalitems = $wpdb->query($query); //return the total number of affected rows
		
		}
		else{
			
			$records = get_post_meta( $_GET['product_id'],'phen_pincode_list' )[0];
			
			$totalitems = count( $records );
			
		}
        //How many to display per page?

        $perpage = 15;

        //Which page is this?

        $paged = !empty($_GET["paged"]) ? esc_sql($_GET["paged"]) : '';

        //Page Number

        if(empty($paged) || !is_numeric($paged) || $paged<=0 ){ $paged=1; }

        //How many pages do we have in total?

        $totalpages = ceil($totalitems/$perpage);

        //adjust the query to take pagination into account

       if(!empty($paged) && !empty($perpage)){

          $offset=($paged-1)*$perpage;

         $query.=' LIMIT '.(int)$offset.','.(int)$perpage;

       }

		/* -- Register the pagination -- */

      $this->set_pagination_args( array(

         "total_items" => $totalitems,

         "total_pages" => $totalpages,

         "per_page" => $perpage,

      ) );

	 
      //The pagination links are automatically built according to those parameters

	  /* -- Register the Columns -- */

      $columns = $this->get_columns();

      $hidden = array();

	  $sortable = $this->get_sortable_columns();

	  $this->_column_headers = array($columns, $hidden, $sortable);

	/* -- Fetch the items -- */
	
		if( empty( $_GET['product_id'] ) ) {
			
			$this->items = $wpdb->get_results($query);
			
		}
		else
		{

			$this->items = array_slice($records, $offset, $perpage,true);
			
		}

    }

	function display_rows() 
	{

			$records = $this->items;
			
			//Get the columns registered in the get_columns and get_sortable_columns methods

			list( $columns, $hidden ) = $this->get_column_info();

			//Loop for each record

			if(!empty($records)) {
				
				foreach($records as $rec) 
				{

						//Open the line
						
						if(isset($_GET['product_id']) && $_GET['product_id'] != '' ) {
							
							echo '<tr class="alternate" id="record_'.$rec[0].'">';
							
						}
						else
						{
							
							echo '<tr class="alternate" id="record_'.$rec->id.'">';
							
						}

						foreach ( $columns as $column_name => $column_display_name ) {

								//Style attributes for each col

								$class = "class='$column_name column-$column_name'";

								$style = "";

								if ( in_array( $column_name, $hidden ) ) $style = ' style="display:none;"';

								$attributes = $class . $style;

								//edit link
								
								if(isset($_GET['product_id']) && $_GET['product_id'] != '' ) {
									
									$editlink  = '/wp-admin/link.php?action=edit&id='.stripslashes($rec[0]);

									//Display the cell

									switch ( $column_name ) {

											case "id":     echo '<th '.$attributes.'><input name="pincode[]" type="checkbox" value="'.stripslashes($rec[0]).'" /></th>';break;

											case "pincode": 
											
											//echo '<td '.$attributes.'>'.stripslashes($rec[0]).'</td>';

											echo '<td '.$attributes.'>'.stripslashes($rec[0]).'<div class="row-actions"><span class="delete"><a href="?page=list_pincodes&amp;action=delete&amp;id='.stripslashes($rec[0]).'&amp;product_id='.stripslashes($_REQUEST['product_id']).'">Delete</a></span></div></td>';

											break;

											case "city": echo '<td '.$attributes.'>'.stripslashes($rec[1]).'</td>'; break;

											case "state": echo '<td '.$attributes.'>'.stripslashes($rec[2]).'</td>'; break;

											case "dod": echo '<td '.$attributes.'>'.stripslashes($rec[3]).'</td>'; break;

											case "cod": {										if($rec[4] == 'yes'){ $reccod = 'Enable'; } 										if($rec[4] == 'no'){ $reccod = 'Disable'; } 										echo '<td '.$attributes.'>'.stripslashes($reccod).'</td>'; break; }

									}
									
								}
								else
								{
									
									$editlink  = '/wp-admin/link.php?action=edit&id='.stripslashes($rec->id);

									//Display the cell

									switch ( $column_name ) {

											case "id":     echo '<th '.$attributes.'><input name="pincode[]" type="checkbox" value="'.stripslashes($rec->id).'" /></th>';break;

											case "pincode": echo '<td '.$attributes.'>'.stripslashes($rec->pincode).'<div class="row-actions"><span class="edit"><a href="?page=list_pincodes&amp;action=edit&amp;id='.stripslashes($rec->id).'">Edit</a> | </span><span class="delete"><a href="?page=list_pincodes&amp;action=delete&amp;id='.stripslashes($rec->id).'">Delete</a></span></div></td>'; break;

											case "city": echo '<td '.$attributes.'>'.stripslashes($rec->city).'</td>'; break;

											case "state": echo '<td '.$attributes.'>'.stripslashes($rec->state).'</td>'; break;

											case "dod": echo '<td '.$attributes.'>'.stripslashes($rec->dod).'</td>'; break;

											case "cod": {										if($rec->cod == 'yes'){ $reccod = 'Enable'; } 										if($rec->cod == 'no'){ $reccod = 'Disable'; } 										echo '<td '.$attributes.'>'.stripslashes($reccod).'</td>'; break; }

									}
								
								}

						}

						//Close the line

						echo'</tr>';

				}
				
			}

	}

}

function list_pincodes_f()
{

	global $table_prefix, $wpdb;

	//Create an instance of our package class...

   $testListTable = new TT_Example_List_Tablee();

    //Fetch, prepare, sort, and filter our data...

   $testListTable->prepare_items();

    ?>

    <div class="wrap">

        <?php

			if(isset($_GET['id']))
			{
				
				$id = sanitize_text_field( $_GET['id'] );
				
			}
			

			if(isset($_GET['action'] ) && sanitize_text_field( $_GET['action'] ) == 'delete' )

			{

			?>

				<div class="updated below-h2" id="message"><p>Deleted Successfully.</p></div>

			<?php

			}
/* 			else
			{
				
				?>

				<div class="error below-h2" id="message"><p>Not Found.</p></div>

			<?php
				
			} */

			if(isset($_GET['action'] ) && sanitize_text_field( $_GET['action'] ) == 'edit' && isset($id))
			{

				if(sanitize_text_field( $_POST['submit'] ) == 'Update')
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
						$wpdb->query( "UPDATE `".$table_prefix."check_pincode_p` SET `pincode`='$pincode', `city`='$city', `state`='$state', `dod`='$dod', `cod`='$cod' where `id` = $id" );

						?>

							<div class="updated below-h2" id="message"><p>Updated Successfully.</p></div>

						<?php
					}
					else
					{
						?>

							<div class="error below-h2" id="message"><p> Please Fill Valid Data.</p></div>

						<?php
					}

				}

				$qry22 = $wpdb->get_results( "SELECT * FROM `".$table_prefix."check_pincode_p` where `id` = $id" ,ARRAY_A);	

				foreach($qry22 as $qry)
				{
				}

				?>

				<div id="icon-users" class="icon32"><br/></div>

				<h2>Update Zip Code</h2>

					<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->

				<form action="" method="post" id="uzip_form" name="uzip_form">

					<table class="form-table">

					<tbody>

						<tr class="user-user-login-wrap">

							<th><label for="user_login">Pincode</label></th>

							<td><input type="text" class="regular-text" value="<?php echo $qry['pincode'];?>" id="pincode" name="pincode"></td>

						</tr>

						<tr class="user-first-name-wrap">

							<th><label for="first_name">City</label></th>

							<td><input type="text" class="regular-text" value="<?php echo $qry['city'];?>" id="city" name="city"></td>

						</tr>

						<tr class="user-last-name-wrap">

							<th><label for="last_name">State</label></th>

							<td><input type="text" class="regular-text" value="<?php echo $qry['state'];?>" id="state" name="state"></td>

						</tr>

						<tr class="user-nickname-wrap">

							<th><label for="nickname">Delivery within days</label></th>

							<td><input type="number" min="1" step="1" class="regular-text" value="<?php echo $qry['dod'];?>" id="dod" name="dod"></td>

						</tr>

						<tr class="user-nickname-wrap">

							<th><label for="nickname">Enable Cash on delivery For This Pincode</label></th>
							
							<th><label for="nickname"><input type="radio" <?php if($qry['cod'] == 'no'){ ?>checked="checked"<?php } ?> value="no" name="cod">No</label>

							<label for="nickname"><input type="radio" <?php if($qry['cod'] == 'yes'){ ?>checked="checked"<?php } ?> value="yes" name="cod">Yes</label></th>

						</tr>

					</tbody>

				</table>

					<p class="submit"><a class="button" href="?page=list_pincodes">Back</a>&nbsp;&nbsp;<input type="submit" value="Update" class="button button-primary" id="submit" name="submit"></p>

			</form>

				<?php

			}
			else
			{

				?>

				<div id="icon-users" class="icon32"><br/></div>

				<?php
				
				if(isset($_GET['product_id'] ) && $_GET['product_id'] == '' ) {
						
					?>
					
						<h2>Zip Code List <a class="add-new-h2" href="?page=add_pincode">Add New</a></h2>
						
					<?php
				
				}
				else
				{
					
					if(isset($_GET['product_id'] ) ) {
						?>
						
							<h2>Zip Code List of Product id - <?php echo $_REQUEST['product_id']; ?></h2>
						
						<?php
					}
				}
				
				?>
				

				<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->

				<form id="pincodes-filter" method="get">

					<!-- For plugins, we also need to ensure that the form posts back to our current page -->

					<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />

					<input type="hidden" name="product_id" value="<?php echo $_REQUEST['product_id'] ?>" />
					
					<!-- Now we can render the completed list table -->

					<?php $testListTable->display(); ?>

				</form>

				<?php

			}

		?>

    </div>

	<script>

		jQuery('.id-select-all-1').click(function() {

			if (jQuery(this).is(':checked')) {

				jQuery('div input').attr('checked', true);

			} else {

				jQuery('div input').attr('checked', false);

			}

		});

	</script>

    <?php

}
?>