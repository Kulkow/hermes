<?php Slider::render('home') ?>
<section class="section b-grid home">
    <div class="holder">
        <div class="wrapper">    
            <div class="title">Вступайте в <span class="b">Фонд Доверительного Управления Hermes!</span></div>
            <div class="content">
            <? echo $site->content; ?>
            </div>
       </div>     
    </div>
</section>

<section class="section info-blocks">
    <div class="holder">
      <div class="grid-table">
        <div class="grid-row">
            <? $i = 0; foreach($blocks as $block): ?>
            <? $i++; ?> 
            <div class="info-block grid-cell">
               <div class="wrapper">
                    <div class="title"><? echo $block->content->h1; ?></div>
                    <div class="description">
                           <? echo $block->content->teaser; ?>
                             </div>
                    <div class="buttons">
                    <? $url = $block->url(); $class = '';  $b_title = 'Подробнее';
                    if($i == 1){
                        $url = '/about.html';
                    }elseif($i == 2){
                       $class = 'a'; 
                       if(! $auth_user){
                            $b_title = 'Регистрация';
                            $url = '/registr';
                        }else{
                            $b_title = 'Регистрация';
                            $url = '/registr';
                        }
                        
                    }elseif($i == 3){

                       //$b_title = 'Регистрация';
                            $url = '/marketing.html';
} ?>
                        <a class="it-button <? echo $class ?>" title="<? echo $b_title ?>" href="<? echo $url  ?>"><? echo $b_title ?></a>
                     </div>   
               </div> 
            </div>
            <? endforeach ?>
            
          </div>
       </div>
    </div>
</section>