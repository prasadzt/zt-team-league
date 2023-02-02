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

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Team Content', 'elementor-list-widget' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		/* Start repeater */

		$repeater = new \Elementor\Repeater();


		
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
				'options' => [
					'default' => esc_html__( 'Select League', ZTEC_TEXT_DOMAIN ),
					'yes' => esc_html__( 'Yes', ZTEC_TEXT_DOMAIN ),
					'no' => esc_html__( 'No', ZTEC_TEXT_DOMAIN ),
				],
				'default' => 'no',
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
				'label' => esc_html__( 'Team Style', 'elementor-list-widget' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'elementor-list-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-list-widget-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-list-widget-text > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
				'selector' => '{{WRAPPER}} .elementor-list-widget-text, {{WRAPPER}} .elementor-list-widget-text > a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-list-widget-text',
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
		$html_tag = [
			'ordered' => 'ol',
			'unordered' => 'ul',
			'other' => 'ul',
		];
		$this->add_render_attribute( 'team', 'class', 'elementor-list-widget' );
		?>
			<?php
			foreach ( $settings['team_items'] as $index => $item ) {
				$repeater_setting_key = $this->get_repeater_setting_key( 'text', 'list_items', $index );
				$this->add_render_attribute( $repeater_setting_key, 'class', 'elementor-list-widget-text' );
				$this->add_inline_editing_attributes( $repeater_setting_key );
				?>
				<li >
					<?php
					$title = $settings['team_items'][$index]['text'];

					if ( ! empty( $item['link']['url'] ) ) {
						$this->add_link_attributes( "link_{$index}", $item['link'] );
						$linked_title = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( "link_{$index}" ), $title );
						echo $linked_title;
					} else {
						echo $title;
					}
					?>
				</li>
				<?php
			}
			?>

<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$data= new WP_Query(array(
    'post_type'=>ZTEC_TEAM_POST_TYPE, // your post type name
    'posts_per_page' => 3, // post per page
    'paged' => $paged,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_status'      => 'publish',
	'tax_query' => array(
		array(
			'taxonomy' => 'league',
			'field'    => 'term_id',
			'terms'    => 34,
			),
		),
));

if($data->have_posts()) :
	echo '<div class="row">';
    while($data->have_posts())  : $data->the_post(); ?>
			<div  class="column <?php $this->print_render_attribute_string( $repeater_setting_key ); ?>">
				<div class="card">
					<img src="<?php echo  wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );  ?>" alt="Jane" style="width:100%">
					<div class="container">
					<h2><a href="<?php echo get_the_permalink();?>"><?php echo get_the_title() ?></a></h2>
					<p class="title"><?php echo get_post_meta( get_the_ID(), '_ztec_team_nickname', true ); ?></p>
					<p><?php echo get_post_meta( get_the_ID(), '_ztec_team_history', true ); ?></p>
					</div>
				</div>
			</div>
<?php
    endwhile;
	echo '</div>';

    $total_pages = $data->max_num_pages;

    if ($total_pages > 1){

        $current_page = max(1, get_query_var('paged'));

		echo '<div class="row">';
        echo paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text'    => __('« prev'),
            'next_text'    => __('next »'),
        ));
		echo '</div>';

    }
 endif; 
 wp_reset_postdata();?>


		<?php
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
