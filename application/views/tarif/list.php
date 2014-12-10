<h1>Тарифы</h1>
<?php if ($tarifs) : ?>
<section class="section articles">
        	<?php foreach ($tarifs as $tarif) : ?>
                <div class="it-article">
                    <time datetime="<? echo date('c', $tarif->created); ?>" class="time"><? echo date('j m Y, H:i:s', $tarif->created) ?></time>
                    <a class="name" href="<? echo $tarif->url()?>" title="<? echo $tarif->title ?>"><? echo $tarif->р1 ?></a>
                    <div class="description"><? echo $tarif->description ?></div>
                </div>
        	
        	<?php endforeach ?>
	<?php echo $paging ?>
</section>
<?php endif ?>