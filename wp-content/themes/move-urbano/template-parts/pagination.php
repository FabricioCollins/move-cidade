<nav class="pagination paginated clearfix">

	<?php 
		if($current_page > 1) {
			$prev = $current_page-1;
			if($prev >= 1) {
				echo '<a class="next page-numbers" href="'. $url_pagination.$prev .'">Anterior</a>';
				echo '<a class="page-numbers" href="'. $url_pagination.$prev .'">'.$prev.'</a>';
			}					
		}
	?>		

		<span class="page-numbers current"><?=$current_page?></span>	

	<?php 
		if($page_size > 4 && $current_page < $page_size) {
			$curr1 = $current_page+1;				
			echo '<a class="page-numbers" href="'. $url_pagination.$curr1 .'">'.$curr1.'</a>';
			echo '<span class="page-numbers dots">…</span>';
			
		}
	?>	

	<?php 
		if($page_size > 2 && $current_page < $page_size) {		
			$next = $current_page+1;			
			echo '<a class="page-numbers" href="'. $url_pagination.$page_size .'">'.$page_size.'</a>';
			if($next < $page_size) {
			echo '<a class="next page-numbers" href="'. $url_pagination.$next .'">Próxima</a>';
			}
		}
	?>		

</nav>