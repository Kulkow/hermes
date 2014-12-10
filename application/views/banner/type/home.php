<div class="banner <?php echo $banner->class ?>  <?php echo($index % 2 == 0 ? 'odd' : 'even') ?>">
    <a href="<?php echo $banner->url() ?>" title="<?php echo $banner->title ?>">
   <!--     <img src="<?php echo $banner->image ?>" alt="<?php echo $banner->title ?>" />-->
        <?php echo $banner->image->render('small') ?>
    </a>
</div>