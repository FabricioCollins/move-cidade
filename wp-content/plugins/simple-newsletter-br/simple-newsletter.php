<?php 
/**
 * @package Simple Newsletter
 */
/*
Plugin Name: Simple Newsletter
Description: Plugin de Newsletter com Double Opt-in
Version: 0.5.1
Author: Robson Miranda
Text Domain: simple-newsletter-br
Domain Path: /languages
*/

require('class_newsletter.php');

if(!class_exists('simpleNewsletter')) {

	class simpleNewsletter {

		public function __construct()
		{
			add_action( 'admin_menu', array(&$this,'settings'));
			add_action( 'wp_enqueue_scripts', array(&$this,'scripts' ));
			add_action( 'admin_enqueue_scripts', array(&$this,'admin_scripts' ) );
			add_action( 'init', array(&$this, 'load_sn_tranlate'));

			if(isset($_POST['simplenewsletter']))
			{
				add_action('after_setup_theme', array(&$this, 'generateForm'));
			}

			if(isset($_GET['sn_export_method']) && is_admin())
			{
				add_action('after_setup_theme', array(&$this, 'export'));
			}

			add_shortcode('simplenewsletter', array(&$this,'generateForm'));
		}

		public function load_sn_tranlate()
		{
			load_plugin_textdomain('simple-newsletter-br', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
		}

		/** This method render a submenu on configuration */
		public function settings()
		{
			add_options_page( '', 'Simple Newsletter', 'manage_options', 'simplenewsletter-admin', array( &$this, 'admin_updateSettings' ) );
			add_menu_page('Newsletter', 'Simple Newsletter', 'administrator', 'simplenewsletter-grid', array(&$this,'admin_gridSubscribers'), 'dashicons-groups');
		}

		/** Enqueue Scripts on site */

		public function scripts()
		{
			wp_enqueue_script( 'simplenewsletter', plugins_url('js/main.js', __FILE__), array('jquery'));
		}

		public function admin_scripts()
		{
			if( !isset($_GET['page']) || $_GET['page'] != 'simplenewsletter-grid' ){
				return ;
			}
			
			wp_enqueue_script( 'simplenewsletter-admin', plugins_url('js/admin_main.js', __FILE__), array('jquery'));
		}

		/** Generate the donation form */
		public function generateForm( $attr )
		{
			$newsletter = new controllerNewsletter();

			if(isset($_GET['sn_token']))
			{
				if($newsletter->confirm($_GET['sn_token']))
				{
					?>
					<div class="simplenewsletter-confirm-success">
						<p><?php echo get_option('simplenewsletter_confirmedmessage'); ?></p>
					</div>
					<?php
				}	
			}

			$errors = array();

			$attr = shortcode_atts(
				array(
					'values' => 'Nenhum Valor',
					), $attr, 'simplenewsletter'
				);

			if(isset($_POST['simplenewsletter']) )
			{
				$newsletter->insert($_POST['simplenewsletter']);
				$errors = $newsletter->errors;
				$this->ajaxResponse($errors, $newsletter->success_message);
			}

			if( isset( $errors ) || empty( $_POST['simplenewsletter'] ) )
			{
				foreach( $errors as $field => $error )
				{
					echo "<span class='error'>$error</p>";
				}
				$this->render_form( $attr );
			}
		}

		public function render_form($attr)
		{
			include ('views/user_form.php');
		}

		/** Set the token and API to generate the bill bank */
		public function admin_updateSettings()
		{
			if(!empty($_POST))
			{
				foreach($_POST as $name=>$value)
				{
					$value = sanitize_text_field($value);
					update_option($name, $value);
				}

				add_settings_error(
					'newsletterSaveSettings',
					esc_attr( 'settings_updated' ),
					'Configurações Atualizadas',
					'updated'
					);
			}

			include('views/admin_form.php');
		}

		public function admin_gridSubscribers()
		{
			include ('views/admin_grid.php');
		}

		public function export()
		{
			$newsletter = new controllerNewsletter();
			$newsletter->export($_GET['sn_export_method']);
			exit;
		}

		
		/** * Activate the plugin */
		public static function activate() {
			global $wpdb;
			//Cria as opções administrativas
			add_option("simplenewsletter_dbloptin", "1", null, "no");
			add_option("simplenewsletter_showname", "1", null, "no");
			add_option("simplenewsletter_successmessage", "Obrigado por se cadastrar", null, "no");
			add_option("simplenewsletter_confirmedmessage", "Obrigado por confirmar seu email", null, "no");
			add_option("simplenewsletter_confirmationemail", "Obrigado por se cadastrar, clique no link abaixo para confirmar o seu email", null, "no");
			add_option("simplenewsletter_logo", "", null, "no");
			add_option("simplenewsletter_showon", "append", null, "no");
			//Executa a query de criação da tabela de armazenamento
			$file = fopen( plugin_dir_path(__FILE__).'table.sql', "r");
			$query = fread($file, filesize(plugin_dir_path(__FILE__).'table.sql'));
			fclose($file);
			$wpdb->query($query);
		}

		/** * Deactivate the plugin */ 
		public static function deactivate() {
			delete_option("simplenewsletter_dbloptin");
			delete_option("simplenewsletter_logo");
			delete_option("simplenewsletter_confirmationemail");
			delete_option("simplenewsletter_showname");
			delete_option("simplenewsletter_successmessage");
			delete_option("simplenewsletter_confirmedmessage");
			delete_option("simplenewsletter_showon");
		}

		public function ajaxResponse($errors, $success_message)
		{
			//check if is ajax
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				if(!empty($errors))
				{
					echo json_encode( array( 'success' => '0', 'message' => $errors ) );
				}else{
					echo json_encode( array( 'success' => '1', 'message' => $success_message ) );
				}
				exit;

				return true;
			}
			
			return true;
		}

	}
}

if(class_exists("simpleNewsletter")){
	register_activation_hook(__FILE__, array('simpleNewsletter', 'activate'));
	register_deactivation_hook(__FILE__, array('simpleNewsletter', 'deactivate'));
	$simpleNewsletter = new simpleNewsletter;
	add_action( 'widgets_init', 'simplenewsletter_register_widgets' );
}

class widgetSimpleNewsletter extends WP_Widget {

	function __construct() {
		// Instantiate the parent object
		parent::__construct( false, 'Simple Newsletter', array('description' => __('Add the subscription form on widget area', 'simple-newsletter-br')) );
	}

	function widget( $args, $instance ) {
		?>
		<aside id="simplenewsletter-widget" class="widget">
			<h2 class="widget-title"><?php echo $instance['title'] ?></h2>
			<p><?php echo ( isset($instance['boxtext']) && !empty($instance['boxtext']) ) ? $instance['boxtext'] : ''; ?></p>
			<?php do_shortcode('[simplenewsletter]'); ?>
		</aside>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['boxtext'] = ( ! empty( $new_instance['boxtext'] ) ) ? strip_tags( $new_instance['boxtext'] ) : '';
		return $instance;
	}

	function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'simple-newsletter-br' );
		$boxtext = ! empty( $instance['boxtext'] ) ? $instance['boxtext'] : __( 'Box Text', 'simple-newsletter-br' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			<label for="<?php echo $this->get_field_id( 'boxtext' ); ?>"><?php _e( 'Box Text:', 'simple-newsletter-br' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'boxtext' ); ?>" name="<?php echo $this->get_field_name( 'boxtext' ); ?>" type="text" value="<?php echo esc_attr( $boxtext ); ?>">
		</p>
		<?php 
	}
}

function simplenewsletter_register_widgets() {
	register_widget( 'widgetSimpleNewsletter' );
}