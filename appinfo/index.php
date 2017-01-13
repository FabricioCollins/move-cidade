<?php
header('Content-Type: application/json; charset=ISO-8859-15');
header('Access-Control-Allow-Origin: http://movecidade.org.br');
//header("Content-Type: text/html; charset=utf-8");
error_reporting(E_ALL | E_STRICT);

include_once ('database_access.php');
include_once ('utils.php');

function process_requests()
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{

		if (!isset($_FILES['gtfs_file']))
		{
			$minimum_version = "0.2.6";
			$app_version = $_POST['app_version'];

			if (!!$app_version)
			{
				if (version_compare($app_version, $minimum_version, "<"))
					ERROR_EXIT("Por favor atualize seu aplicativo. Versão mínima: " . $minimum_version . ". Versão instalada: " . $app_version);
			}
			else
			{
				ERROR_EXIT("Por favor atualize seu aplicativo. Versão mínima: " . $minimum_version);
			}
		}

		$db = new database_access();
		$db->open();

		if (isset($_POST['get_questions']))
		{
			$result = $db->get_questions();

			if ($result == null)
				ERROR_EXIT("Questionário não encontrado no servidor, verifique se o aplicativo está atualizado", "get_questions == null");

			JSON_EXIT_ARRAY($result);
		}
		/*


		else


		 if (isset($_POST['get_user_id']))
		 {
		 $result = $db->get_user_id();
		 JSON_EXIT_ARRAY($result);
		 }*/
		elseif (isset($_POST['set_profile']))
		{
			$result = $db->set_profile($_POST['profile_id'], $_POST['facebook_id'], $_POST['google_id'], $_POST['name'], $_POST['email'], $_POST['birthday'], $_POST['gender'], $_POST['city'], $_POST['newsletter']);
			JSON_EXIT_ARRAY($result);
		}
		elseif (isset($_POST['get_evaluation'], $_POST['city_name'], $_POST['modal_id']))
		{
			$result = $db->get_evaluation($_POST['city_name'], $_POST['modal_id'], $_POST['line_name']);
			JSON_EXIT_ARRAY($result);
		}
		elseif (isset($_POST['get_best_and_worst'], $_POST['city_name'], $_POST['modal_id'], $_POST['limit_count']))
		{
			$result = $db->get_best_and_worst($_POST['city_name'], $_POST['modal_id'], $_POST['limit_count']);
			JSON_EXIT_ARRAY($result);
		}
		elseif (isset($_POST['set_line_evaluation'], $_POST['profile_id'], $_POST['evaluations']))
		{
			$result = $db->set_line_evaluation($_POST['profile_id'], json_decode($_POST['evaluations'], TRUE));
			JSON_EXIT_ARRAY($result);
		}
		elseif (isset($_POST['get_dossier'], $_POST['city_name'], $_POST['modal_id']))
		{
			$result = $db->get_dossier($_POST['city_name'], $_POST['modal_id']);
			JSON_EXIT_ARRAY($result);
		}
		elseif (isset($_POST['get_version']))
		{
			$result = $db->get_version();
			JSON_EXIT_ARRAY($result);
		}
		elseif (isset($_POST['set_disliked_evaluations'], $_POST['evaluation_ids']))
		{
			$result = $db->set_disliked_evaluations(json_decode($_POST['evaluation_ids'], TRUE));
			JSON_EXIT_ARRAY($result);
		}
		elseif (isset($_FILES['gtfs_file'], $_POST['set_questions']))
		{
			$db->set_version();

			$uploaddir = '/var/www/html/appinfo/gtfs_db/';
			$uploadfile = $uploaddir . basename($_FILES['gtfs_file']['name']);

			if (move_uploaded_file($_FILES['gtfs_file']['tmp_name'], $uploadfile))
			{
				$questions = json_decode($_POST['set_questions'], TRUE);
				$db->set_questions($questions);

				JSON_EXIT_STRING("Arquivo valido e enviado com sucesso.");
			}
			else
			{
				ERROR_EXIT("Problema no upload", "Possivel ataque de upload de arquivo!");
			}
		}
		else
		{
			ERROR_EXIT("Servidor não reconheceu a operação, verifique se o aplicativo está atualizado.", "Nothing is set to do on server");
		}

		$db->close();
		JSON_EXIT_STRING("Operation finished ok!");
	}
	else
	{
		$db = new database_access();
		$db->open();

		$result = $db->get_version();

		JSON_EXIT_STRING("Server is running");

		$db->close();
	}
}

//process entry
process_requests();
?>
