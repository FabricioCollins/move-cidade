<?php
include_once ('utils.php');

class safe_mysqli extends mysqli
{
	public function prepare($query)
	{
		return new safe_mysqli_stmt($this, $query);
	}
}


class safe_mysqli_stmt extends mysqli_stmt
{
	public function __construct($link, $query)
	{
		parent::__construct($link, $query);
	}

	public function execute($error_message = null)
	{
		if (!parent::execute())
		{
			if ($error_message != null)
			{
				ERROR_EXIT($error_message);
			}
			else
			{
				ERROR_EXIT("Could not execute statement query " . $this->error);
			}
		}

		if (!parent::store_result())
		{
			if ($error_message != null)
			{
				ERROR_EXIT($error_message);
			}
			else
			{
				ERROR_EXIT("Could not store query's result " . $this->error);
			}
		}

		return $this->get_result();
	}

	public function get_result()
	{
		$RESULT = array();

		for ($i = 0; $i < $this->num_rows; $i++)
		{
			$Metadata = $this->result_metadata();
			$PARAMS = array();
			while ($Field = $Metadata->fetch_field())
			{
				$PARAMS[] = &$RESULT[$i][$Field->name];
			}
			call_user_func_array(array(
				get_parent_class($this),
				'bind_result'
			), $PARAMS);
			$this->fetch();
		}
		return $RESULT;
	}

	public function bind_param($types, $params)
	{
		array_unshift($params, $types);
		if (!call_user_func_array(array(
			get_parent_class($this),
			'bind_param'
		), $params))
		{
			ERROR_EXIT("Could not bind parameters: " . $params . " - " . $types . " - " . $this->error);
		}
	}

}


class database_access
{
	private $servername = "idec-rds.ce3sh7nhzali.us-west-2.rds.amazonaws.com";
	private $username = "root";
	private $password = "rootroot";
	private $dbname = "movecidade_app";

	private $conn;

	public function open()
	{
		// Create connection
		$this->conn = new safe_mysqli($this->servername, $this->username, $this->password, $this->dbname);

		// Check connection
		if ($this->conn->connect_error)
		{
			ERROR_EXIT("Connection to database failed: " . $this->conn->connect_error);
		}

		/* change character set to utf8 */
		if (!$this->conn->set_charset("utf8"))
		{
			ERROR_EXIT("Error loading character set utf8: %s " . $this->conn->error);
		}
	}

	public function get_database_dump($complete = false)
	{
		$table_names = array(
			"evaluation",
			"answer",
			"question",
			"modal",
			"modal_question",
			"choice"
		);

		if ($complete)
		{
			array_push($table_names, "profile");
		}

		foreach ($table_names as $table_name)
		{
			$result = $this->single_query("SELECT * FROM " . $table_name);
			$table_data = str_putcsv($result);
			$array[$table_name . ".csv"] = $table_data;
		}

		//Specific query to keep it anonimous
		if (!$complete)
		{
			$table_name = "profile";
			$result = $this->single_query("SELECT profile_id, creation_time, birthday, gender, city FROM profile");
			$table_data = str_putcsv($result);
			$array[$table_name . ".csv"] = $table_data;
		}

		//The full table
		$this->multi_query("
			SET @@group_concat_max_len = 5000;
			SET @sql = NULL;
			SELECT
			  GROUP_CONCAT(DISTINCT
			    CONCAT(
			      'MAX(IF(question = ''', question , ''', answer.value, NULL)) AS ''', question , ''''
			    )
			  ) INTO @sql
			FROM question;
			    
			SET @sql = CONCAT('SELECT evaluation.*, profile_id, creation_time, birthday, gender, city, ', @sql, ''' FROM evaluation JOIN profile USING(profile_id) JOIN answer USING(evaluation_id) JOIN question USING(question_id) GROUP BY evaluation.evaluation_id');
			
			PREPARE stmt FROM @sql;
			");
		$r = $this->conn->query("EXECUTE stmt");
		$this->conn->query("DEALLOCATE PREPARE stmt");
		$result = array();
		while($tmp = $r->fetch_array(MYSQLI_ASSOC)) $result[] = $tmp;

		$table_data = str_putcsv($result);
		$array["full.csv"] = $table_data;

		//return $result;
		return generate_zip($array);
	}

	/**
	 * Returns array with questions:
	 * [$modal_id]	->[$question_id]	->["question"] 		= $question
	 * 									->["name"]			= $name
	 * 									->["weight"] 		= $weight
	 * 									->["type"]			= $type
	 * 									->["is_mandatory"] 	= $is_mandatory
	 * 									->["choices"]		-> [$choice_id]	-> ["choice"]	= $choice
	 * 																		-> ["value"]	= $value
	 */
	public function get_questions()
	{
		$sql_questions = "
			SELECT modal_id, question_id, name, question, weight, is_mandatory, type
			FROM modal
			JOIN modal_question USING(modal_id)
			JOIN question USING(question_id)
			";

		$sql_coices = "
			SELECT choice_id, choice, value
			FROM choice
			WHERE question_id = ?
			";

		//== Get questions
		$stmt_questions = $this->prepare($sql_questions);
		$result_questions = $stmt_questions->execute();
		//$result_questions = stmt_execute($stmt_questions);

		//== Prepare choices
		$stmt_choices = $this->prepare($sql_coices);
		$stmt_choices->bind_param("s", array(&$question_id));

		//== Make JSON as array
		while ($question_row = array_shift($result_questions))
		{
			$modal_id = $question_row["modal_id"];
			$question_id = $question_row["question_id"];
			$name = $question_row["name"];
			$question = $question_row["question"];
			$weight = $question_row["weight"];
			$type = $question_row["type"];
			$is_mandatory = $question_row["is_mandatory"];

			$array[$modal_id][$question_id] = [
			"name" => $name,
			"question" => $question,
			"weight" => $weight,
			"type" => $type,
			"is_mandatory" => $is_mandatory];

			//== Get choices for this $question
			$result_choices = $stmt_choices->execute();

			while ($choice_row = array_shift($result_choices))
			{
				$choice_id = $choice_row["choice_id"];
				$choice = $choice_row["choice"];
				$choice_value = $choice_row["value"];

				$array[$modal_id][$question_id]["choices"][$choice_id] = [
				"choice" => $choice,
				"value" => $choice_value];
			}
		}

		//Finish
		return $array;
	}

	/*public function get_user_id()
	 {
	 $email = null;
	 $name = "Nome de teste para usuário";
	 $user_id = 0;

	 $sql_add_profile = "INSERT INTO profile (email, name) VALUES(?, ?);";

	 $stmt_add_profile = $this->prepare($sql_add_profile);

	 $stmt_add_profile->bind_param("ss", array(
	 &$email,
	 &$name
	 ));

	 $stmt_add_profile->execute();

	 //Now we know user id!
	 $user_id = $this->conn->insert_id;

	 $array["user_id"] = $user_id;
	 $array["user_name"] = $name;
	 $array["user_email"] = $email;

	 return $array;
	 }*/

	public function set_profile($profile_id, $facebook_id, $google_id, $name, $email, $birthday, $gender, $city, $newsletter)
	{
		//Try to find an ID that matches
		if ($email != null && $email != "")
		{
			$sql = "SELECT profile_id FROM profile WHERE email = ?;";
			$stmt = $this->prepare($sql);
			$stmt->bind_param("s", array(&$email));
			$result = $stmt->execute();

			if ($result_row = array_shift($result))
			{
				$new_profile_id = $result_row["profile_id"];

				if ($profile_id == null)
				{
					$profile_id = $new_profile_id;
				}
				else
				{
					if ($profile_id != $new_profile_id)// Then we know the user is trying to set an e-mail that is already owned by new_profile_id
					{
						ERROR_EXIT("Este e-mail já está em uso por outro cadastro!");
					}
				}
			}
		}
		if ($profile_id == null && $facebook_id != null && $facebook_id != "")
		{
			$sql = "SELECT profile_id FROM profile JOIN account_facebook USING (profile_id) WHERE facebook_id = ?;";
			$stmt = $this->prepare($sql);
			$stmt->bind_param("s", array(&$facebook_id));
			$result = $stmt->execute();

			if ($result_row = array_shift($result))
			{
				$profile_id = $result_row["profile_id"];
			}
		}
		if ($profile_id == null && $google_id != null && $google_id != "")
		{
			$sql = "SELECT profile_id FROM profile JOIN account_google USING (profile_id) WHERE google_id = ?;";
			$stmt = $this->prepare($sql);
			$stmt->bind_param("s", array(&$google_id));
			$result = $stmt->execute();

			if ($result_row = array_shift($result))
			{
				$profile_id = $result_row["profile_id"];
			}
		}

		//Now we update the ID we found, or create a new one if none was found
		$sql = "
			INSERT INTO profile (profile_id, name, email, birthday, gender, city, newsletter) 
				VALUE(?, ?, ?, ?, ?, ?, ?) 
				ON DUPLICATE KEY UPDATE 
					profile_id = VALUES(profile_id),
					name = VALUES(name), 
					email = VALUES(email), 
					birthday = VALUES(birthday),
					gender = VALUES(gender),
					newsletter = VALUES(newsletter),
					city = VALUES(city);
			";
		$stmt = $this->prepare($sql);
		$stmt->bind_param("sssssss", array(
			&$profile_id,
			&$name,
			&$email,
			&$birthday,
			&$gender,
			&$city,
			&$newsletter
		));
		$stmt->execute();

		//If no ID found before, we get the one we just added
		if ($profile_id == null)
		{
			//Now we know user id!
			$profile_id = $this->conn->insert_id;

			//If it is still null, we got a problem
			if ($profile_id == null || $profile_id == 0)
			{
				ERROR_EXIT("Não foi possível recuperar o ID de usuário, tente outra forma de cadastro ou entre em contato conosco!", "profile_id == null");
			}
		}

		//Update social networking info
		if ($facebook_id != null && $facebook_id != "")
		{
			$sql = "
			INSERT INTO account_facebook (profile_id, facebook_id) 
				VALUE(?, ?) 
				ON DUPLICATE KEY UPDATE 
					profile_id = VALUES(profile_id),
					facebook_id = VALUES(facebook_id);
			";
			$stmt = $this->prepare($sql);
			$stmt->bind_param("ss", array(
				&$profile_id,
				&$facebook_id
			));
			$stmt->execute();
		}
		if ($google_id != null && $google_id != "")
		{
			$sql = "
			INSERT INTO account_google (profile_id, google_id) 
				VALUE(?, ?) 
				ON DUPLICATE KEY UPDATE 
					profile_id = VALUES(profile_id),
					google_id = VALUES(google_id);
			";
			$stmt = $this->prepare($sql);
			$stmt->bind_param("ss", array(
				&$profile_id,
				&$google_id
			));
			$stmt->execute();
		}

		//Now we get all profile info to return
		$array["profile_id"] = $profile_id;

		$array["facebook_id"] = $facebook_id;
		$array["google_id"] = $google_id;

		$array["newsletter"] = $newsletter;

		$array["name"] = $name;
		$array["email"] = $email;
		$array["birthday"] = $birthday;
		$array["gender"] = $gender;
		$array["city"] = $city;

		return $array;
	}

	/**
	 * Returns array with statiscs for (line, if line_name, otherwise city)
	 *
	 * ["evaluation_count"]		= $evaluation_count
	 * ["total_value"]			= $total_value (the weighted average for all the answers)
	 */
	public function get_statistics($city_name, $modal_id, $line_name = null)
	{
		$sql_statistics = "
			SELECT AVG(total_value) as total_value, COUNT(DISTINCT evaluation_id) as evaluation_count
				FROM evaluation
				WHERE
					modal_id = ? AND
					line_name = ? AND
					city_name = ?
			;
		";

		if (!$line_name)
			$sql_statistics = "
				SELECT AVG(total_value) as total_value, COUNT(DISTINCT evaluation_id) as evaluation_count
					FROM evaluation
					WHERE
						modal_id = ? AND
						city_name = ?
				;
			";

		$stmt_statistics = $this->prepare($sql_statistics);
		if (!$line_name)
		{
			$stmt_statistics->bind_param("ss", array(
				&$modal_id,
				&$city_name
			));
		}
		else
		{
			$stmt_statistics->bind_param("sss", array(
				&$modal_id,
				&$line_name,
				&$city_name
			));
		}
		$result_statistics = $stmt_statistics->execute();

		if ($statistics_row = array_shift($result_statistics))
		{
			$array["total_value"] = $statistics_row["total_value"];
			$array["evaluation_count"] = $statistics_row["evaluation_count"];
		}

		//Finish
		return $array;
	}

	/**
	 * Returns array with evaluation of (line if line_name is set, city if no line_name)
	 * ["answers"]				->[$question_id] 	= $value
	 * [] Merged with get_statistics
	 */
	public function get_evaluation($city_name, $modal_id, $line_name = null)
	{
		$sql_answers_avg = "
			SELECT question_id, AVG(value) AS value
			FROM answer
			WHERE evaluation_id IN (
			SELECT evaluation_id
			FROM evaluation
			WHERE
			modal_id = ? AND
			line_name = ? AND
			city_name = ?
			)
			GROUP BY question_id;
			";

		if (!$line_name)
			$sql_answers_avg = "
			SELECT question_id, AVG(value) as value
			FROM answer
			WHERE evaluation_id IN (
			SELECT evaluation_id
			FROM evaluation
			WHERE
			modal_id = ? AND
			city_name = ?
			)
			GROUP BY question_id;
			";

		$stmt_answers_avg = $this->prepare($sql_answers_avg);
		if (!$line_name)
		{
			$stmt_answers_avg->bind_param("ss", array(
				&$modal_id,
				&$city_name
			));
		}
		else
		{
			$stmt_answers_avg->bind_param("sss", array(
				&$modal_id,
				&$line_name,
				&$city_name
			));
		}
		$result_answers_avg = $stmt_answers_avg->execute();

		while ($answers_avg_row = array_shift($result_answers_avg))
		{
			$q_id = $answers_avg_row["question_id"];
			$value = $answers_avg_row["value"];

			$array["answers"][$q_id] = $value;
		}

		$statistics_array = $this->get_statistics($city_name, $modal_id, $line_name);
		$array = array_merge($array, $statistics_array);

		//Finish
		return $array;
	}

	public function get_modal_ranking($city_name) {
		$query = "SELECT modal_id as modal_name, AVG(total_value) AS modal_rank 
			FROM evaluation 
			WHERE 
				city_name = ?
			GROUP BY modal_id
			ORDER BY modal_id";

		$stmt_ranking = $this->prepare($query);

		$stmt_ranking->bind_param("s", array(				
			&$city_name
		));

		$resul = $stmt_ranking->execute();

		$array = [];
		while ($row = array_shift($resul))
		{
			$modal_name = $row["modal_name"];
			$modal_rank = $row["modal_rank"];

			$line_info["modal_name"] = $modal_name;
			$line_info["modal_rank"] = round($modal_rank, 1);

			array_push($array, $line_info);
		}

		//Finish
		return $array;
	}

	/**
	 * Returns array with $limit_count best and worst evaluations
	 * ["best"]	=> [""]
	 */
	public function get_best_and_worst($city_name, $modal_id, $limit_count)
	{
		$sql_best = "
			SELECT line_name, AVG(total_value) AS total_value 
				FROM evaluation 
			    WHERE 
					city_name = ?
			        AND
			        modal_id = ?
			    GROUP BY line_name 
			    ORDER BY total_value DESC LIMIT ?;
		";

		$sql_worst = "
			SELECT line_name, AVG(total_value) AS total_value 
				FROM evaluation 
			    WHERE 
					city_name = ?
			        AND
			        modal_id = ?
			    GROUP BY line_name 
			    ORDER BY total_value ASC LIMIT ?;
		";

		$stmt_best = $this->prepare($sql_best);
		$stmt_worst = $this->prepare($sql_worst);

		$stmt_best->bind_param("sss", array(
			&$city_name,
			&$modal_id,
			&$limit_count
		));
		$stmt_worst->bind_param("sss", array(
			&$city_name,
			&$modal_id,
			&$limit_count
		));

		$result_best = $stmt_best->execute();
		$result_worst = $stmt_worst->execute();

		$array["best"] = [];
		while ($row = array_shift($result_best))
		{
			$line_name = $row["line_name"];
			$total_value = $row["total_value"];

			$line_info["line_id"] = $line_name;
			$line_info["total_value"] = round($total_value, 1);

			array_push($array["best"], $line_info);
		}

		$array["worst"] = [];
		while ($row = array_shift($result_worst))
		{
			$line_name = $row["line_name"];
			$total_value = $row["total_value"];

			$line_info["line_id"] = $line_name;
			$line_info["total_value"] = round($total_value, 1);

			array_push($array["worst"], $line_info);
		}

		/*$statistics_array = $this->get_statistics($city_name, $modal_id, $line_name);
		 $array = array_merge($array, $statistics_array);*/

		//Finish
		return $array;
	}

	/**
	 * Returns array with $limit_count best and worst evaluations
	 * ["best"]	=> [""]
	 */
	public function get_best_worst($city_name, $modal_id, $limit_count)
	{
		$query_filter="";
		$query_limit="";
		$query_sort="";

		// Where
		if ($city_name != null && $modal_id != null)
			$query_filter = "where ev.city_name='".$city_name."' and ev.modal_id='".$modal_id."'";
		elseif ($city_name == null && $modal_id != null)
			$query_filter = "where ev.modal_id='".$modal_id."'";
		elseif ($modal_id == null && $city_name != null)
			$query_filter = "where ev.city_name='".$city_name."'";

		// Limit
		if($limit_count != null)
			$query_limit = " limit ".$limit_count;
		else 
			$query_limit = " limit 10";


		$sql_best = "
			SELECT ev.line_name, li.line_info, AVG(ev.total_value) AS total_value 
				FROM evaluation ev "
				." inner join line li on (li.line_name=ev.line_name and li.modal_id=ev.modal_id) "
			    .$query_filter 			    
				."GROUP BY ev.line_name, li.line_info  "	
				."ORDER BY total_value DESC"			
				.$query_limit;

		$sql_worst = "
			SELECT ev.line_name, li.line_info, AVG(ev.total_value) AS total_value 
				FROM evaluation ev "
				." inner join line li on (li.line_name=ev.line_name and li.modal_id=ev.modal_id) "				
			    .$query_filter 			    
				."GROUP BY ev.line_name, li.line_info  "				
				."ORDER BY total_value ASC"			
				.$query_limit;

		$stmt_best = $this->prepare($sql_best);
		$stmt_worst = $this->prepare($sql_worst);

		$result_best = $stmt_best->execute();
		$result_worst = $stmt_worst->execute();

		$array["best"] = [];
		while ($row = array_shift($result_best))
		{
			$line_name = $row["line_name"];
			$line_route = $row["line_info"];
			$total_value = $row["total_value"];

			$line_info["line_id"] = $line_name;
			$line_info["line_info"] = $line_route;
			$line_info["total_value"] = round($total_value, 1);

			array_push($array["best"], $line_info);
		}

		$array["worst"] = [];
		while ($row = array_shift($result_worst))
		{
			$line_name = $row["line_name"];
			$line_route = $row["line_info"];
			$total_value = $row["total_value"];

			$line_info["line_id"] = $line_name;
			$line_info["line_info"] = $line_route;
			$line_info["total_value"] = round($total_value, 1);

			array_push($array["worst"], $line_info);
		}

		//Finish
		return $array;
	}

	public function get_ranking_size($city_name, $modal_id, $limit, $sort_column) {
		$size = count($this->get_ranking_info($city_name, $modal_id, null, null, $sort_column));
		return ($size==0)? 0 : ceil($size/$limit);
	}

	public function get_full_ranking_info($city_name, $modal_id) {
		return $this->get_ranking_info($city_name, $modal_id, null, null, null);
	}

	public function get_ranking_info($city_name, $modal_id, $limit_count, $current_page, $sort_column) {
		$query_filter="";
		$query_limit="";
		$query_sort="";

		// Where
		if ($city_name != null && $modal_id != null)
			$query_filter = "WHERE ev.city_name='".$city_name."' and ev.modal_id='".$modal_id."'";
		elseif ($city_name == null && $modal_id != null)
			$query_filter = "WHERE ev.modal_id='".$modal_id."'";
		elseif ($modal_id == null && $city_name != null)
			$query_filter = "WHERE ev.city_name='".$city_name."' and ev.modal_id='onibus'";
		else 
			$query_filter = "WHERE ev.modal_id='onibus'";

		// Order By
		if($sort_column != null)
			$query_sort = " ORDER BY ". $sort_column . " desc";
		else
			$query_sort = " ORDER BY geral desc";

		// Limit
		if($limit_count != null) {			
			if($current_page != null) {
				$page_node = $limit_count * $current_page;
				$query_limit = " LIMIT ".$page_node.','.$limit_count;		
			}
			else 
				$query_limit = " LIMIT " . $limit_count;		
		}

		$sql_info = "
			SELECT ev.line_name as line_name, li.line_info as line_info, 
				AVG((SELECT AVG(a.value) AS value FROM answer a where a.question_id=7 and a.evaluation_id=ev.evaluation_id)) as pontualidade,
				AVG((SELECT AVG(a.value) AS value FROM answer a where a.question_id=9 and a.evaluation_id=ev.evaluation_id)) as lotacao,
				AVG((SELECT AVG(a.value) AS value FROM answer a where a.question_id=10 and a.evaluation_id=ev.evaluation_id)) as limpeza,
				AVG((SELECT AVG(a.value) AS value FROM answer a where a.question_id=11 and a.evaluation_id=ev.evaluation_id)) as transito,
				AVG((SELECT AVG(a.value) AS value FROM answer a where a.question_id=12 and a.evaluation_id=ev.evaluation_id)) as motorista,
				AVG((SELECT AVG(a.value) AS value FROM answer a where a.question_id=13 and a.evaluation_id=ev.evaluation_id)) as seguranca,
				AVG(ev.total_value) as geral 
			FROM movecidade_app.evaluation as ev 			
			inner join line li on (li.line_name=ev.line_name and li.modal_id=ev.modal_id) "			
			.$query_filter 
			." GROUP BY ev.line_name "
			.$query_sort
			.$query_limit;

		$stmt_info = $this->prepare($sql_info);		
		$result_info = $stmt_info->execute();

		$array = [];
		while ($row = array_shift($result_info))
		{
			$line_info["line_name"] = $row["line_name"];
			$line_info["line_info"] = $row["line_info"];

			$line_info["pontualidade"] = round($row["pontualidade"], 1);
			$line_info["lotacao"] = round($row["lotacao"], 1);
			$line_info["limpeza"] = round($row["limpeza"], 1);
			$line_info["transito"] = round($row["transito"], 1);
			$line_info["motorista"] = round($row["motorista"], 1);
			$line_info["seguranca"] = round($row["seguranca"], 1);

			$line_info["geral"] = round($row["geral"], 1);

			array_push($array, $line_info);
		}	

		return $array;
	}

	/**
	 * Returns best and worst evaluations for eac quastion for this city and modal
	 * ["questions"] 	=> [$question_id] 	=> ["best"] 	=> ["line_name"] 	= $best_line;
	 * 														=> ["total_value"] 	= $best_line_value;
	 * 										=> ["worst"] 	=> ["line_name"] 	= $worst_line;
	 * 														=> ["total_value"] 	= $worst_line_value;
	 * 					=> ["total_value"]	=> ["best"] 	=> ["line_name"] 	= $total_best_line;
	 * 														=> ["total_value"] 	= $total_best_line_value;
	 * 										=> ["worst"] 	=> ["line_name"] 	= $total_worst_line;
	 * 														=> ["total_value"] 	= $total_worst_line_value;
	 */
	public function get_dossier($city_name, $modal_id)
	{
		$sql_create_main_table = "
			CREATE TEMPORARY TABLE IF NOT EXISTS tmp_question_avg_values AS
			(SELECT
			question_id,
			line_name,
			AVG(value) as avg_value
			FROM
			movecidade_app.evaluation
			JOIN answer USING(evaluation_id)
			WHERE
			modal_id = ? AND
			city_name = ?
			GROUP BY question_id, line_name
			ORDER BY avg_value
			)
			;
			";

		$sqls_create_tables = "
			CREATE TEMPORARY TABLE IF NOT EXISTS tmp_min_values AS
			(SELECT
			question_id,
			line_name AS line_min,
			avg_value AS min_value
			FROM tmp_question_avg_values
			GROUP BY question_id
			)
			;

			CREATE TEMPORARY TABLE IF NOT EXISTS tmp_max_values AS
			(SELECT *
			FROM
			(SELECT
			question_id,
			line_name AS line_max,
			avg_value AS max_value
			FROM tmp_question_avg_values
			ORDER BY avg_value DESC
			) AS T
			GROUP BY question_id
			)
			;

			CREATE TEMPORARY TABLE IF NOT EXISTS tmp_total_values AS
			(
			SELECT
			line_name,
			SUM(weight*avg_value)/SUM(weight) AS total_value
			FROM tmp_question_avg_values JOIN question USING(question_id)
			GROUP BY line_name
			)
			;
			";

		$sql_dossier = "
			SELECT
			question_id,
			line_min,
			line_max,
			min_value,
			max_value
			FROM
			tmp_min_values JOIN tmp_max_values USING(question_id);
			";

		$sql_best = "
			SELECT line_name, total_value FROM tmp_total_values ORDER BY total_value DESC LIMIT 1;
			";

		$sql_worst = "
			SELECT line_name, total_value FROM tmp_total_values ORDER BY total_value LIMIT 1;
			";

		//Generate tables we'll need
		$stmt_create_main_table = $this->prepare($sql_create_main_table);

		$stmt_create_main_table->bind_param("ss", array(
			&$modal_id,
			&$city_name
		));

		$stmt_create_main_table->execute();

		$this->multi_query($sqls_create_tables);

		//Queries
		$stmt_dossier = $this->prepare($sql_dossier);
		$stmt_best = $this->prepare($sql_best);
		$stmt_worst = $this->prepare($sql_worst);

		$result_dossier = $stmt_dossier->execute();
		$result_best = $stmt_best->execute();
		$result_worst = $stmt_worst->execute();

		while ($dossier_row = array_shift($result_dossier))
		{
			$q_id = $dossier_row["question_id"];
			$line_max = $dossier_row["line_max"];
			$line_min = $dossier_row["line_min"];
			$max_value = $dossier_row["max_value"];
			$min_value = $dossier_row["min_value"];

			$array["questions"][$q_id]["best"]["line_name"] = $line_max;
			$array["questions"][$q_id]["best"]["total_value"] = $max_value;
			$array["questions"][$q_id]["worst"]["line_name"] = $line_min;
			$array["questions"][$q_id]["worst"]["total_value"] = $min_value;
		}

		if ($best_row = array_shift($result_best))
		{
			$array["questions"]["total_value"]["best"]["line_name"] = $best_row["line_name"];
			$array["questions"]["total_value"]["best"]["total_value"] = $best_row["total_value"];
		}

		if ($worst_row = array_shift($result_worst))
		{
			$array["questions"]["total_value"]["worst"]["line_name"] = $worst_row["line_name"];
			$array["questions"]["total_value"]["worst"]["total_value"] = $worst_row["total_value"];
		}

		//Finish
		return $array;
	}

	public function get_cities() {
		$query = "SELECT distinct(city_name) as value FROM evaluation";

		$result = $this->single_query($query);
		$array = [];
		while ($row = array_shift($result))
		{
			$line_info["value"] = $row["value"];
			array_push($array, $line_info);
		}

		return $array;
	}

	public function get_modal() {
		get_modals_by_city(null);
	}

	public function get_modals_by_city($city) {
		if($city == null)
			$query = "SELECT distinct(modal_id) as value FROM evaluation";
		else
			$query = "SELECT distinct(modal_id) as value FROM evaluation where city_name='" . $city . "'";

		$result = $this->single_query($query);
		$array = [];
		while ($row = array_shift($result))
		{
			$line_info["value"] = $row["value"];
			array_push($array, $line_info);
		}

		return $array;
	}

	/**
	 * Adds a choice, or updates one if choice_id is not null and equals to one that already exists.
	 */
	public function set_choices($choice_id, $question_id, $choice, $value)
	{
		$sql = "
			INSERT INTO choice (choice_id, question_id, choice, value) 
			VALUE(?, ?, ?, ?) 
			ON DUPLICATE KEY UPDATE 
				choice_id = VALUES(choice_id),
				question_id = VALUES(question_id), 
				choice = VALUES(choice), 
				value = VALUES(value);
		";

		$stmt = $this->prepare($sql);

		$stmt->bind_param("ssss", array(
			&$choice_id,
			&$question_id,
			&$choice,
			&$value
		));

		$stmt->execute();

		if ($this->conn->affected_rows > 0)
			JSON_EXIT_PUSH_STRING("CHANGES: Rows affected by set_choices: " . $this->conn->affected_rows);
	}

	/**
	 * Adds a question, or updates one if question_id is set and equals to one that already exists.
	 */
	public function set_question($question_id, $name, $question, $weight, $is_mandatory, $type)
	{
		$sql = "
			INSERT INTO question (question_id, name, question, weight, is_mandatory, type) 
			VALUE(?, ?, ?, ?, ?, ?) 
			ON DUPLICATE KEY UPDATE 
				question_id = VALUES(question_id), 
				name = VALUES(name), 
				question = VALUES(question), 
				weight = VALUES(weight), 
				is_mandatory = VALUES(is_mandatory), 
				type = VALUES(type);
		";

		$stmt = $this->prepare($sql);

		$stmt->bind_param("ssssss", array(
			&$question_id,
			&$name,
			&$question,
			&$weight,
			&$is_mandatory,
			&$type
		));

		$stmt->execute();

		if ($this->conn->affected_rows > 0)
			JSON_EXIT_PUSH_STRING("CHANGES: Rows affected by set_question: " . $this->conn->affected_rows);
	}

	/**
	 * Sets what question is linked to a modal, expects a modal id and an array of question_ids
	 * [$question_id]
	 */
	public function set_modal_question($modal_id, $question_id)
	{
		$sql = "INSERT INTO modal_question (modal_id, question_id) VALUES(?, ?) ON DUPLICATE KEY UPDATE modal_id = modal_id, question_id = question_id;";

		$stmt = $this->prepare($sql);

		$stmt->bind_param("ss", array(
			&$modal_id,
			&$question_id
		));

		$stmt->execute();

		/*if ($this->conn->affected_rows > 0)
		 JSON_EXIT_PUSH_STRING("CHANGES: Rows affected by set_modal_question: " . $this->conn->affected_rows);*/
	}

	/**
	 * Adds a new version timestamp to database
	 */
	public function set_version()
	{
		$this->single_query("INSERT INTO gtfs_version (version_id) VALUES (DEFAULT);");
	}

	/**
	 * Returns the version id in the form of:
	 * ["version_id"] = $newest_version_timestamp
	 */
	public function get_version()
	{
		$result = $this->single_query("SELECT * FROM gtfs_version ORDER BY version_id DESC LIMIT 1;");

		return array_shift($result);
	}

	/**
	 * Expects
	 * [$evaluation_id] = $disliked(bool)
	 *
	 * Returns rows that were affected
	 */
	public function set_disliked_evaluations($evaluation_ids)
	{
		$sql = "UPDATE evaluation SET disliked_evaluation = 1 WHERE evaluation_id = ?;";

		$stmt = $this->prepare($sql);

		$stmt->bind_param("s", array(&$evaluation_id, ));

		$total_rows = 0;
		foreach ($evaluation_ids as $evaluation_id => $value)
		{
			if ($value == true)
			{
				$stmt->execute();

				if ($this->conn->affected_rows > 0)
				{
					JSON_EXIT_PUSH_STRING("CHANGES: Rows affected by set_disliked_evaluation: " . $this->conn->affected_rows . " Evaluation ID: " . $evaluation_id);
					$total_rows++;
				}
			}
		}

		return ["TOTAL ROWS CHANGED: " . $total_rows];
	}

	/**
	 * Returns
	 * [$arrayID]	-> $evaluation_id;
	 *
	 * Expects a list of evaluations:
	 * [$arrayID]	->["city_name"]	= $city_name
	 * 				->["modal_id"]	= $modal_id
	 * 				->["line_name"]	= $line_name
	 * 				->["answers"]	= [$question_id] = $value
	 * 				->["total"]		= $total_value
	 */
	public function set_line_evaluation($profile_id, $evaluations)
	{
		//Variables
		$city_name = "";
		$modal_id = 0;
		$line_name = "";
		$evaluaton_id = 0;
		$question_id = 0;
		$value = 0;
		$total_value = 0;

		//Queries
		$sql_add_evaluation = "
			INSERT INTO evaluation (profile_id, modal_id, line_name, city_name, total_value )
			VALUES( ?, ?, ?, ?, ?);
			";

		$sql_add_answer = "INSERT INTO answer (evaluation_id, question_id, value) VALUES(?,?,?);";

		$this->start_transaction();

		//Prepare!
		$stmt_add_evaluation = $this->prepare($sql_add_evaluation);
		$stmt_add_evaluation->bind_param("sssss", array(
			&$profile_id,
			&$modal_id,
			&$line_name,
			&$city_name,
			&$total_value
		));

		$stmt_add_answer = $this->prepare($sql_add_answer);
		$stmt_add_answer->bind_param("sss", array(
			&$evaluaton_id,
			&$question_id,
			&$value
		));

		$output = [];

		//echo array_to_json($evaluations);
		//Iterate over evaluations
		foreach ($evaluations as $key => $evaluation)
		{
			//Checks before
			if (!isset($evaluation["city_name"]) || !isset($evaluation["modal_id"]) || !isset($evaluation["line_name"]) || !isset($evaluation["total"]))
				ERROR_EXIT("Some evaluations had no mandatory fields set");

			$city_name = $evaluation["city_name"];
			$modal_id = $evaluation["modal_id"];
			$line_name = $evaluation["line_name"];
			$total_value = $evaluation["total"];

			$answers = $evaluation["answers"];

			//Execute!
			$stmt_add_evaluation->execute("Houve um problema ao submeter avaliação, para resolver reinstale ou limpe os dados do App");

			$evaluaton_id = $this->conn->insert_id;
			array_push($output, $evaluaton_id);

			foreach ($answers as $q_id => $value)
			{
				$question_id = $q_id;
				$value = $value;

				$stmt_add_answer->execute();
			}
		}

		$this->commit_transaction();

		return $output;
	}

	/**
	 * Expects
	 * [$modal_id]	->[$question_id]	->["question"] 		= $question
	 * 									->["name"] 			= $name
	 * 									->["weight"] 		= $weight
	 * 									->["type"]			= $type
	 * 									->["is_mandatory"] 	= $is_mandatory
	 * 									->["choices"]		-> [$choice_id]	-> ["choice"]	= $choice
	 * 																		-> ["value"]	= $value
	 */
	public function set_questions($modals)
	{
		$sql_add_modal = "INSERT INTO modal (modal_id) VALUE(?) ON DUPLICATE KEY UPDATE modal_id = modal_id;";

		$stmt_add_modal = $this->prepare($sql_add_modal);

		$stmt_add_modal->bind_param("s", array(&$modal_id));

		foreach ($modals as $modal_id => $questions)
		{
			//ADD modal
			$stmt_add_modal->execute();

			//Make sure that only these new questions will be linked to this modal
			$sql = "DELETE FROM modal_question WHERE modal_id = ?";
			$stmt = $this->prepare($sql);
			$stmt->bind_param("s", array(&$modal_id));
			$stmt->execute();

			//For each question add it, add it's choices and link to modal
			foreach ($questions as $question_id => $question)
			{
				$this->set_question($question_id, $question["name"], $question["question"], $question["weight"], $question["is_mandatory"], $question["type"]);
				$choices = $question["choices"];

				foreach ($choices as $choice_id => $choice)
				{
					$this->set_choices($choice_id, $question_id, $choice["choice"], $choice["value"]);
				}

				$this->set_modal_question($modal_id, $question_id);
			}
		}
	}

	function start_transaction()
	{
		if (!$this->conn->autocommit(FALSE))
		{
			ERROR_EXIT("Could not start transaction (autocommit = off), Error:" . $this->conn->error);
		}
	}

	function commit_transaction()
	{
		if (!$this->conn->commit())
		{
			ERROR_EXIT("Could not commit transaction, Error:" . $this->conn->error);
		}

		if (!$this->conn->autocommit(TRUE))
		{
			ERROR_EXIT("Could not end transaction (autocommit = off), Error:" . $this->conn->error);
		}
	}

	function multi_query($sqls)
	{
		if (!$this->conn->multi_query($sqls))
		{
			ERROR_EXIT("Could not execute query: " . $sqls . ", Error:" . $this->conn->error);
		}
		while ($result = $this->conn->next_result())
		{;
		}// flush multi_queries

		return $result;
	}

	function single_query($sql)
	{
		$stmt = $this->prepare($sql);
		return $stmt->execute();
	}

	function prepare($sql)
	{
		if (!$stmt = $this->conn->prepare($sql))
		{
			ERROR_EXIT("Could not prepare query: " . $sql . ", Error:" . $this->conn->error);
		}

		return $stmt;
	}

	public function close()
	{
		$this->conn->close();
	}

}
?>