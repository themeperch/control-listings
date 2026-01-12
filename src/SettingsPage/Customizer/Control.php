<?php
namespace ControlListings\SettingsPage\Customizer;
defined( 'ABSPATH' ) || exit;

class Control extends \WP_Customize_Control {
	public $type = 'meta_box';
	public $meta_box;

	public function render_content() {
		$this->meta_box->show();
		?>
		<input type="hidden" <?php $this->link(); ?>>
		<?php
	}

	public function enqueue() {
		$this->meta_box->enqueue();

		wp_enqueue_style( 'mbsp-customizer', CTRL_LISTINGS_ASSETS . '/settings/customizer.css', [], '2.1.5' );

		wp_register_script( 'mb-jquery-serialize-object', CTRL_LISTINGS_ASSETS . '/settings/jquery.serialize-object.js', ['jquery'], '2.5.0', true );
		wp_enqueue_script( 'mbsp-customizer', CTRL_LISTINGS_ASSETS . '/settings/customizer.js', ['customize-controls', 'mb-jquery-serialize-object', 'rwmb', 'underscore'], '2.1.5', true );
	}
}