<?php
header("Content-Type: text/html; charset=ISO-8859-15");

include_once ('../appinfo/database_access.php');


	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		$db = new database_access();
		$db->open();

		$current_city = $_GET['city_name'];			

		if (isset($_GET['city_name']))
		{			
			$modals = $db->get_modal_ranking($_GET['city_name']);	
		}
		
		$db->close();
	}

?>

<div class="table-cell ranking grade">
	<h3>Meios de transporte</h3>
	<ul>
		<?php 
			foreach ($modals as $modal) {
				$rank = $modal["modal_rank"] * 10;
				$css_class = ($rank > 49)? "good" : "bad";
		?>
		<li>
			<span class="nome"><?php echo ucfirst(str_replace("_", " ", $modal['modal_name'])) ?></span>			
			<span class="nota <?php echo $css_class ?>"><?php echo $modal["modal_rank"] ?></span>
		</li>
		<?php 
			}
		?>		
	</ul>
</div>

<div class="table-cell ranking bars">
	<h3>&nbsp;</h3>
	<ul>
		<?php 
			foreach ($modals as $modal) {
				$modal_name = ucfirst(str_replace("_", " ", $modal["modal_name"]));				
				$value = $modal["modal_rank"];
				$rank = $value * 10;
				$css_class = ($rank > 49)? "good" : "bad";
		?>
		<li>		
			<div class="bar <?php echo $css_class ?>" 
				data-rank="<?php echo $rank ?>%" 
				Title="<?php echo $modal_name . ': ' . $value ?>"></div>
		</li>
		<?php 
			}
		?>		
	</ul>
</div>

<!--<div class="table-cell ranking best">
	<h3>Melhores</h3>
	<ul>
		< ?php 
			foreach ($result['best'] as $item) {			
		?>
		<li>
			<span class="numero">< ?php echo $item["line_id"] ?></span>
			<span class="nome">< ?php echo $item["line_info"] ?></span>
			<span class="nota">< ?php echo $item["total_value"] ?></span>
		</li>
		< ?php 
			}
		?>		
	</ul>
</div>

<div class="table-cell ranking worst">
	<h3>Piores</h3>
	<ul>
		< ?php 
			$wrost = array_reverse($result['worst']);
			foreach ($wrost as $item) {			
		?>
		<li>
			<span class="numero">< ?php echo $item["line_id"] ?></span>
			<span class="nome">< ?php echo $item["line_info"] ?></span>
			<span class="nota">< ?php echo $item["total_value"] ?></span>
		</li>
		< ?php 
			}
		?>		
	</ul>
</div>-->