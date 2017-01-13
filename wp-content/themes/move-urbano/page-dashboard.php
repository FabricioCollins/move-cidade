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

	$filter_params = "./?"
	."city_name=".$_GET['city_name']
	."&modal_id=".$_GET['modal_id']
	."&limit_count=".$_GET['limit_count'];
		
	$result = $db->get_dashboard_info($_GET['city_name'], $_GET['modal_id'], $_GET['limit_count'], $_GET['sort_column']);
	$cities = $db->get_cities();
	$modals = $db->get_modals();

	$status_column1 = ($_GET['sort_column']=="line_name")? ' active' : '';
	$status_column2 = ($_GET['sort_column']=="line_info")? ' active' : '';
	$status_column3 = ($_GET['sort_column']=="seguranca")? ' active' : '';
	$status_column4 = ($_GET['sort_column']=="urbanidade")? ' active' : '';
	$status_column5 = ($_GET['sort_column']=="limpeza")? ' active' : '';
	$status_column6 = ($_GET['sort_column']=="pontualidade")? ' active' : '';
	$status_column7 = ($_GET['sort_column']=="bilhetagem")? ' active' : '';
	$status_column8 = ($_GET['sort_column']=="frota")? ' active' : '';
	$status_column9 = ($_GET['sort_column']=="total_value")? ' active' : '';

	$db->close();
?>

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
								<option value="<?php echo $city['value'] ?>" <?php echo ($_GET['city_name']==$city)? "selected" : "" ?>>
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
							<option value="">Todos</option>
							<?php 
								foreach ($modals as $modal) {
							?>
								<option value="<?php echo $modal['value'] ?>" <?php echo ($_GET['modal_id']==$modal)? "selected" : "" ?>>
									<?php echo $modal['value'] ?>									
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
						<select class="add-line-field">
							<option value=""></option>
							<?php 
								foreach ($result as $line) {
									$line_data=$line["line_name"].";".
										$line["line_info"].";".
										($line["seguranca"]==null? '-' : $line["seguranca"]).";".
										($line["urbanidade"]==null? '-' : $line["urbanidade"]).";".
										($line["limpeza"]==null? '-' : $line["limpeza"]).";".
										($line["pontualidade"]==null? '-' : $line["pontualidade"]).";".
										($line["bilhetagem"]==null? '-' : $line["bilhetagem"]).";".
										($line["frota"]==null? '-' : $line["frota"]).";".
										($line["total"]==null? '-' : $line["total"]);
							?>
							<option value="<?=$line_data?>"><?=$line["line_name"]?> - <?=$line["line_info"]?></option>
							<?php } ?>				  
						</select>
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
					<th class="nota-title <?php echo $status_column3 ?>"><a href="<?php echo $filter_params . '&sort_column=seguranca' ?>">Segurança</th>
					<th class="nota-title <?php echo $status_column4 ?>"><a href="<?php echo $filter_params . '&sort_column=urbanidade' ?>">Urbanidade</th>
					<th class="nota-title <?php echo $status_column5 ?>"><a href="<?php echo $filter_params . '&sort_column=limpeza' ?>">Limpeza</th>
					<th class="nota-title <?php echo $status_column6 ?>"><a href="<?php echo $filter_params . '&sort_column=pontualidade' ?>">Pontualidade</th>
					<th class="nota-title <?php echo $status_column7 ?>"><a href="<?php echo $filter_params . '&sort_column=bilhetagem' ?>">Bilhetagem</th>
					<th class="nota-title <?php echo $status_column8 ?>"><a href="<?php echo $filter_params . '&sort_column=frota' ?>">Frota</th>
					<th class="nota-title <?php echo $status_column9 ?>"><a href="<?php echo $filter_params . '&sort_column=total_value' ?>">Geral</th>
				</tr>	
				
				<?php 
					foreach ($result as $line) {
				?>			
				<tr>
					<td><?=$line["line_name"]?></td>
					<td><?=$line["line_info"]?></td>
					<td class="nota"><?=($line["seguranca"]==null? '-' : $line["seguranca"])?></td>
					<td class="nota"><?=($line["urbanidade"]==null? '-' : $line["urbanidade"])?></td>
					<td class="nota"><?=($line["limpeza"]==null? '-' : $line["limpeza"])?></td>
					<td class="nota"><?=($line["pontualidade"]==null? '-' : $line["pontualidade"])?></td>
					<td class="nota"><?=($line["bilhetagem"]==null? '-' : $line["bilhetagem"])?></td>
					<td class="nota"><?=($line["frota"]==null? '-' : $line["frota"])?></td>
					<td class="nota"><?=($line["total"]==null? '-' : $line["total"])?></td>
				</tr>	
				<?php } ?>

			</table>

			<nav class="pagination paginated clearfix">
				<span class="page-numbers current">1</span>
				<a class="page-numbers" href="javascript:void(0);">2</a>
				<span class="page-numbers dots">…</span>
				<a class="page-numbers" href="javascript:void(0);">4</a>
				<a class="next page-numbers" href="javascript:void(0);">Próxima</a>
			</nav>

		</div>
	</div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>