<?php 
if(empty($title) || empty($email)) return;
?>
<div class="card card-widget single-listing-widget">  
    <div class="card-body widget">
        <h6 class="mb-0"><?php printf('<a class="text-underline" href="mailto:%2$s">%1$s</a>', 
        esc_attr_x($title, 'Claim text', 'control-listings'), 
        $email
        ) ?></h6>
    </div>
</div>