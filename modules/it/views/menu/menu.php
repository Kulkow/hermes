<menu>
	<?php foreach ($menu as $item) : ?>
		<li<?php echo $item->get_css_class() ?>>
            <? if(Menu::$current == $item->url): ?>
			<span><?php echo $item->title ?></span>
            <? else : ?>
            <a href="<?php echo $item->url ?>" title="<?php echo $item->title ?>"><span><?php echo $item->title ?></span></a>
            <? endif ?>
		</li>
	<?php endforeach ?>
</menu>