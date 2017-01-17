<?php	
	include_once ('appinfo/database_access.php');
	$db = new database_access();
	$db->open();
	$cities = $db->get_cities();
	$modals = $db->get_modals();
	$db->close();
?>

<div class="dashboard">
	<div class="table-cell">
		<h2><a href="./ranking">Ranking</a></h2>
		<a class="pesquisar-linha" href="./ranking">
			<div class="icon"><i class="fa fa-search" aria-hidden="true"></i></div>
			<div class="text">Faça sua pesquisa</div>
		</a>
	</div>

	<form class="table-cell">
		<div class="">
			<label class="">Cidade</label>
			<div class="select-wrapper">
				<select class="ds-filter-select" id="city_name">
					<option value="">Todos</option>
					<?php 
						foreach ($cities as $city) {
							$selected=($_GET['city_name']==$city)? "selected" : "";
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

		<div class="">
			<label class="">Modal</label>
			<div class="select-wrapper">
				<select class="ds-filter-select" id="modal_id">
					<option value="">Todos</option>
					<?php 
						foreach ($modals as $modal) {
							$selected=($_GET['modal_id']==$modal)? "selected" : "";
					?>
						<option value="<?php echo $modal['value'] ?>" <?php echo $selected ?>>
							<?php echo $modal['value'] ?>											
						</option>
					<?php 
						}
					?>
				</select>
			</div>
		</div>
	</form>

	<div id="table-ranking">
		
	</div>

</div>

<script type="text/javascript">
	loadDashboard($("#city_name").val(), $("#modal_id").val());	
</script>