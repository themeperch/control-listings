<?php
defined( 'ABSPATH' ) || exit;
namespace ControlListings\Widgets;

class Listing_FAQs extends \Elementor\Widget_Base{
    public function get_name() {
		return 'event_faqs';
	}

	public function get_title() {
		return esc_html__( 'Listing FAQs', 'control-listings' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'control-listings' ];
	}

	public function get_keywords() {
		return [ 'faqs', 'control', 'event' ];
	}

    protected function register_controls() {        

		// Content Tab Start
		
		$this->start_controls_section(
			'content_tab',
			[
				'label' => esc_html__( 'Section FAQs', 'control-listings' ),
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
				'default' => esc_html__( "Frequently asked questions, about the conference", 'control-listings' ),
			]
		);
        $this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Sub-title', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Listingor Collaborative, brought to you by IBM, is where the most inventive and forward-thinking nonprofit leaders come together to discover emerging trends in fundraising and technology.',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Learn More',
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Button link', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'deflink' => '#',
			]
		);
		

		$repeater = new \Elementor\Repeater();
		
        $repeater->add_control(
			'question',
			[
				'label' => esc_html__( 'Question', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
			]
		);
		$repeater->add_control(
			'answer',
			[
				'label' => esc_html__( 'Answer', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
			]
		);

		

        $this->add_control(
			'faqs',
			[
				'label' => esc_html__( 'FAQs', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ question }}}',
				'default' => [
					[
						'question' => 'Is this Listingor Conference 2023 for me?',
						'answer' => 'Are you a developer interested in building web applications and at the same time thinking about multiple parts of the stack needed to build them? Then this conference is for you. Many of the sessions either touch a specific concept or go about multiple parts of the stack. '
					],
					[
						'question' => 'Can I change the attendee name on the ticket?',
						'answer' => 'Are you a developer interested in building web applications and at the same time thinking about multiple parts of the stack needed to build them? Then this conference is for you. Many of the sessions either touch a specific concept or go about multiple parts of the stack. '
					],
					[
						'question' => 'Can I update the attendee information on the ticket?',
						'answer' => 'Are you a developer interested in building web applications and at the same time thinking about multiple parts of the stack needed to build them? Then this conference is for you. Many of the sessions either touch a specific concept or go about multiple parts of the stack. '
					],
					[
						'question' => 'What is included in the ticket prices?',
						'answer' => 'Are you a developer interested in building web applications and at the same time thinking about multiple parts of the stack needed to build them? Then this conference is for you. Many of the sessions either touch a specific concept or go about multiple parts of the stack. '
					]					
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
		control_listings_template_part('elements/listing-faqs', '', $settings);
	}
}