<?php include("include/init.php"); ?>

<?php 

	if(empty($_GET['id'])) {
		redirect_to("testimoni.php");
	}

	$event_wedding = EventWedding::find_by_id($_GET['id']);

	if($event_wedding) {
		$session->message("<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
	              <strong><i class='mdi mdi-account-alert'></i></strong> The {$event_wedding->title} Dihapus.
	              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
	                <span aria-hidden=\"true\">&times;</span>
	              </button>
	            </div>");
		$event_wedding->delete_photo();
		redirect_to("testimoni.php");
	} else {
		redirect_to("testimoni.php");
	}

?>
