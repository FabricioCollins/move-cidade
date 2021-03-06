<?php	
	include_once ('appinfo/database_access.php');
	$db = new database_access();
	$db->open();
	$cities = $db->get_cities();
	$modals = $db->get_modals_by_city($current_city);
	$db->close();

	$default_modal = "onibus";
	$default_city = "São Paulo";
?>

<div class='dashboard-loading'><img src='<?php bloginfo( 'stylesheet_directory' );?>/img/loading-1.gif'></div>
<div class="dashboard">
	<div class="table-cell">
		<h2><a href="./ranking">Ranking</a></h2>
		<a class="pesquisar-linha" href="./ranking">
			<div class="icon"><i class="fa fa-bar-chart" aria-hidden="true"></i></div>
			<div class="text">Ver ranking completo</div>
		</a>
	</div>

	<form class="table-cell dashboard-filter-form">
		<div class="">
			<label class="">Cidade</label>
			<div class="select-wrapper">
				<select class="ds-filter-select" id="city_name">
					<option value="">Todos</option>
					<?php 
						foreach ($cities as $city) {							
							$selected=($_GET['city_name']==$city['value'] || $_GET['city_name']==null &&  $city['value']==$default_city)?
							"selected='selected'" : "";
					?>
						<option value="<?php echo $city['value'] ?>" <?php echo $selected ?>>
							<?php echo $city['value'] ?>						
						</option>
					<?php 
						}
					?>							
				</select>
			</div>
		</div>

		<!--<div class="">
			<label class="">Modal</label>
			<div class="select-wrapper">
				<select class="ds-filter-select" id="modal_id">					
					< ?php 
						foreach ($modals as $modal) {
							$selected=($_GET['modal_id']==$modal['value'] || $_GET['modal_id']==null &&  $modal['value']==$default_modal)? 
							"selected='selected'" : "";
					?>
						<option value="< ?php echo $modal['value'] ?>" < ?php echo $selected ?>>							
							< ?php echo ucfirst(str_replace("_", " ", $modal['value'])) ?>
						</option>
					< ?php 
						}
					?>
				</select>
			</div>
		</div>-->
	</form>

</div>

<script type="text/javascript">
	loadDashboard($("#city_name").val());	
</script>