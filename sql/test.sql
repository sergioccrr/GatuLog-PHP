--
-- scromega blog CMS
-- Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
--
-- Test Data
--

INSERT INTO `comments` VALUES (1, 1, 'p', 1, 'scromega', 'scr.omega@gmail.com', 'http://scromega.net', 'Esto es un comentario de prueba :)', 1266277975, '127.0.0.1', 'Mozilla/5.0 (X11; U; Linux i686; en-US) AppleWebKit/532.5 (KHTML, like Gecko) Chrome/4.0.249.43 Safari/532.5', 'n');

INSERT INTO `entries` VALUES (1, 'hola-mundo', '¡Hola Mundo!', 'Ésta es una entrada de prueba. Puedes editarla o borrarla.', 1266278299, 'n', 'v', 'y', 'y');

INSERT INTO `pages` VALUES (1, 'acerca-de', 'Acerca de...', 'Ésta es una página de prueba. Puedes editarla o borrarla.', 'v', 'y', 'y');
