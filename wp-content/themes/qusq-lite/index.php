<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme ( the other being style.css ).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Qusq_Lite
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="ish-container-fluid">
				<div class="ish-container-inner">
					<div id="ish-main-content" class="<?php echo esc_attr( qusq_lite_main_content_classes( array('ish-content-parallax') ) ); ?>">
						<?php
                        $plugin_active = false;

                        // find out plugin state for adjusting listing of our Posts
                        foreach (get_option('active_plugins') as $plugin) {
                            if($plugin === 'test-plugin/test-plugin.php') {
                                $plugin_active = true;
                            }
                        }

                        // plugin is active, browse posts according to its settings
                        if($plugin_active && implode(" ",get_option('featured_category_slider')) == 'yes') :
                            $number_posts = 0;

                            // get number of posts from Test Plugin radio button field
                            switch(implode(" ",get_option('featured_category_slider_number_posts'))) {
                                case "two" : $number_posts = 2; break;
                                case "three" : $number_posts = 3; break;
                                case "four" : $number_posts = 4; break;
                            }

                        // get all Posts without category -> Featured (Display max 3 Posts per page)
                        // unfortunately pagination on page 2, 3 does not work (only first page, ask boys WHY???)
                        $paged = get_query_var('page') ? get_query_var('page') : 1; //The magic, ternary if statement
                        $args = array(
                            'post_type' => array('post'),
                            'posts_per_page' => 3,
                            'paged' => $paged,
                            'order' => 'ASC',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'category',
                                    'field' => 'slug',
                                    'terms' => 'featured',
                                    'operator' => 'NOT IN'
                                )
                            )
                        );

                        // list all Posts without category -> Featured
                        query_posts($args);
                        if ( have_posts() ) :
                            while ( have_posts() ) : the_post();
                                get_template_part( 'template-parts/archive/archive', get_post_format() );
                            endwhile;
                            wp_reset_postdata();
                        endif; ?>

                        <?php
                            $postsAll = array(
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page'=> $number_posts,
                                'order' => 'ASC',
                                'orderby'   => 'rand',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'category',
                                        'field' => 'slug',
                                        'terms' => 'featured',
                                    )
                                )
                            );

                            // get template part custom-slider for listing Posts with category -> Featured
                            $posts = get_posts($postsAll);
                            if( $posts ):
                                set_query_var('posts', $posts);
                                get_template_part('template-parts/content', 'custom-slider');
                            ?>
                            <?php else :
                                get_template_part( 'template-parts/content', 'none' );
                            endif;

                        // list all posts, plugin is Disabled
                        else :
                            $paged = get_query_var('page') ? get_query_var('page') : 1; //The magic, ternary if statement
                            $args  = array(
                                'post_type' => array('post'),
                                'posts_per_page' => 3,
                                'order' => 'ASC',
                                'paged' => $paged
                            );
                            query_posts($args);
                            if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                <?php  get_template_part( 'template-parts/archive/archive', get_post_format() );?>
                            <?php endwhile; ?>
                                <?php wp_reset_postdata();?>
                            <?php endif; ?>
                        <?php endif;?>
					</div>
					<?php if ( qusq_lite_display_sidebar() ) : ?>
						<div class="ish-sidebar ish-sidebar-right">
							<?php
							get_sidebar();
							?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="ish-container-fluid ish-pagination-container">
				<div class="ish-container-inner">
					<?php qusq_lite_the_posts_navigation(); ?>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();