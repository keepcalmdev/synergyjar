<?php 
global $post;
setup_postdata($post);
WebinarSysteem::setPostData($post->ID);
$data_backg_clr = get_post_meta($post->ID, '_wswebinar_closedp_bckg_clr', true);
$data_backg_img = get_post_meta($post->ID, '_wswebinar_closedp_bckg_img', true);
?>
<html>
    <head>
        <title><?php echo get_the_title(); ?></title>
        <meta property="og:title" content="<?php the_title(); ?>">
        <meta property="og:url" content="<?php echo get_permalink($post->ID); ?>">
        <meta property="og:description" content="<?php echo substr(wp_strip_all_tags(get_the_content(),true), 0, 500); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8;"/>
        <style>
            html, body {
                height: 100%;
            }
            body.tmp-closed {
                <?php echo empty($data_backg_clr) ? '' : 'background-color:' . $data_backg_clr . ';'; ?>
                <?php echo empty($data_backg_img) ? '' : 'background-image: url(' . $data_backg_img . ');'; ?>
            }
            <?php
            echo (empty($data_backg_img) && empty($data_backg_clr))
                ? 'h2, h1 { color:#000 !important; }'
                : '';
            ?>
        </style>
        <?php wp_head(); ?>
    </head>
    <body class="tmp-closed">
        <div class="container" style="margin-top: 40px;">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div> 
                        <h1 class="text-center webinarTitle"><?php the_title(); ?></h1> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="closed">
                        <?php _e('Unfortunately, this webinar is closed.', WebinarSysteem::$lang_slug); ?>
                    </h2>
                    <h3 class="closed">
                        <a href="<?php echo esc_url(home_url('/')); ?>"> <?php _e('Click here', WebinarSysteem::$lang_slug); ?> </a> <?php _e('to go to our homepage.', WebinarSysteem::$lang_slug); ?>
                    </h3>
                </div>
            </div>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>