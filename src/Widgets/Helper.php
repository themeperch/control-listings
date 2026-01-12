<?php
namespace ControlListings\Widgets;
defined( 'ABSPATH' ) || exit;

trait Helper{

	protected function wp_query($instance = null, $args = []) {
		if ( empty( $instance ) ) {
			$instance = $this;
		}

		$args = wp_parse_args($args, [
			'prefix' => '',
			'label' => esc_html__( 'WP Query', 'control-listings' ),
			'posts_per_page' => 3,
			'post_type' => 'post',			
			'data' => '',
			'extra_class' => '',
		]);

		$instance->start_controls_section(
			$args['prefix'].'wp_query_tab',
			[
				'label' => $args['label'],
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$instance->add_control(
			$args['prefix'].'post_type',
			[
				'label' => esc_html__( 'Post type', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => [
					'post' => 'Post'
				],
				'default' => $args['post_type']
			]
		);

		$instance->add_control(
			$args['prefix'].'posts_per_page',
			[
				'label' => esc_html__( 'Posts per page', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => '-1',
				'step' => '1',
				'max' => '50',
				'default' => $args['posts_per_page']
			]
		);

		$instance->end_controls_section();
	}
    

    protected function button_controls($instance = null, $args = []) {
		if ( empty( $instance ) ) {
			$instance = $this;
		}
		$args = wp_parse_args($args, [
			'prefix' => 'button_',
			'text' => esc_html__( 'Resister Now', 'control-listings' ),
			'url' => '#',
			'style' => '',			
			'data' => '',
			'extra_class' => '',
		]);

		$instance->add_control(
			$args['prefix'].'text',
			[
				'label' => esc_html__( 'Button text', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => $args['text'],
				'label_block' => true
			]
		);
        $instance->add_control(
			$args['prefix'].'url',
			[
				'label' => esc_html__( 'Button URL', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => $args['url'],
				'placeholder' => 'https://',
				'label_block' => true
			]
		);
		$instance->add_control(
			$args['prefix'].'video',
			[
				'label' => esc_html__( 'Enable video popup', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
			]
		);
		$instance->add_control(
			$args['prefix'].'style',
			[
				'label' => esc_html__( 'Style', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'btn-link',
				'options' => $this->button_style_class_options(),
			]
		);

		$instance->add_control(
			$args['prefix'].'extra_class',
			[
				'label' => esc_html__( 'CSS Classes', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => $args['extra_class'],
				'label_block' => true
			]
		);
		$instance->add_control(
			$args['prefix'].'data',
			[
				'label' => esc_html__( 'Data Attributes', 'control-listings' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true
			]
		);

	}


	protected function render_button($args=[]) {
		control_listings_template_part('elements/button', '', $args);
	}

	protected function button_style_class_options(){

		$options = [
			 'btn-link' => esc_html__( 'Link', 'control-listings' ),
			 'btn-primary' => esc_html__( 'Primary', 'control-listings' ),
			 'btn-outline-primary' => esc_html__( 'Primary Outline', 'control-listings' ),
			 'btn-secondary' => esc_html__( 'Secondary', 'control-listings' ),
			 'btn-outline-secondary' => esc_html__( 'Secondary outline', 'control-listings' ),
			 'btn-info' => esc_html__( 'Info', 'control-listings' ),
			 'btn-success' => esc_html__( 'Success', 'control-listings' ),
			 'btn-warning' => esc_html__( 'Warning', 'control-listings' ),
			 'btn-danger' => esc_html__( 'Danger', 'control-listings' ),
			 'custom-btn2' => esc_html__( 'Theme style', 'control-listings' ),
			 'custom-btn item-btn' => esc_html__( 'Theme style 2', 'control-listings' ),
		];
		return apply_filters( 'control_listings_button_style_class_options', $options );
	 }
}