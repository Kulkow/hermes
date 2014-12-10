<h1>Новости</h1>
<?php if ($news) : ?>
<section class="section articles">
        	<?php foreach ($news as $new) : ?>
                <div class="it-article">
                    <time datetime="<? echo date('c', $new->created); ?>" class="time"><? echo date('j m Y, H:i:s', $new->created) ?></time>
                    <? if($new->image->loaded()): ?>
                        <a class="preview" href="<? echo $new->url()?>" title="<? echo $new->title ?>"><?php echo $new->image->render('small', array('width' => 150)) ?></a>
                    <? endif ?>
                    <a class="name" href="<? echo $new->url()?>" title="<? echo $new->title ?>"><? echo $new->name ?></a>
                    <div class="description"><? echo $new->teaser ?></div>
                </div>
        	
        	<?php endforeach ?>
	<?php echo $paging ?>
</section>
<?php endif ?>