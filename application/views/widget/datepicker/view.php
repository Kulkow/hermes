<?php if(in_array('css', $params)) : ?>
<link rel="stylesheet" type="text/css" href="<?php echo Site::url('/media/widget/'.$name.'/css/style.css'); ?>"  />
<?php endif ?>
<?php if(in_array('js', $params)) : ?>
<script src="<?php echo Site::url('/media/widget/'.$name.'/js/script-lib.js'); ?>" type="text/javascript"></script>
<?php endif ?>
<?php $selector = Arr::get($params, 'selector', NULL); ?>
<script>
    $(function(){
        $('<?php echo ($selector ? $selector : '#datepicker'); ?>').datepicker({ dateFormat: "dd.mm.yy" });
    })
</script>