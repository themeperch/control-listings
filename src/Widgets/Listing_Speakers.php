<?php
namespace ControlListings\Widgets;

class Listing_Speakers extends \Elementor\Widget_Base{
    public function get_name() {
		return 'event_speakers';
	}

	public function get_title() {
		return esc_html__( 'Listing Speakers', 'control-listings' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'control-listings' ];
	}

	public function get_keywords() {
		return [ 'videos', 'control', 'event' ];
	}

    protected function register_controls() {        

		// Content Tab Start
		
		$this->start_controls_section(
			'content_tab',
			[
				'label' => esc_html__( 'Section Speakers', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
		$this->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( ' Meet Our Experts, and Speakers ', 'control-listings' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( "Meet our fantastic speakers from around the \nglobe and join in with live debates & events ", 'control-listings' ),
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
				'default' => 'Jhon doe',
				'label_block' => true
			]
		);
		$repeater->add_control(
			'designation',
			[
				'label' => esc_html__( 'Designation', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'WP Developer, Themeperch',
				'label_block' => true
			]
		);


		$social_links = new \Elementor\Repeater();
		$social_links->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$social_links->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::ICONS,						
			]
		);
		$social_links->add_control(
			'url',
			[
				'label' => esc_html__( 'URL', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$repeater->add_control(
			'social_links',
			[
				'label' => esc_html__( 'Social link', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $social_links->get_controls(),
				'title_field' => '{{{ title }}}',
				'default' => [
					[
						'title' => 'Facebook',
						'icon' => ['value' => 'fab fa-facebook-f', 'library' => 'fa-brands'],
						'url' => '#',
					],
					[
						'title' => 'Linkedin',
						'icon' => ['value' => 'fab fa-linkedin-in', 'library' => 'fa-brands'],
						'url' => '#',
					],
					[
						'title' => 'Twitter',
						'icon' => ['value' => 'fab fa-twitter', 'library' => 'fa-brands'],
						'url' => '#',
					]						
				]
			]
		);
		

        $this->add_control(
			'speakers',
			[
				'label' => esc_html__( 'Speakers', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<strong>{{{ name }}}</strong> {{{designation}}}',
				'default' => [
					[
						'name' => 'Stella Smith',
						'designation' => 'Listingor Live Max',
						'image' => ['url' => get_theme_file_uri( 'assets/images/gallery/gallery1.jpg' )],
						'social_links' => [
							[
								'title' => 'Facebook',
								'icon' => ['value' => 'fab fa-facebook-f', 'library' => 'fa-brands'],
								'url' => '#',
							],
							[
								'title' => 'Linkedin',
								'icon' => ['value' => 'fab fa-linkedin-in', 'library' => 'fa-brands'],
								'url' => '#',
							],
							[
								'title' => 'Twitter',
								'icon' => ['value' => 'fab fa-twitter', 'library' => 'fa-brands'],
								'url' => '#',
							]						
						]
					],
					[
						'name' => 'Stella Smith',
						'designation' => 'Listingor Live Max',
						'image' => ['url' => get_theme_file_uri( 'assets/images/gallery/gallery2.jpg' )],
						'social_links' => [
							[
								'title' => 'Facebook',
								'icon' => ['value' => 'fab fa-facebook-f', 'library' => 'fa-brands'],
								'url' => '#',
							],
							[
								'title' => 'Linkedin',
								'icon' => ['value' => 'fab fa-linkedin-in', 'library' => 'fa-brands'],
								'url' => '#',
							],
							[
								'title' => 'Twitter',
								'icon' => ['value' => 'fab fa-twitter', 'library' => 'fa-brands'],
								'url' => '#',
							]						
						]
					],
					[
						'name' => 'Stella Smith',
						'designation' => 'Listingor Live Max',
						'image' => ['url' => get_theme_file_uri( 'assets/images/gallery/gallery3.jpg' )],
						'social_links' => [
							[
								'title' => 'Facebook',
								'icon' => ['value' => 'fab fa-facebook-f', 'library' => 'fa-brands'],
								'url' => '#',
							],
							[
								'title' => 'Linkedin',
								'icon' => ['value' => 'fab fa-linkedin-in', 'library' => 'fa-brands'],
								'url' => '#',
							],
							[
								'title' => 'Twitter',
								'icon' => ['value' => 'fab fa-twitter', 'library' => 'fa-brands'],
								'url' => '#',
							]						
						]
					],
					[
						'name' => 'Stella Smith',
						'designation' => 'Listingor Live Max',
						'image' => ['url' => get_theme_file_uri( 'assets/images/gallery/gallery4.jpg' )],
						'social_links' => [
							[
								'title' => 'Facebook',
								'icon' => ['value' => 'fab fa-facebook-f', 'library' => 'fa-brands'],
								'url' => '#',
							],
							[
								'title' => 'Linkedin',
								'icon' => ['value' => 'fab fa-linkedin-in', 'library' => 'fa-brands'],
								'url' => '#',
							],
							[
								'title' => 'Twitter',
								'icon' => ['value' => 'fab fa-twitter', 'library' => 'fa-brands'],
								'url' => '#',
							]							
						]
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
		control_listings_template_part('elements/listing-speakers', '', $settings);
	}
}