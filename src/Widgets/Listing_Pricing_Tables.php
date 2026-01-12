<?php
namespace ControlListings\Widgets;
defined( 'ABSPATH' ) || exit;

class Listing_Pricing_Tables extends \Elementor\Widget_Base{
    public function get_name() {
		return 'event_pricing_tables';
	}

	public function get_title() {
		return esc_html__( 'Listing Pricing tables', 'control-listings' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'control-listings' ];
	}

	public function get_keywords() {
		return [ 'pricing', 'control', 'event' ];
	}

    protected function register_controls() {        

		// Content Tab Start
		
		$this->start_controls_section(
			'content_tab',
			[
				'label' => esc_html__( 'Section Pricing tables', 'control-listings' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
		$this->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => ' Choose The Best Ticket For You',
				'label_block' => true
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				/* translators: %s: Current year */				
				'default' => sprintf(esc_html__( "Listing price list %s. Buy your tickets now \nfor Listingor Conference", 'control-listings' ), 
				// phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date 
				date('Y')),
			]
		);
        $this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Sub-title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Listingor is a 7-day conference with an extra day of workshops. There\'s a mix of short 45 minute talks and longer keynotes, giving you insights in a wide range of topics.',
			]
		);

		$repeater = new \Elementor\Repeater();
		
        $repeater->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Out of Pocket Discount',
				'label_block' => true
			]
		);
		$repeater->add_control(
			'price',
			[
				'label' => esc_html__( 'Price', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '$190',
			]
		);
		$repeater->add_control(
			'duration',
			[
				'label' => esc_html__( 'Duration', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '/ regular price',
			]
		);
		
		$features = new \Elementor\Repeater();
		$features->add_control(
			'enable',
			[
				'label' => esc_html__( 'Availability', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);	
		$features->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
			]
		);		
		$features->add_control(
			'desc',
			[
				'label' => esc_html__( 'Description', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' => true
			]
		);

		$repeater->add_control(
			'features',
			[
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $features->get_controls(),
				'title_field' => '{{{ title }}}',
				'default' => [
					[
						'title' => 'Regular price: $190 until Sept 20',
						'enable' => 'yes'
					],
					[
						'title' => 'Last minute price: $490 until the end',
						'enable' => 'yes'
					]
				]
			]
		);
		$repeater->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Buy Tickets',
			]
		);
		$repeater->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Button link', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'deflink' => '#',
			]
		);
		$repeater->add_control(
			'duration',
			[
				'label' => esc_html__( 'Duration', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '/ regular price',
			]
		);
		$repeater->add_control(
			'footer_desc',
			[
				'label' => esc_html__( 'Footer description', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'When you don\'t need a VAT invoice',
			]
		);

		

		

        $this->add_control(
			'pricing_tables',
			[
				'label' => esc_html__( 'Pricing Tables', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<strong>{{{ name }}}</strong> {{{price}}}',
				'default' => [
					[
						'name' => 'Out of Pocket Discount',
						'price' => '$190',
						'duration' => '/ regular price',
						'features' => [
							[
								'title' => 'Regular price: $190 until Sept 20',
								'enable' => 'yes'
							],
							[
								'title' => 'Last minute price: $490 until the end',
								'enable' => 'yes'
							]
						],
						'footer_desc' => 'When you don\'t need a VAT invoice',
						'button_text' => 'Buy Tickets',
						'button_link' => '#',
					],
					[
						'name' => 'Professional Discount',
						'price' => '$290',
						'duration' => '/ regular price',
						'features' => [
							[
								'title' => 'Regular price: $190 until Sept 20',
								'enable' => 'yes'
							],
							[
								'title' => 'Last minute price: $490 until the end',
								'enable' => 'yes'
							]
						],
						'footer_desc' => 'When you don\'t need a VAT invoice',
						'button_text' => 'Buy Tickets',
						'button_link' => '#',
					],
					[
						'name' => 'Company Discount',
						'price' => '$390',
						'duration' => '/ regular price',
						'features' => [
							[
								'title' => 'Regular price: $190 until Sept 20',
								'enable' => 'yes'
							],
							[
								'title' => 'Last minute price: $490 until the end',
								'enable' => 'yes'
							]
						],
						'footer_desc' => 'When you don\'t need a VAT invoice',
						'button_text' => 'Buy Tickets',
						'button_link' => '#',
					]
					
				]
				
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
					'{{WRAPPER}} .listing-pricing-tables' => '--bg-image: url({{URL}})',
				],
			]
		);

		$this->add_control(
			'dots',
			[
				'label' => esc_html__( 'Dots', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/dots/dots12.png' ),
				],
			]
		);
		$this->add_control(
			'shadow',
			[
				'label' => esc_html__( 'Shadow', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_theme_file_uri( 'assets/images/shape/5.svg' ),
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
		control_listings_template_part('elements/listing-pricing-tables', '', $settings);
	}
}