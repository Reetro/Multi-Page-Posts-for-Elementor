<?php
namespace Elementor;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Widget_My_Custom_Elementor_Thing extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'my-blog-posts';
	}


	public function get_title()
	{
		return __('Multi Page Posts', 'multi-page-post');
	}

	public function get_icon()
	{
		// Icon name from Font Awesome 4.7.0
		// http://fontawesome.io/cheatsheet/
		return 'fas fa-list-ul';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	protected function _register_controls()
	{

		$this->start_controls_section(
			'section_my_custom',
			[
				'label' => esc_html__('Blog Posts', 'elementor'),
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __('Number of Posts Per Page', 'elementor-custom-element'),
				'type' => Controls_Manager::SELECT,
				'default' => 2,
				'options' => [
					1 => __('One', 'elementor-custom-element'),
					2 => __('Two', 'elementor-custom-element'),
					3 => __('Three', 'elementor-custom-element'),
					4 => __('Four', 'elementor-custom-element'),
					5 => __('Five', 'elementor-custom-element'),
					6 => __('Six', 'elementor-custom-element'),
					7 => __('Seven', 'elementor-custom-element'),
					8 => __('Eight', 'elementor-custom-element'),
					9 => __('Nine', 'elementor-custom-element'),
					10 => __('Ten', 'elementor-custom-element'),
				]
			]
		);


		$this->end_controls_section();
	}

	protected function content_template()
	{ 
		
	}

	public function render_plain_content($instance = [])
	{ }

	protected function render($instance = [])
	{
		// get our input from the widget settings.
		$settings = $this->get_settings();
		$post_count = !empty($settings['posts_per_page']) ? (int)$settings['posts_per_page'] : 5;
	
?>
	<div class="posts-cotainer">	
		<ul class="post-list">
			<?php
				$paged = get_query_var('paged') ? get_query_var('paged') : 1;
				$args = array('post_type' => 'case-studies', 'posts_per_page' => $post_count, 'paged' => $paged);
				$the_query = new \WP_Query($args);
			?>

			<?php if ( $the_query->have_posts() ) : ?>

				<!-- pagination here -->

				<!-- the loop -->
				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<li class="list-item">
					<?php 
						/* grab the url for the full size featured image */
						$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
					?>
						<div class="logo-container">
							<a href="<?php esc_url($featured_img_url); ?>" class="logo-img">
								<?php the_post_thumbnail( 'medium' ); ?>
							</a>
						</div>
						<div class="item-container">
							<div class="inner-container">
								<div class="content-container">
									<?php the_content();?>
								</div>
								<a class="read-full-button" href="<?php the_permalink(); ?>">
									Read Full
								</a>
							</div>
						</div>
					</li>
				<!-- end of the loop -->
				<?php endwhile; ?>

			<!-- pagination here -->
			<?php 
					echo paginate_links( array(
						'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
						'total'        => $the_query->max_num_pages,
						'current'      => max( 1, get_query_var( 'paged' ) ),
						'format'       => '?paged=%#%',
						'show_all'     => false,
						'type'         => 'plain',
						'end_size'     => 2,
						'mid_size'     => 1,
						'prev_next'    => true,
						'prev_text'    => sprintf( '<i></i> %1$s', __( 'Prev', 'text-domain' ) ),
						'next_text'    => sprintf( '%1$s <i></i>', __( 'Next', 'text-domain' ) ),
						'add_args'     => false,
						'add_fragment' => '',
					) );
			?>

			<?php wp_reset_postdata(); ?>

			<?php else : ?>
				<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
			<?php endif; ?>
		</ul>
	</div>
	<style>
		.posts-cotainer{
			position: relative; 
			left: 0;
		}

		.post-list{
			list-style: none; 
			align-content: flex-start;  
			margin: 100px 0;
		}
		.item-container{
			background-color: #FBF9F8; 
			width: 100%; 
		}
		.item-title{
			color: black;
			position: relative; 
			bottom: 20px; 
		}
		.item-title:hover{
			color: black;
			position: relative; 
			bottom: 20px; 
		}
		.content-container{
			position: relative;
			top: 20px; 
		}
		.inner-container{
			position: relative; 
			left: 10%;
			width: 60%; 
		}
		.logo-container{
			position: relative; 
			left: 10%;
			bottom: 10px; 
		}
		.read-full-button{
			-webkit-border-radius: 0;
			-moz-border-radius: 0;
			border-radius: 0px;
			font-weight: normal; 
			font-family: Arial;
			color: #0f0f0f;
			font-size: 20px;
			background: #FBF9F8;
			padding: 10px 20px 10px 20px;
			border: solid #e4643c 2px;
			text-decoration: none;
			text-align: left; 
			-webkit-transition-duration: 0.4s;
			transition-duration: 0.4s;
			position: relative;
			left: 120%;
			bottom: 100px;
		}

		.read-full-button:hover{
			background: #E4643C70;
			text-decoration: none;
			-webkit-transition-duration: 0.4s;
			transition-duration: 0.4s;
		}

		.page-numbers{
			position: relative;
			left: 10%; 
			color: black; 
			padding: 8px; 
		}

		.next{
			color: #e4643c;
			padding-left: 5%;
		}

		.prev{
			color: #e4643c;
			padding-right: 5%;
		}

		.current{
			border: 3px solid #e4643c;
			padding: 5px;
		}
	</style>
<?php
	}
}
?>