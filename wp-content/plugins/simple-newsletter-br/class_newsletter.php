<?php 
class controllerNewsletter {

	private $queries = array(
		'ALL' => 'SELECT * FROM simplenewsletter_subscriptions WHERE 1 = 1 ORDER BY created DESC LIMIT %d, %d',
		'ALL_CONFIRMED' => 'SELECT * FROM simplenewsletter_subscriptions WHERE confirmed = 1 ORDER BY created DESC LIMIT %d, %d',
		'EXPORT_ALL' => 'SELECT name, email FROM simplenewsletter_subscriptions WHERE 1 = 1',
		'EXPORT_CONFIRMED' => 'SELECT name, email FROM simplenewsletter_subscriptions WHERE confirmed = 1',
		'CHECK_EMAIL' => 'SELECT email FROM simplenewsletter_subscriptions WHERE email = \'%s\'',
		'CONFIRM' => 'UPDATE simplenewsletter_subscriptions SET confirmed = 1 where hash = \'%s\'',
		'COUNT' => 'SELECT (SELECT COUNT(*) from simplenewsletter_subscriptions WHERE confirmed = 1 ) as qty_confirmed, (SELECT COUNT(*) from simplenewsletter_subscriptions WHERE confirmed = 0) as qty_unconfirmed, (SELECT COUNT(*) from simplenewsletter_subscriptions WHERE DATE(created) = DATE_SUB(CURDATE(),INTERVAL 1 DAY) ) as yesterday, (SELECT COUNT(*) from simplenewsletter_subscriptions WHERE DATE_SUB(CURDATE(),INTERVAL 0 DAY) <= DATE(created) ) as today, (SELECT COUNT(*) from simplenewsletter_subscriptions WHERE DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= DATE(created) ) as last_week'
		);
	private $data = array();
	public $success_message = '';
	private $need_confirmation = '';
	private $wpdb;

	public $errors = array();
	public $limit  = 25;

	public function controllerNewsletter()
	{
		//Load the translation 0.5.1 modification
		load_plugin_textdomain('simple-newsletter-br', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');

		global $wpdb;
		$this->wpdb = $wpdb;
		$this->success_message = get_option("simplenewsletter_successmessage");
		$this->need_confirmation = get_option("simplenewsletter_dbloptin");
	}

	public function get_subscribers($type = 'all', $page = 0)
	{
		switch ($type) {
			case 'all':
			return $this->wpdb->get_results($this->wpdb->prepare( $this->queries['ALL'], ( $page*$this->limit ), $this->limit ), ARRAY_A );
			break;
			
			case 'confirmed':
			return $this->wpdb->get_results($wpdb->prepare( $this->queries['ALL_CONFIRMED'], ( $page*$this->limit ), $this->limit ), ARRAY_A );
			break;
		}
	}

	public function count()
	{
		return $this->wpdb->get_results($this->queries['COUNT'], ARRAY_A);
	}

	public function insert($data = array())
	{
		$this->set_sanitized_data($data);

		if($this->validate() === false)
		{
			return false;
		}

		if($this->save())
		{
			$this->send_confirmation();
			return true;
		}

		return false;
	}

	public function confirm($token = null)
	{
		if( $this->wpdb->query( $this->wpdb->prepare( $this->queries['CONFIRM'], $token ) ) )
		{
			return true;
		}

		return false;
	}

	public function export($method = 'EXPORT_ALL')
	{
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=subscribers.csv');

		$output = fopen('php://output', 'w');

		fputcsv($output, array('Nome', 'Email'));
		$rows = $this->wpdb->get_results($this->queries[$method], ARRAY_N);

		foreach($rows as $key => $row)
		{
			fputcsv($output, $row);
		}

	}

	private function set_sanitized_data($data)
	{
		foreach($data as $key => $value)
		{
			switch($key)
			{
				default:
				$this->data[$key] = sanitize_text_field($value);
				break;

				case "email":
				$this->data[$key] = sanitize_email($value);
				break;

			}
		}
		return true;
	}

	private function send_confirmation()
	{
		$vars = array(
			'<a href="'. get_home_url() .'?sn_token='. $this->data['hash'] .'">'.__('Click here to confirm your email', 'simple-newsletter-br').'</a>',
			get_option("simplenewsletter_confirmationemail"),
			get_home_url(),
			get_bloginfo('name'),
			);

		$logo = get_option("simplenewsletter_logo");
		if(empty($logo))
		{
			plugins_url('images/newsletter.png', __FILE__);
		}

		$name = '';
		if(isset($this->data['name']))
		{
			$name = $this->data['name'];
		}
		
		array_unshift($vars, $logo, $name);
		
		$template_file = get_template_directory().'/email_template.html';
		
		if(!file_exists($template_file))
		{
			$template_file = plugin_dir_path(__FILE__).'views/email_template.html';
		}
		
		$file = fopen( $template_file, "r");
		$content = fread($file, filesize($template_file));

		$content = str_replace( array( '{logo}', '{name}', '{button}','{text_confirmation}','{sitelink}','{sitename}'), $vars, $content );
		$headers = array(
			'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
			'Content-Type: text/html; charset=UTF-8'
			);

		wp_mail( $this->data['email'], get_bloginfo('name') . ' - ' . __('Email Confirmation', 'simple-newsletter-br'), $content, $headers );
	}

	private function validate()
	{
		if($this->exist())
		{
			return false;
		}

		if(isset($this->data['name']) && empty($this->data['name']))
		{
			$this->errors['name'] = __('Blank name is not allowed', 'simple-newsletter-br');
		}

		if(!is_email($this->data["email"]) || empty($this->data["email"]))
		{
			$this->errors['email'] = __('Please inform a valid email', 'simple-newsletter-br');
		}

		if(!empty($this->errors))
		{
			return false;
		}

		return true;
	}

	private function exist()
	{
		if( count( $this->wpdb->get_results( $this->wpdb->prepare( $this->queries['CHECK_EMAIL'], $this->data["email"] ), ARRAY_A ) ) > 0 )
		{
			return true;
		}
		return false;
	}

	private function save()
	{
		$this->data['hash'] = md5($this->data['email'].date('d/m/Y H:i:s'));
		$this->data["created"] = date('Y-m-d H:m:i');
		$this->data["confirmed"] = 0;
		if( $this->wpdb->insert('simplenewsletter_subscriptions', $this->data, array('%s','%s','%s','%s', '%d')) ){
			return true;
		}
		return false;
	}
}
?>