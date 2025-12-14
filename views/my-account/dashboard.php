<div class="listings-user-account row g-50 mb-30">
    <div class="col-lg-3">
    <ul class="nav flex-lg-column nav-pills" id="myAccount" role="tablist">
        <?php 
        $count = 1;
        $active_tab = !empty($_GET['tab'])? esc_attr($_GET['tab']) : 'dashboard';
        foreach (control_listing_get_account_menu_items() as $endpoint => $label) : 
                ?>
                <li class="nav-item" role="presentation">
                    <a id="<?php echo esc_attr($endpoint) ?>-tab" class="<?php echo control_listing_dashboard_menu_item_classes($endpoint) ?>" href="<?php echo esc_url(control_listing_get_account_endpoint_url($endpoint)) ?>" role="tab"><?php echo esc_attr($label) ?></a>
                </li>
                <?php
                $count++;
        endforeach;
        ?>        
    </ul>
    </div>
    <div class="tab-content col-lg-9" id="myAccountContent">      
        <div class="tab-pane <?php echo esc_attr($active_tab) ?>-tab-pane fade show active" role="tabpanel" aria-labelledby="<?php echo esc_attr($active_tab) ?>-tab" tabindex="0">
            <?php do_action('control_listing_user_account_content'); ?>
        </div>
    </div>
</div>
