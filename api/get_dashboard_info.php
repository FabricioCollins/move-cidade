<?php
header("Content-Type: text/html; charset=ISO-8859-15");

include_once ('../appinfo/database_access.php');


	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		$db = new database_access();
		$db->open();

		$output = "";

		if (isset($_GET['city_name'], $_GET['modal_id'], $_GET['limit_count']))
		{
			$result = $db->get_best_worst($_GET['city_name'], $_GET['modal_id'], $_GET['limit_count']);			
		}		
		
		$db->close();
	}

?>

<div class="table-cell ranking best">
	<h3>Melhores</h3>
	<ul>
		<?php 
			foreach ($result['best'] as $item) {			
		?>
		<li>
			<span class="numero"><?php echo $item["line_id"] ?></span>
			<span class="nome"><?php echo $item["line_info"] ?></span>
			<span class="nota"><?php echo $item["total_value"] ?></span>
		</li>
		<?php 
			}
		?>		
	</ul>
</div>

<div class="table-cell ranking worst">
	<h3>Piores</h3>
	<ul>
		<?php 
			foreach ($result['worst'] as $item) {			
		?>
		<li>
			<span class="numero"><?php echo $item["line_id"] ?></span>
			<span class="nome"><?php echo $item["line_info"] ?></span>
			<span class="nota"><?php echo $item["total_value"] ?></span>
		</li>
		<?php 
			}
		?>		
	</ul>
</div>