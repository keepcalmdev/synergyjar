<?php

function content()
{

    //wp_enqueue_style('gmapsbootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');
    //wp_enqueue_script('gmap-profile-script', '/wp-content/plugins/synergyjar/js/content.js', array('jquery'));
    //wp_enqueue_style('gmapsprofiles', '/wp-content/plugins/synergyjar/css/content.css');
?>
    

    <section class="wrapper">

        <?php bp_nouveau_before_members_directory_content(); ?>

        <div class="screen-content">

            <?php bp_get_template_part('common/search-and-filters-bar'); ?>

            <div class="clear"></div>

            <div id="members-dir-list" class="members dir-list" data-bp-list="members">
                <div id="bp-ajax-loader"><?php bp_nouveau_user_feedback('directory-members-loading'); ?></div>
            </div><!-- #members-dir-list -->

            <?php bp_nouveau_after_members_directory_content(); ?>
        </div><!-- // .screen-content -->

    </section><!-- .wrapper -->

<?php
}


?>