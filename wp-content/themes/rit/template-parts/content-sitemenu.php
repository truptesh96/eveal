<?php 
function display_custom_menu() {
    // Get the menu object by menu name or slug
    $menu_name = 'Site Menu'; // Change to your actual menu name
    $menu_object = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_object) {
        echo 'Menu not found.';
        return;
    }
    
    $menu_id = $menu_object->term_id; // Get the numerical menu ID
    $menu_items = wp_get_nav_menu_items($menu_id);
    
    if (!$menu_items) return;
    
    $menu_tree = build_menu_tree($menu_items);
    echo '<ul class="menu level1 navig nav-menu">';
    render_menu_tree($menu_tree, 1); // Start rendering from level 1
    echo '</ul>';
} 
?>

<?php
// Build hierarchical menu array
function build_menu_tree($menu_items, $parent_id = 0) {
    $tree = [];
    foreach ($menu_items as $item) {
        if ((int)$item->menu_item_parent === (int)$parent_id) { // Compare parent IDs as integers
            $children = build_menu_tree($menu_items, $item->ID);
            if ($children) {
                $item->children = $children;
            }
            $tree[] = $item;
        }
    }
    return $tree;
}

// Recursive function to render menu tree with levels and submenu classes
function render_menu_tree($menu_tree, $level) {
    foreach ($menu_tree as $item) {
        echo '<li class="menu-item dflex wid100 level' . $level . ' ">';
        echo '<div class="leftPan"><div class="hasBg ">' . wp_get_attachment_image(get_field('menu_item_image', $item->ID), 'full', false, array('class' => 'bgItemdrop')  ) . '</div>';
        echo '<a class="'.$item->classes[0].'"  href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></div>';
        if (!empty($item->children)) {
            echo '<div class="rightPan"><span role="button" class="plusIcon toggleTrigger accordionTrig"></span>';
            echo '<ul class="submenu reset level accordionContent ' . ($level + 1) . '">';
            render_menu_tree($item->children, $level + 1);
            echo '</ul></div>';
        }
        
        echo '</li>';
    }
}
?>

<div class="menu-site-menu-container">
    <?php display_custom_menu(); ?>
</div>