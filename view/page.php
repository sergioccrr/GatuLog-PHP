<?php include('header.php'); ?>

<div class="entry">

<h2><?php echo $row[2]; ?></h2>

<?php if($row[5] != 'n') { ?>
 <span class="s_comments"><a href="<?php echo _u('p', $row[1]); ?>#comentarios"><?php echo ($totalC == 0) ? 'Sin comentarios' : "{$totalC} Comentario(s)"; ?></a></span>
<?php } ?>

<?php if($row[5] == 'y') { ?>
 <span class="s_comment"><a href="<?php echo _u('p', $row[1]); ?>#comentar">Comentar</a></span>
<?php } ?>

<?php if($row[6] == 'y') { ?>
 <span class="s_trackback"><a href="<?php echo _u('te', $row[0], $row[1]); ?>" rel="trackback">Trackback URI</a></span>
<?php } ?>

<p><?php echo $row[3]; ?></p>

</div>

<?php
if(defined('COMMENTS_STATUS')) { require('view/comments.php'); }
if($row[6] == 'y') { require('view/trackbacks.php'); }
?>

<?php include('footer.php'); ?>