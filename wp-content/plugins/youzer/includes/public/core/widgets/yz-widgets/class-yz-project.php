<?php

class YZ_Project {

    /**
     * # Profile Content.
     */
    function widget() {

        // Get Project Data
        $project_description = wp_kses_post( yz_data( 'wg_project_desc' ) );

        if ( empty( $project_description ) ) {
            return;
        }
        
        // Get Project Title.
        $project_title = sanitize_text_field( yz_data( 'wg_project_title' ) );

        if ( ! $project_title ) {
            return false;
        }

        $project_tags        = yz_data( 'wg_project_tags' );
        $project_categories  = yz_data( 'wg_project_categories' );
        $project_link        = yz_esc_url( yz_data( 'wg_project_link' ) );
        $img_data            = yz_data( 'wg_project_thumbnail' );
        $project_thumbnail   = yz_get_file_url( $img_data );
        $project_type        = sanitize_text_field( yz_data( 'wg_project_type' ) );

        // Get Categories.
    	if ( $project_categories ) {
            $project_categories = implode( ', ', $project_categories );
        }

    	// Show / Hide Project Elements
    	$display_meta  = yz_option( 'yz_display_prjct_meta', 'on' );
        $display_tags  = yz_option( 'yz_display_prjct_tags', 'on' );
    	$display_icons = yz_option( 'yz_display_prjct_meta_icons', 'on' );

    	?>

    	<div class="yz-project-content">
    		<?php
                yz_get_post_thumbnail(
                    array(
                        'widget'  => 'project',
                        'img_url' => $project_thumbnail
                    )
                );
            ?>
    		<div class="yz-project-container">
    			<div class="yz-project-inner-content">
    				<div class="yz-project-head">

                        <?php if ( $project_type ) : ?>
    					   <a class="yz-project-type"><?php echo $project_type; ?></a>
                        <?php endif; ?>

                        <?php if ( $project_title ) : ?>
    					   <h2 class="yz-project-title"><?php echo $project_title; ?></h2>
                        <?php endif; ?>

    					<?php if ( 'on' == $display_meta ) : ?>
    					<div class="yz-project-meta">
    						<ul>
                                <?php if ( $project_categories ) : ?>
        							<li class="yz-project-categories">
            							<?php if ( 'on' == $display_icons ) : ?>
                                            <i class="fas fa-tags"></i>
                                        <?php endif ?>
                                        <?php echo $project_categories; ?>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $project_link ) : ?>
                                    <li class="yz-project-link">
            							<?php if ( 'on' == $display_icons ) : ?>
                                            <i class="fas fa-link"></i>
                                        <?php endif; ?>
                                        <a href="<?php echo esc_url( $project_link ) ;?>"><?php echo $project_link; ?></a>
            							
                                    </li>
                                <?php endif; ?>
    						</ul>
    					</div>
    					<?php endif; ?>
    				</div>

    				<div class="yz-project-text"><?php echo apply_filters( 'the_content', $project_description ); ?></div>

    				<?php if ( 'on' == $display_tags ) : ?>
        				<div class="yz-project-tags">
        					<?php yz_get_project_tags( $project_tags ); ?>
        				</div>
    				<?php endif; ?>

    			</div>
    		</div>
    	</div>

    	<?php
    }
    
}