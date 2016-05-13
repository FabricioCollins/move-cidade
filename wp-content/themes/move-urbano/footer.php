<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>
	
</div><!-- .site -->
<div class="footer">
		<div class="desenho">
			<img src="<?php bloginfo( 'stylesheet_directory' );?>/img/rodape-05.png">
		</div>
		<div class="logotipo section">
			<div class="col span_4_of_12">
				<img src="<?php bloginfo( 'stylesheet_directory' );?>/img/logotipo-ics-branco.png">
			</div>
			<div class="col span_4_of_12">
				<img src="<?php bloginfo( 'stylesheet_directory' );?>/img/logo_web_branco_reduzido.png">
			</div>
			<div class="col span_4_of_12">
				<img src="<?php bloginfo( 'stylesheet_directory' );?>/img/idec_logo_branco.png">
			</div>
		</div>
	</div>

	<div class="cadastro">
		<div class="form-wrapper">
			<h3>Mais mobilidade?</h3>
			<p>Cadastre-se para receber informações sobre outras campanhas do IDEC </p>
			<form>
				<input type="text" value="" placeholder="Digite seu email">
				<input type="submit" value="Cadastrar">
			</form>
		</div>
		<div class="toggle">
			<i class="fa fa-times" aria-hidden="true"></i>
		</div>
	</div>

<?php wp_footer(); ?>
</body>
</html>
