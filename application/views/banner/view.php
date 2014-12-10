<link rel="stylesheet" href="<?php  echo Site::url('/media/css/banner.css') ?>" />
<section id="banners">
    <?php $index = 0; ?>
    <?php foreach($banners as $banner) : ?>
        <?php if($index % 2 == 0) : ?>
            <div class="it-row">
        <?php endif ?>
                 <?php echo View::factory('banner/type/'.($type ? $type : 'home'))->bind('banner',$banner)->bind('index', $index); ?>
       <?php if($index++ % 2 == 1) : ?>
              </div>
        <?php endif ?>
    <?php endforeach ?>
       
</section>