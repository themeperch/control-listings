<?php
namespace ControlListings\Widgets;
defined( 'ABSPATH' ) || exit;

class Listing_Gallery extends \Elementor\Widget_Base{
    public function get_name() {
		return 'event_gallery';
	}

	public function get_title() {
		return esc_html__( 'Listing Gallery', 'control-listings' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'control-listings' ];
	}

	public function get_keywords() {
		return [ 'gallery', 'control', 'event' ];
	}

    protected function register_controls() {        

		// Content Tab Start
		
		$this->start_controls_section(
			'content_tab',
			[
				'label' => esc_html__( 'Section Gallery', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
		$this->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Visit Our Latest Listings Gallery',
				'label_block' => true
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( "Relive the best moments from the Conference 2022 through video and photos in our gallery", 'control-listings' ),
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
			'hover_text',
			[
				'label' => esc_html__( 'Hover text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'view',
			]
		);
		

		$repeater = new \Elementor\Repeater();
		
        $repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,				
			]
		);
		$repeater->add_control(
			'popup',
			[
				'label' => esc_html__( 'Popup', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SELECT,	
				'default' => 'image',
				'options' => [
					'image' => 'Image',
					'video' => 'Video',
				],			
			]
		);
		$repeater->add_control(
			'full_image',
			[
				'label' => esc_html__( 'Full Image', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,	
				'condition' => [
					'popup' => 'image',
				],			
			]
		);
		$repeater->add_control(
			'video',
			[
				'label' => esc_html__( 'Video URL', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,	
				'label_block' => true,
				'condition' => [
					'popup' => 'video',
				],			
			]
		);


		

        $this->add_control(
			'gallery',
			[
				'label' => esc_html__( 'Gallery', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default' => [
					[
						'title' => 'Image 1',
						'image' => ['url' => get_theme_file_uri( 'assets/images/gallery/img-gallery1.png' )],
						'popup' => 'image'
					],
					[
						'title' => 'Image 1',
						'image' => ['url' => get_theme_file_uri( 'assets/images/gallery/img-gallery2.png' )],
						'popup' => 'image',
						'full_image' => ['url' => get_theme_file_uri( 'assets/images/gallery/img-gallery1.png' )],
					],
					[
						'title' => 'Image 1',
						'image' => ['url' => get_theme_file_uri( 'assets/images/gallery/img-gallery3.png' )],
						'popup' => 'video',
						'video' => 'https://www.youtube.com/embed/SZEflIVnhH8',
					],									
				],
				
			]
		);
        

		$this->end_controls_section();

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
					'{{WRAPPER}} .listing-gallery' => '--bg-image: url({{URL}})',
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
		control_listings_template_part('elements/listing-gallery', '', $settings);
	}
}