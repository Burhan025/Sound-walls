<?php get_header(); ?>

	<div class="grid_12 job-content">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            
            	<h2><?php the_title(); ?></h2>
            
              <div class="project-img">
			  <?php
              if ( has_post_thumbnail() ) {
                    the_post_thumbnail('medium');
                } 
			  ?>
              </div>
              
			  <?php the_content(); ?>
              
              <div style="clear:both;"></div>
              
              
              <?php the_field("add_project_details"); ?>
              
                
            <?php endwhile; else : ?>
 				<p><?php _e( 'Sorry, no Jobs matched your criteria.' ); ?></p>
			 <?php endif; ?>
            </div>
    
<?php get_footer(); ?>
