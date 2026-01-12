<?php
defined( 'ABSPATH' ) || exit;
namespace ControlListings\Widgets;

class Listing_Testimonials extends \Elementor\Widget_Base{
    public function get_name() {
		return 'event_testimonials';
	}

	public function get_title() {
		return esc_html__( 'Listing Testimonials', 'control-listings' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'control-listings' ];
	}

	public function get_keywords() {
		return [ 'testimonials', 'control', 'event' ];
	}

    protected function register_controls() {        

		// Content Tab Start
		
		$this->start_controls_section(
			'content_tab',
			[
				'label' => esc_html__( 'Section Testimonials', 'control-listings' ),
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
				'default' => esc_html__( "Join 3,500+ developers, engineers, \ndesigners and executives ", 'control-listings' ),
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

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA							
			]
		);
        $repeater->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Martha Smith',
				'label_block' => true
			]
		);
		$repeater->add_control(
			'designation',
			[
				'label' => esc_html__( 'Designation', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'San Francisco',
				'label_block' => true
			]
		);
		
		$repeater->add_control(
			'content',
			[
				'label' => esc_html__( 'Content', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => '“Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”',
				'label_block' => true
			]
		);

		$repeater->add_control(
			'ratings',
			[
				'label' => esc_html__( 'Ratings', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 5,
				'options' => [
					'' => 'none',
					'1' => '1 star',
					'2' => '2 star',
					'3' => '3 star',
					'4' => '4 star',
					'5' => '5 star'
				]
			]
		);
		$repeater->add_control(
			'ratings_desc',
			[
				'label' => esc_html__( 'Ratings info', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '5/5 Rating',
			]
		);

		

		

        $this->add_control(
			'testimonials',
			[
				'label' => esc_html__( 'Testimonials', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<strong>{{{ name }}}</strong> {{{designation}}}',
				'default' => [
					[
						'name' => 'Stella Smith',
						'designation' => 'Listingor Live Max',
						'ratings' => '5',
						'ratings_desc' => '5/5 Rating',
						'image' => ['url' => get_theme_file_uri( 'assets/images/review/img.png' )],
						'content' => '“Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”',
					],
					[
						'name' => 'Stella Smith',
						'designation' => 'Listingor Live Max',
						'ratings' => '5',
						'ratings_desc' => '5/5 Rating',
						'image' => ['url' => get_theme_file_uri( 'assets/images/review/img2.png' )],
						'content' => '“Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”',
					],
					[
						'name' => 'Stella Smith',
						'designation' => 'Listingor Live Max',
						'ratings' => '4',
						'ratings_desc' => '4/5 Rating',
						'image' => ['url' => get_theme_file_uri( 'assets/images/review/img3.png' )],
						'content' => '“Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”',
					],
					[
						'name' => 'Stella Smith',
						'designation' => 'Listingor Live Max',
						'ratings' => '5',
						'ratings_desc' => '5/5 Rating',
						'image' => ['url' => get_theme_file_uri( 'assets/images/review/img.png' )],
						'content' => '“Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”',
					],
					[
						'name' => 'Stella Smith',
						'designation' => 'Listingor Live Max',
						'ratings' => '5',
						'ratings_desc' => '5/5 Rating',
						'image' => ['url' => get_theme_file_uri( 'assets/images/review/img2.png' )],
						'content' => '“Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”',
					],
					[
						'name' => 'Stella Smith',
						'designation' => 'Listingor Live Max',
						'ratings' => '5',
						'ratings_desc' => '5/5 Rating',
						'image' => ['url' => get_theme_file_uri( 'assets/images/review/img3.png' )],
						'content' => '“Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”',
					],
					[
						'name' => 'Stella Smith',
						'designation' => 'Listingor Live Max',
						'ratings' => '5',
						'ratings_desc' => '5/5 Rating',
						'image' => ['url' => get_theme_file_uri( 'assets/images/review/img.png' )],
						'content' => '“Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”',
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
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/banner/review.png' ),
				],
				'selectors' => [
					'{{WRAPPER}} .listing-testimonials' => '--bg-image: url({{URL}})',
				],
			]
		);

		$this->add_control(
			'dots',
			[
				'label' => esc_html__( 'Dots', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/dots/dots8.png' ),
				],
			]
		);
		$this->add_control(
			'shadow',
			[
				'label' => esc_html__( 'Shadow', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/shape/3.svg' ),
				],
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
		control_listings_template_part('elements/listing-testimonials', '', $settings);
	}
}