<?php
defined( 'ABSPATH' ) || exit;
namespace ControlListings\Widgets;

class Listing_Videos extends \Elementor\Widget_Base{
    public function get_name() {
		return 'event_videos';
	}

	public function get_title() {
		return esc_html__( 'Listing Videos', 'control-listings' );
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
				'label' => esc_html__( 'Section Videos', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
		$this->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				/* translators: %s: Current year */
				'default' => sprintf(esc_html__( 'Welcome to Listingor Conference %s', 'control-listings' ), 
				// phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
				date('Y')),
				'label_block' => true
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( "The conference on the design, and engineering \nis focused on programming topics", 'control-listings' ),
			]
		);
        $this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Sub-title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Listingor Collaborative, brought to you by IBM, Google and AWS, is where the most inventive and forward-thinking nonprofit leaders come together to discover emerging trends in fundraising and technology.', 'control-listings' ),
			]
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'date',
			[
				'label' => esc_html__( 'Date', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				// phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
				'default' => 'October 3, '.date('Y'),
				'picker_options' => [
					'altFormat' => 'F j, Y',
					'ariaDateFormat' => 'F j, Y',
					'enableTime' => false,
					'allowInput' => true
				]
			]
		);
        $repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Opening',
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA							
			]
		);
		$repeater->add_control(
			'video_url',
			[
				'label' => esc_html__( 'Video URL', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'https://www.youtube.com/embed/SZEflIVnhH8',
				'label_block' => true
			]
		);

		$repeater->add_control(
			'size',
			[
				'label' => esc_html__( 'Size', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'col-lg-6',
				'options' => [
					'col-lg-12' => 'Full width (12 col)',
					'col-lg-6' => 'Half width (6 col)',
					'col-sm-6 col-lg-4' => '1/3 width (4 col)',
					'col-sm-6 col-lg-3' => '1/4 width (3 col)',
				],
			]
		);
        

        $this->add_control(
			'videos',
			[
				'label' => esc_html__( 'Videos', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						// phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
						'date' => sprintf('October 3, %s', date('Y')),
						'title' => esc_html__( 'Virtual sessions. Listingor Live@MAX', 'control-listings' ),
						'video_url' => 'https://www.youtube.com/embed/SZEflIVnhH8',
						'image' => ['url' => get_theme_file_uri( 'assets/images/about/about1.png' )],
						'size' => 'col-lg-6'
					],
					[
						// phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
						'date' => sprintf('October 4, %s', date('Y')),
						'title' => esc_html__( 'Opening', 'control-listings' ),
						'video_url' => 'https://www.youtube.com/embed/SZEflIVnhH8',
						'image' => ['url' => get_theme_file_uri( 'assets/images/about/about2.png' )],
						'size' => 'col-sm-6 col-lg-3'
					],
					[
						// phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
						'date' => sprintf('October 12, %s', date('Y')),
						'title' => esc_html__( 'Inspiration Art', 'control-listings' ),
						'video_url' => 'https://www.youtube.com/embed/SZEflIVnhH8',
						'image' => ['url' => get_theme_file_uri( 'assets/images/about/about3.png' )],
						'size' => 'col-sm-6 col-lg-3'
					],
				],
				'title_field' => '{{{ date }}} <strong>{{{ title }}}</strong>',
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
					'url' => get_theme_file_uri( 'assets/images/dots/dots4.png' ),
				],
			]
		);
		$this->add_control(
			'shadow',
			[
				'label' => esc_html__( 'Shadow', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/shape/1.svg' ),
				],
			]
		);
		$this->add_control(
			'separator',
			[
				'label' => esc_html__( 'Separator', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		

		$this->end_controls_section();


	}

	protected function render() {
        $settings = $this->get_settings_for_display();
		control_listings_template_part('elements/listing-videos', '', $settings);
	}
}