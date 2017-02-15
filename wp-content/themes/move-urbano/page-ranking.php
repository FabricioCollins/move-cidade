<?php
/**
 * Template Name: Ranking
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<?php 
	include_once ('./appinfo/database_access.php');
	$db = new database_access();
	$db->open();

	$limit_rows = 10;

	// Get current page
	$current_page = isset($_GET["current_page"])? $_GET["current_page"] : 0;	
	$page_size = $db->get_ranking_size($_GET['city_name'], $_GET['modal_id'], $limit_rows, $_GET['sort_column']);	

	$filter_params = "./?"
	."city_name=".$_GET['city_name']
	."&modal_id=".$_GET['modal_id']
	."&limit_count=".$_GET['limit_count'];
		
	$result = $db->get_ranking_info($_GET['city_name'], $_GET['modal_id'], $limit_rows, $current_page, $_GET['sort_column']);
	$full_result = $db->get_full_ranking_info();
	$cities = $db->get_cities();
	$modals = $db->get_modals();

	$status_column1 = ($_GET['sort_column']=="line_name")? ' active' : '';
	$status_column2 = ($_GET['sort_column']=="line_info")? ' active' : '';
	$status_column3 = ($_GET['sort_column']=="pontualidade")? ' active' : '';
	$status_column4 = ($_GET['sort_column']=="lotacao")? ' active' : '';
	$status_column5 = ($_GET['sort_column']=="limpeza")? ' active' : '';
	$status_column6 = ($_GET['sort_column']=="transito")? ' active' : '';
	$status_column7 = ($_GET['sort_column']=="motorista")? ' active' : '';
	$status_column8 = ($_GET['sort_column']=="seguranca")? ' active' : '';
	$status_column9 = ($_GET['sort_column']=="geral")? ' active' : '';

	$db->close();
?>

<script type="text/javascript">	
    var availableTags = [
    	<?php
    		foreach ($full_result as $line) {
				$data_value='"' . $line["line_name"]."|".
				$line["line_info"]."|".
				($line["pontualidade"]==null? '-' : $line["pontualidade"])."|".
				($line["lotacao"]==null? '-' : $line["lotacao"])."|".
				($line["limpeza"]==null? '-' : $line["limpeza"])."|".
				($line["transito"]==null? '-' : $line["transito"])."|".
				($line["motorista"]==null? '-' : $line["motorista"])."|".
				($line["seguranca"]==null? '-' : $line["seguranca"])."|".
				($line["geral"]==null? '-' : $line["geral"]). '"';

				$data_label = '"' . $line["line_name"] ." - ". $line["line_info"] . '"';
								
				echo "{"
			    	."label: $data_label,"
			    	."value: $data_value"
			    ."},";
			}
    	?>    	
    ];    

    $( document ).ready(function() {
    	$( "#add-line-field" ).val("");
		$( "#add-line-field" ).autocomplete({
			minLength: 0,
			source: availableTags,			
	      	select: function( event, ui ) {
		    	$( "#add-line-field" ).val( ui.item.label );
				$( "#add-line-hidden" ).val( ui.item.value ); 
		        return false;
			}    
		});


		<?php 
			if($_GET['sort_column']==null) {
				echo "clearComparableRankingLine();";
			}
		?>

	});
</script>

<div id="primary" class="main blog-index content-area">
	<div class="main conteudo">
		
		<div class="ranking">
			<div class="section">
				<h1 class="post-titulo">Ranking</h1>					
			</div>

			<div class="meta"></div>
		
			<form class="filtro">
				<div class="parametro">
					<label class="">Cidade</label>
					<div class="select-wrapper">
						<select class="filter-select" id="city_name">
							<option value="">Todos</option>
							<?php 
								foreach ($cities as $city) {
							?>
								<option value="<?php echo $city['value'] ?>" <?php echo ($_GET['city_name']==$city['value'])? "selected" : "" ?>>
									<?php echo $city['value'] ?>
								</option>

							<?php 
								}
							?>							
						</select>
					</div>
				</div>

				<div class="parametro">
					<label class="">Modal</label>
					<div class="select-wrapper">
						<select class="filter-select" id="modal_id">							
							<?php 
								foreach ($modals as $modal) {
									$selected=($_GET['modal_id']==$modal['value'] || $_GET['modal_id']==null &&  $modal['value']=="onibus")? 
									"selected='selected'" : "";
							?>
								<option value="<?php echo $modal['value'] ?>" <?php echo $selected ?>>
									<?php echo ucfirst(str_replace("_", " ", $modal['value'])) ?>									
								</option>
							<?php 
								}
							?>
						</select>
					</div>
				</div>
			</form>

			<p class="tip">Quer visualizar o ranking por categoria? É só clicar no título da categoria correspondente.</p>

			<div class="comparar comparar-add">
				<div class="add-line-section">
					<label class="table-cell">Adicionar linha para comparação:</label>
					<div class="table-cell input">				
						<input id="add-line-field" placeholder="Digite o número ou nome da linha" type="text">	
						<input type="hidden" id="add-line-hidden">							
					</div>
					<div class="table-cell submit">
						<button class="btn-add-line">Adicionar <i class="fa fa-arrow-down" aria-hidden="true"></i></button>
					</div>
				</form>
			</div>

			<table class="ranking-table">
				<tr class="upper-header">
					<th colspan="2">Ônibus</th>
					<th colspan="7">Nota</th>
				</tr>
				<tr class="lower-header">
					<th class="<?php echo $status_column1 ?>"><a href="<?php echo $filter_params . '&sort_column=line_name' ?>">Número</a></th>
					<th class="<?php echo $status_column2 ?>"><a href="<?php echo $filter_params . '&sort_column=line_info' ?>">Origem/Destino</th>
					<th class="nota-title <?php echo $status_column3 ?>"><a href="<?php echo $filter_params . '&sort_column=pontualidade' ?>">Pontualidade</th>
					<th class="nota-title <?php echo $status_column4 ?>"><a href="<?php echo $filter_params . '&sort_column=lotacao' ?>">Lotação</th>
					<th class="nota-title <?php echo $status_column5 ?>"><a href="<?php echo $filter_params . '&sort_column=limpeza' ?>">Limpeza</th>
					<th class="nota-title <?php echo $status_column6 ?>"><a href="<?php echo $filter_params . '&sort_column=transito' ?>">Trânsito</th>
					<th class="nota-title <?php echo $status_column7 ?>"><a href="<?php echo $filter_params . '&sort_column=motorista' ?>">Motorista</th>
					<th class="nota-title <?php echo $status_column8 ?>"><a href="<?php echo $filter_params . '&sort_column=seguranca' ?>">Segurança</th>
					<th class="nota-title <?php echo $status_column9 ?>"><a href="<?php echo $filter_params . '&sort_column=geral' ?>">Geral</th>
				</tr>	
				
				<?php 
					foreach ($result as $line) {
				?>			
				<tr>
					<td><?=$line["line_name"]?></td>
					<td><?=$line["line_info"]?></td>
					<td class="nota"><?=($line["pontualidade"]==null? '-' : $line["pontualidade"])?></td>
					<td class="nota"><?=($line["lotacao"]==null? '-' : $line["lotacao"])?></td>
					<td class="nota"><?=($line["limpeza"]==null? '-' : $line["limpeza"])?></td>
					<td class="nota"><?=($line["transito"]==null? '-' : $line["transito"])?></td>
					<td class="nota"><?=($line["motorista"]==null? '-' : $line["motorista"])?></td>
					<td class="nota"><?=($line["seguranca"]==null? '-' : $line["seguranca"])?></td>
					<td class="nota"><?=($line["geral"]==null? '-' : $line["geral"])?></td>
				</tr>	
				<?php } ?>

			</table>

			<?php 	
				// Build Pagination							
				$url_pagination = $filter_params 
					. '&sort_column=' . $_GET["sort_column"]
					. '&current_page='; 

				include('./wp-content/themes/move-urbano/template-parts/pagination.php');
			?>			

		</div>
	</div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>