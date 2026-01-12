<?php
defined( 'ABSPATH' ) || exit;
namespace ControlListings\Widgets;

class Listing_Contact extends \Elementor\Widget_Base{
    public function get_name() {
		return 'event_contact';
	}

	public function get_title() {
		return esc_html__( 'Listing Contact', 'control-listings' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'control-listings' ];
	}

	public function get_keywords() {
		return [ 'contact', 'control', 'event' ];
	}

    protected function register_controls() {        

		// Content Tab Start
		
		$this->start_controls_section(
			'content_tab',
			[
				'label' => esc_html__( 'Section Contact', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
		$this->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Contact The Listingor Sales Team ',
				'label_block' => true
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( "We are here when you need us. \nNeed immediate assistance?", 'control-listings' ),
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
			'contact_form',
			[
				'label' => esc_html__( 'Contact form shortcode', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$this->add_control(
			'contact_info_title',
			[
				'label' => esc_html__( 'Contact Info title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Contact Us',
				'label_block' => true
			]
		);
		$this->add_control(
			'contact_info_subtitle',
			[
				'label' => esc_html__( 'Contact Info Sub-title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Get in touch and let us know how we can help.',
			]
		);
		

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'type',
			[
				'label' => esc_html__( 'Type', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SELECT,	
				'default' => 'image',
				'options' => [
					'email' => 'Email',
					'address' => 'Address',
					'phone' => 'Phone',
				],			
			]
		);
        $repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
			]
		);
		$repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,				
			]
		);
		

		$repeater->add_control(
			'address',
			[
				'label' => esc_html__( 'Address URL', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,	
				'label_block' => true,
				'condition' => [
					'type' => 'address',
				],			
			]
		);


		

        $this->add_control(
			'contact_info',
			[
				'label' => esc_html__( 'Contact information', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ type }}} {{{ title }}}',
				'default' => [
					[
						'type' => 'email',
						'title' => 'conference@eventor.com',
						'icon' => ['url' => get_theme_file_uri( 'assets/images/icon/mail1.svg' )],
						'address' => ''
					],
					[
						'type' => 'address',
						'title' => '1000 S Eighth Ave, NYC.',
						'icon' => ['url' => get_theme_file_uri( 'assets/images/icon/map-pin2.svg' )],
						'address' => '#'
					],
					[
						'type' => 'phone',
						'title' => '+1 (646) 652-0000',
						'icon' => ['url' => get_theme_file_uri( 'assets/images/icon/phone3.svg' )],
						'address' => ''
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
					'{{WRAPPER}} .listing-contact' => '--bg-image: url({{URL}})',
				],
			]
		);

		$this->add_control(
			'contact_info_bg',
			[
				'label' => esc_html__( 'Contact info background', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,	
				'default' => ['url' => get_theme_file_uri( 'assets/images/banner/contact-bg.png' )],			
				'selectors' => [
					'{{WRAPPER}} .contact-thumb-wrap' => 'background-image: url({{URL}})',
				],
			]
		);

		$this->add_control(
			'dots',
			[
				'label' => esc_html__( 'Dots', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => ['url' => get_theme_file_uri( 'assets/images/dots/dots13.png' )],
				
			]
		);
		$this->add_control(
			'dots2',
			[
				'label' => esc_html__( 'Dots 2', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => ['url' => get_theme_file_uri( 'assets/images/dots/dots14.png' )],
				
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
		control_listings_template_part('elements/listing-contact', '', $settings);
	}
}