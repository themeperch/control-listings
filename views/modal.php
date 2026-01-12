<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary visually-hidden" data-bs-toggle="modal" href="#controlListingsModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal modal-lg fade" id="controlListingsModal" tabindex="-1" aria-labelledby="controlListingsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-5" id="controlListingsModalLabel">Modal title</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php 
          if(!is_user_logged_in()){
            do_action('control_listing_user_profile'); 
          }          
        ?>
      </div>      
    </div>
  </div>
</div>
