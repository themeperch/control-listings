<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login" type="button" role="tab" aria-controls="pills-login" aria-selected="true">Login</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register" type="button" role="tab" aria-controls="pills-register" aria-selected="false">Register</button>
  </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab" tabindex="0">
        <?php do_action('control_listing_user_profile') ?>
  </div>
  <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab" tabindex="0">
    <?php do_action('control_listing_user_register') ?>
  </div>  
</div>
