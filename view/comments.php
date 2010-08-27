<?php if(COMMENTS_STATUS == 'y' || (COMMENTS_STATUS == 'c' && !isset($NoComments))) { ?>
<hr class="separator" />
<div class="entry">

<a name="comentarios"></a>
<h4>Comentarios</h4>

	<?php if(isset($NoComments)) { ?>
		<p class="m_info">No hay comentarios. ¡Se el primero!</p>
	<?php } ?>

	<?php if(!isset($NoComments)) { ?>
		<?php for($c = 0; $c <= $totalForC; $c++) { ?>
		<div class="comment"><a name="comment-<?php echo $rowsC[$c][3]; ?>"></a>
			<div class="cavatar"><img src="http://www.gravatar.com/avatar/<?php echo $rowsC[$c][5]; ?>?s=54&amp;d=<?php echo BASE_STATIC; ?>images/no-avatar.png" alt="" width="54" height="54" /></div>
			<div class="ccontent">
				<div class="cinfo">
				<a href="#comment-<?php echo $rowsC[$c][3]; ?>">#<?php echo $rowsC[$c][3]; ?></a> <b><?php echo (empty($rowsC[$c][6])) ? $rowsC[$c][4] : "<a rel=\"nofollow\" href=\"{$rowsC[$c][6]}\" target=\"_blank\">{$rowsC[$c][4]}</a>"; ?></b> el <?php echo _d('j F Y', $rowsC[$c][8]); ?>.
				<?php if(COMMENTS_STATUS == 'y') { ?> <span class="creply"><a href="#comentar" onclick="javascript:re('<?php echo $rowsC[$c][3]; ?>', '<?php echo $rowsC[$c][4]; ?>')">Responder</a></span><?php } ?>
				</div>
				<p><?php echo $rowsC[$c][7]; ?></p>
			</div>
		</div>
		<?php if($c != count($rowsC)) { ?><!-- <hr /> --><?php } ?>
		<?php } ?>
	<?php } ?>

	<?php if(COMMENTS_STATUS == 'y') { ?>
		<a name="comentar"></a>
		<h4>Comentar</h4>

		<?php if($cMsg == 1) { ?>
		<p class="MsgError">Debes rellenar todos los campos.</p>
		<?php } ?>

		<?php if($cMsg == 2) { ?>
		<p class="MsgError">Se ha producido un error. Probablemente has reenviado por error el formulario.</p>
		<?php } ?>

		<?php if($cMsg == 3) { ?>
		<p class="MsgError">El código de seguridad introducido no es válido. Prueba de nuevo.</p>
		<?php } ?>

		<?php if($cMsg == 4) { ?>
		<p class="MsgError">Se ha producido un error y no se ha podido guardar el comentario. Prueba a enviar el comentario de nuevo.</p>
		<?php } ?>

		<?php if($cMsg == 5) { ?>
		<p class="MsgInfo">El comentario ha sido insertado con éxito.</p>
		<?php } ?>

		<form name="comment" method="post" action="<?php echo $form['action']; ?>#comentar" class="formComment">
		<label for="nick">Nick:</label>
		<input type="text" id="nick" name="nick" value="<?php echo $form['nick']; ?>" /><br />
		<label for="email">Email:</label>
		<input type="text" id="email" name="email" value="<?php echo $form['email']; ?>" />&nbsp;No sera publicado. Para el <a href="http://es.wikipedia.org/wiki/Gravatar" target="_blank">Gravatar</a>.<br />
		<label for="web">Web:</label>
		<input type="text" id="web" name="web" value="<?php echo $form['web']; ?>" />&nbsp;Opcional.<br />
		<label for="content">Comentario:</label>
		<textarea id="content" name="content" cols="50" rows="10"><?php echo $form['content']; ?></textarea><br />
		<label for="captcha">C. seguridad:</label>
		<input type="text" id="captcha" name="captcha" size="10" />&nbsp;<img src="<?php echo $form['captcha']; ?>" alt="" /> Introduce los caracteres de la imagen en el campo.<br />
		<label for="remember">¿Recordarme?</label>
		<input type="checkbox" id="remember" name="remember"<?php echo $form['remember']; ?> />&nbsp;Recordar tus datos para futuras visitas.<br />
		<input type="hidden" name="token" value="<?php echo $form['token']; ?>" />
		<input name="submit" type="submit" value="Enviar" class="fbutton" /><br />
		</form>
	<?php } ?>

</div>
<?php } ?>