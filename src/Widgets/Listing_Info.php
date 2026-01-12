<?php
defined( 'ABSPATH' ) || exit;
namespace ControlListings\Widgets;

class Listing_Info extends \Elementor\Widget_Base{
    public function get_name() {
		return 'event_info';
	}

	public function get_title() {
		return esc_html__( 'Listing Info', 'control-listings' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'control-listings' ];
	}

	public function get_keywords() {
		return [ 'countdown', 'contact', 'event' ];
	}

    protected function register_controls() {        

		// Content Tab Start
		
		$this->start_controls_section(
			'content_tab',
			[
				'label' => esc_html__( 'Countdown & Contact', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        

		$this->add_control(
			'countdown',
			[
				'label' => esc_html__( 'Count down', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
				'description' => 'Format: YYYY/MM/DD hh:mm',
				'default' => '2024/10/24',
				'picker_options' => [
					'altFormat' => 'YYYY/m/d H:i',
					'ariaDateFormat' => 'YYYY/m/d H:i',
					'enableTime' => true,
					'allowInput' => true
				]
			]
		);
        $this->add_control(
			'days',
			[
				'label' => esc_html__( 'Days text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Days', 'control-listings' ),
			]
		);
		$this->add_control(
			'hours',
			[
				'label' => esc_html__( 'Hours text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Hours', 'control-listings' ),
			]
		);
		$this->add_control(
			'minutes',
			[
				'label' => esc_html__( 'Minutes text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Minutes', 'control-listings' ),
			]
		);
		$this->add_control(
			'seconds',
			[
				'label' => esc_html__( 'Seconds text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Seconds', 'control-listings' ),
				'separator' => 'after'
			]
		);

		$this->add_control(
			'email',
			[
				'label' => esc_html__( 'Email', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'conference@eventor.com',
				'label_block' => true
			]
		);

		$this->add_control(
			'phone',
			[
				'label' => esc_html__( 'Phone', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '+1 (646) 652-0000/1000',
				'label_block' => true
			]
		);

		$this->add_control(
			'address',
			[
				'label' => esc_html__( 'Address', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '1000 S Eighth Ave, NYC.', 'control-listings' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'address_url',
			[
				'label' => esc_html__( 'Address URL', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '#',
				'label_block' => true
			]
		);

		
        

		$this->end_controls_section();

		// Content Tab End

		$this->start_controls_section(
			'content_contact',
			[
				'label' => esc_html__( 'Design', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'countdown_bg_image',
			[
				'label' => esc_html__( 'Countdown background image', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/banner/bg.png' ),
				],
				'selectors' => [
					'{{WRAPPER}} .listing-countdown' => 'background-image: url({{URL}})',
				],
			]
		);


		$this->add_control(
			'icon_email',
			[
				'label' => esc_html__( 'Email icon', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/icon/mail.svg' ),
				],
			]
		);
		

		$this->add_control(
			'icon_address',
			[
				'label' => esc_html__( 'Address icon', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/icon/map-pin.svg' ),
				],
			]
		);
		

		$this->add_control(
			'icon_phone',
			[
				'label' => esc_html__( 'Phone icon', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/icon/phone.svg' ),
				],
			]
		);

		
		$this->add_control(
			'icon_phone',
			[
				'label' => esc_html__( 'Phone icon', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/icon/phone.svg' ),
				],
			]
		);

		$this->add_control(
			'dots',
			[
				'label' => esc_html__( 'Dots', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/dots/dots3.png' ),
				],
			]
		);
		

		$this->end_controls_section();

	}

	protected function render() {
        $settings = $this->get_settings_for_display();
		control_listings_template_part('elements/listing-info', '', $settings);
	}
}