<?php include('header.php'); ?>

<div class="entry">
<h2>Archivo</h2>
<p>Todas las entradas de este blog ordenadas cronológicamente.</p>

<?php if(isset($NoEntries)) { ?>
	<p class="MsgInfo">Aún no hay entradas que mostrar.</p>
<?php } else { ?>
	<?php for($c = 0; $c <= $totalFor; $c++) { ?>
		<?php if(isset($rows[$c][5])) { ?>
			<b><?php echo _d('F \d\e Y', $rows[$c][3]); ?>:</b>
			<ul>
		<?php } ?>
		<li><a href="<?php echo _u('e', $rows[$c][0], $rows[$c][1]); ?>"><?php echo $rows[$c][2]; ?></a></li>
		<?php if(isset($rows[$c][6])) { ?>
			</ul>
		<?php } ?>
	<?php } ?>
<?php } ?>

</div>

<?php include('footer.php'); ?>