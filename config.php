<?php
/*
 *		scromega blog CMS
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

# === Timezone ===
date_default_timezone_set('Europe/Madrid');

# === MySQL ===
define('DB_HOST', 'localhost');	# Servidor
define('DB_USER', 'root');	# Usuario
define('DB_PASSWORD', 'pass');	# Contraseña
define('DB_NAME', 'blog');	# Base de datos
define('DB_PREFIX', '');	# Prefijo tablas - Dejar en blanco si no se va a usar

# === General ===
define('TITLE', 'scromega blog CMS');	# Titulo
define('S_TITLE', ' :: ');	# Separador titulo
define('DESCRIPTION', 'Blog de prueba.');	# Descripción
define('BASE', 'http://domain.com/');	# URL base - Con barra (/) al final
define('BASE_STATIC', 'http://domain.com/static/');	# URL base de los archivos estáticos - Con barra (/) al final
define('REWRITE', 'On');	# Mod Rewrite - Activado: On - Desactivado: Off

# === Paginación ===
define('P_LIMIT', 4);	# Entradas por pagina
define('P_RANGE', 2);	# Rango del paginador