<?php include('header.php'); ?>

<?php if (isset($NoEntries)) { ?>
<div class="entry">
	<h2>Atención</h2>
	<p>Este blog no tiene nada publicado aún, vuelve más tarde.</p>
</div>
<?php } else { ?>
	<?php for ($c = 0; $c <= $totalFor; $c++) { ?>
		<?php if ($rows[$c][5] == 'y') { ?>
		<div class="minientry">
			<?php echo $rows[$c][3]; ?>
			<br /><span class="s_continue"><a href="<?php echo _u('e', $rows[$c][0], $rows[$c][1]); ?>#comentarios">Comentarios (<?php echo $rows[$c][9]; ?>)</a></span>
		</div>
		<?php } else { ?>
		<div class="entry">
			<h2><a href="<?php echo _u('e', $rows[$c][0], $rows[$c][1]); ?>"><?php echo $rows[$c][2]; ?></a></h2>
			<span class="s_date"><?php echo _d('j F Y', $rows[$c][4]); ?></span>
			<?php if ($rows[$c][7] == 'y' || ($rows[$c][7] == 'c' && $rows[$c][9] != 0)) { ?>
			 <span class="s_comments"><a href="<?php echo _u('e', $rows[$c][0], $rows[$c][1]); ?>#comentarios"><?php echo ($rows[$c][9] == 0) ? 'Sin comentarios' : "{$rows[$c][9]} Comentario(s)"?></a></span>
			<?php } ?>
			<?php if ($rows[$c][7] == 'y') { ?>
			 <span class="s_comment"><a href="<?php echo _u('e', $rows[$c][0], $rows[$c][1]); ?>#comentar">Comentar</a></span>
			<?php } ?>
			<p><?php echo $part[$c][0]; ?></p>
			<?php if (isset($part[$c][1])) { ?>
			<span class="s_continue"><a href="<?php echo _u('e', $rows[$c][0], $rows[$c][1]); ?>#continuar">Continuar leyendo...</a></span>
			<?php } ?>
		</div>
		<?php } ?>
	<?php } ?>
	<?php if ($pages) { ?>
		<div class="pagination">
		<?php echo (in_array(1, $pages)) ? '' : '<a href="'._u('a', 1).'">&lt;&lt;</a>'; ?>
		<?php foreach ($pages as $c) { ?>
			<?php echo ($c != $page) ? '<a href="'._u('a', $c).'">'.$c.'</a>' : '<span class="current">'.$c.'</span>'; ?>
		<?php } ?>
		<?php echo (in_array($totalPages, $pages)) ? '' : '<a href="'._u('a', $totalPages).'">&gt;&gt;</a>'; ?>
		</div>
	<?php } ?>
<?php } ?>

<?php include('footer.php'); ?>