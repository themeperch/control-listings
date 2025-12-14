
<div class="d-flex gap-3 justify-content-end">
    <?php if($switcher && get_query_var('view') != 'map'): ?>
        <div class="listing-view-switcher d-flex gap-10">              
            <a class="btn btn-sm <?php echo (empty(get_query_var('view')) || get_query_var('view') != 'list')? 'btn-dark' : 'text-dark border border-2' ?>" href="<?php echo add_query_arg('view', 'grid'); ?>"><?php echo control_listings_get_icon_svg('ui', 'grid', 18) ?></a>  
            <a class="btn btn-sm <?php echo get_query_var('view') == 'list'? 'btn-dark' : 'text-dark border border-2' ?>" href="<?php echo add_query_arg('view', 'list'); ?>"><?php echo control_listings_get_icon_svg('ui', 'list', 18) ?></a>  
        </div>
    <?php endif; ?>
    <div class="input-group input-group-sm">
        <select class="form-select form-select-sm" name="sort" onchange="this.form.submit()">
            <?php foreach (control_listings_ordering_options() as $key => $value) : 
                $selected = !empty($_GET['sort'])? $_GET['sort'] : 'date';
                ?>
                <option value="<?php echo esc_attr($key) ?>" <?php selected( $selected, esc_attr($key) ); ?>><?php echo esc_attr($value) ?></option>
            <?php endforeach; ?>
        </select>        
    </div>    
</div>    	    

