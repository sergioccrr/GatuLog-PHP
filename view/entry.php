<?php include('header.php'); ?>

<div class="entry">

<h2><?php echo $row[2]; ?></h2>
<span class="s_date"><?php echo _d('j F Y', $row[4]); ?></span>

<?php if($row[7] != 'n' && 1==3) { ?>
 <span class="s_comments"><a href="<?php echo _u('e', $row[0], $row[1]); ?>#comentarios"><?php echo ($totalC == 0) ? 'Sin comentarios' : "{$totalC} Comentario(s)"; ?></a></span>
<?php } ?>

<?php if($row[7] == 'y') { ?>
 <span class="s_comment"><a href="<?php echo _u('e', $row[0], $row[1]); ?>#comentar">Comentar</a></span>
<?php } ?>

<?php if($row[8] == 'y') { ?>
 <span class="s_trackback"><a href="<?php echo _u('te', $row[0], $row[1]); ?>" rel="trackback">Trackback URI</a></span>
<?php } ?>

<p><?php echo $part[0]; ?></p>

<?php if(isset($part[1])) { ?>
<a name="continuar"></a>
<p><?php echo $part[1]; ?></p>
<?php } ?>

</div>

<?php if(defined('COMMENTS_STATUS')) { require('view/comments.php'); } ?>

<?php include('footer.php'); ?>