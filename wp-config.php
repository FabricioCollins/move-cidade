<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'move');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'rootroot');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '>>@;*dOQixXBKau^g|VGb{ZUspMeT32jM`|@VuU4KCE=C_39A~[`%[Tivw:yiX[e');
define('SECURE_AUTH_KEY',  'z:EK,4{/jqum|gA{8MSlLz 3`2%2fb,BqJ)ZspY;Lo+W)1WIG-#9HoOt5?PQH9e ');
define('LOGGED_IN_KEY',    '2SvKnb#+8B:-IpizB&X8Ql;GZT<ABgJT=:GsT::my7-sXPYJh)FJO6H_x=j}ZZ@E');
define('NONCE_KEY',        'N~{1_0bKo/Ls,kF}VommAf%D:$D-|aGtpFY;tV9>I=q}l06l2,j|f:t(f;x8oXm|');
define('AUTH_SALT',        'xN.U][:hi_K5y!p8f+Y!JpPPEUkyMzD;BShyqv9*I5VVan-x|<Jb7ce_$gkTUE_|');
define('SECURE_AUTH_SALT', '`_+>Q{HH1]NoE)%sg1ViXxQ@T pht)yLDa{d/ $+8n PK>0(93>.XfP-R{w /E`s');
define('LOGGED_IN_SALT',   'Oa5u<YffV*3H%+`/BH_[Rl>s-j>(nV*C`lNMQ7w+L*^3)t6gAN}QwN`^B~Ag_Xq2');
define('NONCE_SALT',       'KDqe{.(QL5P69x,VUZs2Mf3Wp@^{VRiKFLv:*8r/Q{bh/-N;x>t^0<[`|~Y!*oa1');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'mv_';


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
