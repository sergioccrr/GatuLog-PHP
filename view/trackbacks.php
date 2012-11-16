<?php if (!empty($rowsT)) { ?>
<hr class="separator" />
<div class="entry">

<h4>Trackbacks</h4>

<?php for ($c = 0; $c <= $totalForT; $c++) { ?>
<div class="trackback"><a name="comment-<?php echo $rowsT[$c][0]; ?>"></a>
	<div class="ccontent">
		<div class="cinfo"><b><a rel="nofollow" href="<?php echo $rowsT[$c][4]; ?>" target="_blank"><?php echo $rowsT[$c][5]; ?></a></b> el <?php echo _d('j F Y', $rowsT[$c][7]); ?>.</div>
		<p><b><?php echo $rowsT[$c][3]; ?></b><br />
		<?php echo $rowsT[$c][6]; ?></p>
	</div>
</div>
<?php if ($c != count($rowsT)) { ?><!-- <hr /> --><?php } ?>
<?php } ?>

</div>
<?php } ?>