<?php
$modal_content = get_query_var('modal_content');

?>
<script>
	jQuery(function() {
		jQuery('#synergyjarmodel').appendTo('body');
		jQuery('#synergyjarmodel').modal('show');
});
	
</script>
<div class="modal fade " id="synergyjarmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
		  <h3><?php echo $modal_content['modal_title']; ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <div class="modal-body">
        <?php echo $modal_content['subjectmatter']; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary yz-close-dialog" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
