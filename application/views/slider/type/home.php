<li class="it-slider">
      <div class="img">
         <!-- <img src="<?php echo $slide->image ?>" alt="<?php echo $slide->title ?>" />-->
          <?php echo $slide->image->Render('small') ?>
      </div>
      <div class="content">
            <h4><?php echo $slide->title ?></h4>
            <p><?php echo $slide->description ?></p>
        <a href="<?php echo $slide->url() ?>" title="<?php echo $slide->title ?>" class="it-button">Подробнее</a>    
    </div>
</li>