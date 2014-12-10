<script type="text/javascript" src="<?php echo $patheditor ?>/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $patheditor ?>/adapters/jquery.js"></script>
<script>
$(document).ready(function()
{
  <?php if (is_array($multy)) :?>
      <?php foreach ($multy as $form) : ?>
      $('<?php echo ((isset($form['class'])) ? '.'.$form['class'] : 'textarea')?>').ckeditor( <?php echo $form['params'] ?>);
      <?php endforeach ?>
  <?php else : ?>
      $('<?php echo ($class) ? '.'.$class : 'textarea'?>').ckeditor( <?php echo $params ?>);
  <?php endif ?> 
    
});

</script>