<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Team Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Team_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Team widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'team';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Team widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Team', 'elementor-list-widget' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Team widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return ' eicon-apps';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the Team of categories the Team widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the Team of keywords the Team widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'team', 'teams', 'ordered', 'unordered' ];
	}

	/**
	 * Register Team widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$terms = get_terms([
			'taxonomy' => "league",
			'hide_empty' => false,
		]);
		
		$new_array = array();
		$i =1;
		foreach ($terms as $key => $value) {
			if($i == 1){
				$new_array['0'] = "All";
			}
			$new_array[$value->term_id] = $value->name;
			$i++;
		}
		//array_unshift($new_array,"All");
		

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Team Content', ZTEC_TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'title',
			[
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => esc_html__( 'Title', ZTEC_TEXT_DOMAIN ),
				'placeholder' => esc_html__( 'Enter Title', ZTEC_TEXT_DOMAIN ),
			]
		);

		$this->add_control(
			'league',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'League', ZTEC_TEXT_DOMAIN ),
				'options' => $new_array,
				'default' => '0',
			]
		);


		$this->add_control(
			'per_page',
			[
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label' => esc_html__( 'Enter Per Page', ZTEC_TEXT_DOMAIN ),
				'placeholder' => '0',
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 3,
			]
			
		);
		

		$this->end_controls_section();


		$this->start_controls_section(
			'style_content_section',
			[
				'label' => esc_html__( 'Team Style', ZTEC_TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', ZTEC_TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-team-widget .title > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
				'selector' => '{{WRAPPER}} .elementor-team-widget .title > a',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'description_content_style',
			[
				'label' => esc_html__( 'Description Style', 'elementor-list-widget' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Color', ZTEC_TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-team-widget .description' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-team-widget .description > a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-team-widget .description > p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .elementor-team-widget .description, {{WRAPPER}} .elementor-team-widget .description > p',
			]
		);

		$this->end_controls_section();


	}

	/**
	 * Render Team widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();


		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		if(!empty($settings['per_page'])){
			$per_page = $settings['per_page']; 
		}else{
			$per_page = 3;
		}

		if(!empty($settings['league'])){
			$tax_query = array(
				array(
					'taxonomy' => 'league',
					'field'    => 'term_id',
					'terms'    => $settings['league'],
					),
				);

		}else{
			$tax_query = array();
		}

		$data= new WP_Query(array(
			'post_type'=>ZTEC_TEAM_POST_TYPE, // your post type name
			'posts_per_page' => $per_page, // post per page
			'paged' => $paged,
			"s" => $settings['title'],
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'post_status'      => 'publish',
			'tax_query' => $tax_query,
		));

		if($data->have_posts()) :
			echo '<div class="row">';
			while($data->have_posts())  : $data->the_post(); ?>
					<div  class="column elementor-team-widget">
						<div class="card">
							<img src="<?php echo  wp_get_attachment_url( get_post_thumbnail_id(get_the_ID(),'thumbnail') );  ?>" alt="Jane" style="width:100%">
							<div class="container">
								<div class="title"><a href="<?php echo get_the_permalink();?>"><?php esc_html_e( get_the_title(), ZTEC_TEXT_DOMAIN); ?></a></div>
								<div class="description">
									<p><?php esc_html_e( get_post_meta( get_the_ID(), '_ztec_team_nickname', true ), ZTEC_TEXT_DOMAIN); ?></p>
									<p><?php esc_html_e( get_post_meta( get_the_ID(), '_ztec_team_history', true ), ZTEC_TEXT_DOMAIN); ?></p>
								</div>
							</div>
						</div>
					</div>
		<?php
			endwhile;
			echo '</div>';

			$total_pages = $data->max_num_pages;

			if ($total_pages > 1){

				$current_page = max(1, get_query_var('paged'));

				echo '<div class="row team-widget-pagination">';
				echo paginate_links(array(
					'base' => get_pagenum_link(1) . '%_%',
					'format' => '/page/%#%',
					'current' => $current_page,
					'total' => $total_pages,
					'prev_text'    => __('« '),
					'next_text'    => __(' »'),
				));
				echo '</div>';

			}
		endif; 
		wp_reset_postdata(); 

	}

	/**
	 * Render Team widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */


}
