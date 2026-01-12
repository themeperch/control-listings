<?php
namespace ControlListings\Widgets;
defined( 'ABSPATH' ) || exit;

class Listing_News extends \Elementor\Widget_Base{
	use Helper;
    public function get_name() {
		return 'event_news';
	}

	public function get_title() {
		return esc_html__( 'Listing News', 'control-listings' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'control-listings' ];
	}

	public function get_keywords() {
		return [ 'news', 'post', 'blog', 'control', 'event' ];
	}

    protected function register_controls() {        

		// Content Tab Start
		
		$this->start_controls_section(
			'content_tab',
			[
				'label' => esc_html__( 'Section News', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
		$this->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( " Conference news and event industry trends", 'control-listings' ),
			]
		);
        $this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Sub-title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => '',
			]
		);

		$this->add_control(
			'image_hover_text',
			[
				'label' => esc_html__( 'Image hover text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'VIEW',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Our Blog',
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Button link', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'deflink' => '',
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label' => esc_html__( 'Read more text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Read More',
			]
		);
        

		$this->end_controls_section();


		$this->wp_query();

		// Content Tab End

		$this->start_controls_section(
			'content_style',
			[
				'label' => esc_html__( 'Design', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background image', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,				
				'selectors' => [
					'{{WRAPPER}} .listing-faqs' => '--bg-image: url({{URL}})',
				],
			]
		);

		$this->add_control(
			'dots',
			[
				'label' => esc_html__( 'Dots', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				
			]
		);
		$this->add_control(
			'shadow',
			[
				'label' => esc_html__( 'Shadow', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				
			]
		);
		$this->add_control(
			'separator',
			[
				'label' => esc_html__( 'Separator', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);
		

		$this->end_controls_section();


	}

	protected function render() {
        $settings = $this->get_settings_for_display();
		control_listings_template_part('elements/listing-news', '', $settings);
	}
}