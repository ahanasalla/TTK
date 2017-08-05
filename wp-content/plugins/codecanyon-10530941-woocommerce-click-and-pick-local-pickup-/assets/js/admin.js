jQuery('document').ready( function($) {
	
    $( "#the-list" ).sortable({
    	 update: function (event, ui) {
    	 	branchesId = [];
    	 	$("#the-list tr").each(function(key, item) {
	 			var id = $(item).attr("id");
    	 		branchesId.push(id.match(/\d+/)[0]);			// push them to array 
    	 	})
	 		// then let's send them to the database 
	 		 $.post(
	            ajaxurl,
	            {
	                action: 'save_branches_order',
	                ids: branchesId,
	            },
	            function (response) {
	            	// echo response;
	            }
	        );
            
        }
    });
    $( "#the-list" ).disableSelection();


});