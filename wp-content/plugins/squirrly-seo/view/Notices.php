<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php
if ($type == 'errors_count') {
    /* for the Menu counter */
    ?>
    <div style="position: relative">
        <span class='awaiting-mod count-<?php echo esc_attr($message); ?>'>
            <span class='sq_count pending-count'><?php echo esc_attr($message); ?></span>
        </span>
    </div>
<?php } elseif ($type == 'sq_error') { ?>
    <div class="sq_alert position-fixed fixed-top text-center text-white bg-danger m-0 p-3 border border-white sq-position-fixed sq-fixed-top sq-text-center sq-text-white sq-bg-danger sq-m-0 sq-p-3 sq-border sq-border-white">
        <?php echo wp_kses_post($message); ?>
    </div>
    <script>
        (function($) {
            $(".sq_alert").on('click',function () {
                $(this).remove();
            });
            setTimeout(function () {
                $('.sq_alert').remove();
            }, 5000);
        })(jQuery);
    </script>
<?php } elseif ($type == 'sq_success') { ?>
    <div class="sq_alert position-fixed fixed-top text-center text-white bg-success m-0 p-3 border border-white sq-position-fixed sq-fixed-top sq-text-center sq-text-white sq-bg-success sq-m-0 sq-p-3 sq-border sq-border-white">
        <?php echo wp_kses_post($message); ?>
    </div>
    <script>
        (function($) {
            $(".sq_alert").on('click',function () {
                $(this).remove();
            });
            setTimeout(function () {
                $('.sq_alert').remove();
            }, 3000);
        })(jQuery);
    </script>
<?php } ?>
