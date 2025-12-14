<?php
namespace ControlListings\Widgets;

class Slider extends \Elementor\Widget_Base{
	use Helper;

    public function get_name() {
		return 'slider';
	}

	public function get_title() {
		return esc_html__( 'Slider', 'control-listings' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'control-listings' ];
	}

	public function get_keywords() {
		return [ 'slider', 'event' ];
	}

    protected function register_controls() {


		// Content Tab Start

		$this->start_controls_section(
			'content_tab',
			[
				'label' => esc_html__( 'Slides', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'style',
			[
				'label' => esc_html__( 'Style', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'double_column',
				'options' => [
					'style1' => esc_html__( 'Content & Image group (Double column)', 'control-listings' ),
					'style2' => esc_html__( 'Single column', 'control-listings' ),
					'style3' => esc_html__( 'Content & Video (Double column)', 'control-listings' ),
				],
			]
		);

		$repeater->add_control(
			'align',
			[
				'label' => esc_html__( 'Align', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'control-listings' ),
					'center' => esc_html__( 'Text center', 'control-listings' ),
					'end' => is_rtl()? esc_html__( 'Left align', 'control-listings' ) :  esc_html__( 'Right align', 'control-listings' ),
				],
				'seperator' => 'after'
			]
		);

		

		$repeater->add_control(
			'name',
			[
				'label' => esc_html__( 'Big title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				/* translators: %s: Current year */
				'default' => sprintf(esc_html__( 'CONF %s', 'control-listings' ), date('Y')),
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Be inspired by expert speakers in design, video, and more', 'control-listings' ),
			]
		);
        $repeater->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Sub-title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Plan your week to make the most of all the sessions and labs, Community Listingor activities, and fun ways to connect with other creatives.', 'control-listings' ),
			]
		);
		
        $repeater->add_control(
			'action',
			[
				'label' => esc_html__( 'Action', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'buttons',
				'options' => [
					'' => 'none',
					'buttons' => esc_html__( 'Buttons', 'control-listings' ),
					'video' => esc_html__( 'Video', 'control-listings' ),
				],
			]
		);

		$btn_group = new \Elementor\Repeater();
		$this->button_controls($btn_group, ['prefix' => '']);
		$repeater->add_control(
			'buttons',
			[
				'label' => esc_html__( 'Buttons', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $btn_group->get_controls(),
				'title_field' => '{{{ text }}}',
				'condition' => [
					'action' => 'buttons',
				],
			]
		);

		$repeater->add_control(
			'video_url',
			[
				'label' => esc_html__( 'Video URL', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'https://www.youtube.com/embed/YOUTUBE_VIDEO_ID',
				'condition' => [
					'action' => 'video',
				],
				'label_block' => true
			]
		);

		$repeater->add_control(
			'media_type',
			[
				'label' => esc_html__( 'Media column type', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'image_group',
				'options' => [
					'' => 'none',
					'image_group' => esc_html__( 'Image group', 'control-listings' ),
					'video' => esc_html__( 'Video', 'control-listings' ),
				],
			]
		);

		$repeater->add_control(
			'media_image',
			[
				'label' => esc_html__( 'Choose Image', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'condition' => [
					'media_type!' => '',
				],				
			]
		);
        $repeater->add_control(
			'media_image2',
			[
				'label' => esc_html__( 'Choose Image2', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'condition' => [
					'media_type' => 'image_group',
				],
			]
		);
		$repeater->add_control(
			'media_video_url',
			[
				'label' => esc_html__( 'Video URL', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'https://www.youtube.com/embed/YOUTUBE_VIDEO_ID',
				'condition' => [
					'media_type' => 'video',
				],
				'label_block' => true
			]
		);

        $this->add_control(
			'slides',
			[
				'label' => esc_html__( 'Slides', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => $this->slides_default(),
				'title_field' => '{{{ title }}}',
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
			'about_listing_bg',
			[
				'label' => esc_html__( 'Background image', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/banner/home-conference-video-bg.svg' ),
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
		control_listings_template_part('elements/slider', '', $settings);
	}

	protected function buttons_default(){
		return [
			[
				'text' => 'Register',
				'url' => '#',
				'style' => 'custom-btn2',
				'extra_class' => '',
			],
			[
				'text' => 'Watch Video',
				'url' => 'https://www.youtube.com/embed/SZEflIVnhH8',
				'style' => 'custom-btn item-btn',
				'video' => 'yes',
				'data' => '',
				'extra_class' => ''						
			],
		];
	}

	protected function slides_default(){
		return [
			[
				'style' => 'style1',
				'name' => 'CONF 2023',
				'title' => "The leading nonprofit\nconference of the year",
				'subtitle' => 'Join us for Listingor Collaborative: Virtual Sessions on October 2023',
				'action' => 'buttons',
				'buttons' => $this->buttons_default(),
				'media_type' => 'image_group',
				'media_image' => ['url' => get_theme_file_uri( 'assets/images/banner-slider/2.jpg' )],
				'media_image2' => ['url' => get_theme_file_uri( 'assets/images/banner-slider/1.jpg' )],
				
				// Style
				'about_listing_bg' => [],
				'bg_shape1' => [],
				'bg_shape2' => [],
			],
			[
				'style' => 'style2',
				'align' => 'center',
				'name' => 'CONF 2023',
				'title' => "The leading nonprofit\nconference of the year",
				'subtitle' => '',    
				'action' => 'video',
				'video_url' => 'https://www.youtube.com/embed/SZEflIVnhH8',
				'media_type' => '',				
				// Style
				'about_listing_bg' => [],
				'bg_shape1' => [],
				'bg_shape2' => [],
			],
			[
				'style' => 'style3',
				'name' => 'CONF 2023',
				'title' => "The leading nonprofit\nconference of the year",
				'subtitle' => 'Join us for Listingor Collaborative: Virtual Sessions on October 2023',    
				'action' => 'buttons',
				'buttons' => $this->buttons_default(),
				'media_type' => 'video',
				'media_image' => ['url' => get_theme_file_uri( 'assets/images/banner-slider/3.jpg' )],
				'media_video_url' => 'https://www.youtube.com/embed/SZEflIVnhH8',				
				// Style
				'about_listing_bg' => [],
				'bg_shape1' => [],
				'bg_shape2' => [],
			]
		];
	}
}