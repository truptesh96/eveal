<?php
/*
 * Child table
 */

/*
 * 
 * Append pagination and sort GET vars if present
 */
?>

<!--WRAPPER-->
<div id="types-child-table-<?php echo "{$this->parent_post_type}-{$this->child_post_type}"; ?>" class="js-types-relationship-child-posts wpcf-pr-has-entries wpcf-pr-pagination-update wpcf-relationship-save-all-update">

    <!--TITLE-->
    <div class="wpcf-pr-has-title"><?php echo $this->child_post_type_object->label; ?></div>
<?php
if ( isset($this->child_post_type_object->description) && $this->child_post_type_object->description ) {
    echo wpautop($this->child_post_type_object->description);
}
?>
    <!--ADD NEW-->
    <a href="<?php
        echo admin_url( 'admin-ajax.php?action=wpcf_ajax&amp;'
                . 'wpcf_action=pr_add_child_post&amp;post_type_parent='
                . $this->parent_post_type
                . '&amp;post_id=' . $this->parent->ID
                . '&amp;post_type_child='
                . $this->child_post_type . '&_wpnonce=' . wp_create_nonce( 'pr_add_child_post' )
        );

?>" class="wpcf-pr-ajax-link js-types-add-child button-secondary"><?php echo $this->child_post_type_object->labels->add_new_item; ?></a>

    <!--REPETITIVE WARNING-->
    <?php
    if ( !empty( $this->repetitive_warning ) ):

        ?>
        <div class="wpcf-message wpcf-error"><p><?php
        _e( 'Repeating fields should not be used in child posts. Types will update all field values.', 'wpcf' );
        ?></p></div>
        <?php
    endif;

    ?>

    <!--PAGINATION TOP-->
    <?php echo $this->pagination_top; ?>

    <!--TABLE-->
    <div class="wpcf-pr-pagination-update--old">
        <div class="wpcf-pr-table-wrapper">
            <table id="wpcf_pr_table_sortable_<?php echo md5( $this->child_post_type ); ?>" class="tablesorter wpcf_pr_table_sortable js-types-child-table" cellpadding="0" cellspacing="0" style="width:100%;">
                <thead>
                    <tr>
                        <?php
                        foreach ( $headers as $header ):

                            ?>
                            <th class="wpcf-sortable">&nbsp;&nbsp;&nbsp;<?php echo $header; ?></th>
                            <?php
                        endforeach;

                        ?>
                        <th>
                            <?php
                            _e( 'Action', 'wpcf' );

                            ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$this->_dummy_post) {
                        foreach ( $rows as $child_id => $row ):
                            include dirname( __FILE__ ) . '/child-table-row.php';
                        endforeach;
                    }
                    ?>
                </tbody>
            </table>
            <?php
            if ( !defined( 'WPTOOLSET_FORMS_VERSION' ) ) {
            // Trigger date
            // TODO Move to date
            if ( !empty( $this->trigger_date ) ):

                ?>
                <script type="text/javascript">
                    //<![CDATA[
                    jQuery(function(){
                        wpcfFieldsDateInit("#wpcf-post-relationship");
                    });
                    //]]>
                </script>
                <?php
            endif;
            }
            ?>
        </div>
    </div>
    <!--PAGINATION BOTTOM-->
    <div class="wpcf-pagination-boottom"><?php echo $this->pagination_bottom; ?></div>
    <hr />
</div>
