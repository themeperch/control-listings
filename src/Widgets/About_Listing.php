<?php
namespace ControlListings\Widgets;
defined( 'ABSPATH' ) || exit;

class About_Listing extends \Elementor\Widget_Base{
    public function get_name() {
		return 'about_listing';
	}

	public function get_title() {
		return esc_html__( 'About Listing', 'control-listings' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'control-listings' ];
	}

	public function get_keywords() {
		return [ 'about', 'event' ];
	}

    protected function register_controls() {

        // Content Tab Start

		$this->start_controls_section(
			'image_group',
			[
				'label' => esc_html__( 'About Listing Image', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/video/video1.jpg' ),
				],
			]
		);
        $this->add_control(
			'image2',
			[
				'label' => esc_html__( 'Choose Image2', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/video/video2.jpg' ),
				],
			]
		);
		$this->add_control(
			'video_url',
			[
				'label' => esc_html__( 'Video URL', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'https://www.youtube.com/embed/SZEflIVnhH8',
			]
		);

        $this->end_controls_section();

		// Content Tab Start

		$this->start_controls_section(
			'content_tab',
			[
				'label' => esc_html__( 'About Listing Content', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Be inspired by expert speakers in design, video, and more', 'control-listings' ),
			]
		);
        $this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Sub-title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Plan your week to make the most of all the sessions and labs, Community Listingor activities, and fun ways to connect with other creatives.', 'control-listings' ),
			]
		);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
			'count',
			[
				'label' => esc_html__( 'Count', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '100',
			]
		);
        $repeater->add_control(
			'count_title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '100',
			]
		);

        $this->add_control(
			'counter',
			[
				'label' => esc_html__( 'Counter', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'count' => '07',
						'count_title' => esc_html__( 'Days Listing', 'control-listings' ),
					],
					[
						'count' => '20+',
						'count_title' => esc_html__( 'Speakers', 'control-listings' ),
					],
				],
				'title_field' => '{{{ count }}} <strong>{{{ count_title }}}</strong>',
			]
		);

        $this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Resister Now', 'control-listings' ),
			]
		);
        $this->add_control(
			'button_url',
			[
				'label' => esc_html__( 'Button text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '#',
			]
		);

		$this->end_controls_section();

		// Content Tab End

        // Style Tab Start

		$this->start_controls_section(
			'about_listing_style',
			[
				'label' => esc_html__( 'Background', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background image', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/banner/home-conference-video-bg.svg' ),
				],
				'selectors' => [
					'{{WRAPPER}} .about-event' => '--bg-image: url({{URL}})',
				],
			]
		);
        $this->add_control(
			'bg_shape1',
			[
				'label' => esc_html__( 'Image Shape', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/dots/dots6.png' ),
				],
			]
		);
        $this->add_control(
			'bg_shape2',
			[
				'label' => esc_html__( 'Content Shape', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/dots/dots7.png' ),
				],
			]
		);

        $this->end_controls_section();

	}

	protected function render() {
        $settings = $this->get_settings_for_display();
		control_listings_template_part('elements/about-event', '', $settings);
	}
}