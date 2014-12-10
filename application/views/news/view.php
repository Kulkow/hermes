<article class="article">
    <h1><? echo $new->h1 ?></h1>
    <time datetime="<? echo date('c', $new->created); ?>" class="time"><? echo date('j m Y, H:i:s', $new->created) ?></time>
    <? if($new->image->loaded()): ?>
        <div class="preview"><?php echo $new->image->render('small', array('width' => 150)) ?></div>
    <? endif ?>
    <div class="content">
        <?php echo $new->content ?>
    </div>
</article>