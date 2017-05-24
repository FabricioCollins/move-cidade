<div class="criteria-graph container">
	<div class="criteria-graph content" id="internal-criteria-graph-01">
		<div class="graph-header">
			<div class="graph-column">
				<span>Pontualidade</span>
			</div>
			<div class="graph-column">
				<span>Lotação</span>
			</div>
			<div class="graph-column">
				<span>Limpeza</span>
			</div>
			<div class="graph-column">
				<span>Trânsito</span>
			</div>
			<div class="graph-column">
				<span>Motorista</span>
			</div>
			<div class="graph-column">
				<span>Segurança</span>
			</div>
			<div class="graph-column">
				<span>Geral</span>
			</div>
		</div>

		<div class="graph-body">
			<div class="graph-column">
				<div class="graph-bar" id="pontualidade">
					<div class="graph-bar-level" data-criteria="<?=$pontualidade_avg_percent ?>"></div>
				</div>
			</div>
			<div class="graph-column">
				<div class="graph-bar" id="lotacao">
					<div class="graph-bar-level" data-criteria="<?=$lotacao_avg_percent ?>"></div>
				</div>
			</div>
			<div class="graph-column">
				<div class="graph-bar" id="limpeza">
					<div class="graph-bar-level" data-criteria="<?=$limpeza_avg_percent ?>"></div>
				</div>
			</div>
			<div class="graph-column">
				<div class="graph-bar" id="transito">
					<div class="graph-bar-level" data-criteria="<?=$transito_avg_percent ?>"></div>
				</div>
			</div>
			<div class="graph-column">
				<div class="graph-bar" id="motorista">
					<div class="graph-bar-level" data-criteria="<?=$motorista_avg_percent ?>"></div>
				</div>
			</div>
			<div class="graph-column">
				<div class="graph-bar" id="seguranca">
					<div class="graph-bar-level" data-criteria="<?=$seguranca_avg_percent ?>"></div>
				</div>
			</div>
			<div class="graph-column">
				<div class="graph-bar" id="geral">
					<div class="graph-bar-level" data-criteria="<?=$geral_avg_percent ?>"></div>
				</div>
			</div>			
		</div>
	</div>
</div>