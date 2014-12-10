<? if($send): ?>
<p>Сообщение успешно отправлено</p>
<? else: ?>
<h1><? echo $page->content->h1 ?></h1>
<div class="content"><? echo $page->content->content ?></div>
 <form action="<? echo Site::url('feed') ?>" method="POST" class="form">
            <div class="it-row">
                <label for="id-feed-name"><? echo t('feed.name') ?></label>
                <div class="it-text">
                    <input type="text" placeholder="<?  echo t('feed.name') ?>" name="name" value="" />
                </div>
                <?php if ($error = Arr::get($errors, 'name')) : ?>
            			<div class="it-error"><?php echo $error ?></div>
            		<?php endif ?>
            </div> 
            <div class="it-row ">
                    <label for="id-feed-email"><? echo t('feed.email') ?></label>
                    <div class="it-text">
                        <input type="text" placeholder="<?  echo t('feed.email') ?>" name="email" value="" />
                    </div>
                    <?php if ($error = Arr::get($errors, 'email')) : ?>
            			<div class="it-error"><?php echo $error ?></div>
            		<?php endif ?>
             </div>  
             <div class="it-row">
                <label for="id-feed-message"><? echo t('feed.message') ?></label>
                <div class="it-area">
                    <textarea name="message" placeholder="<?  echo t('feed.message') ?>" ></textarea>    
                </div>
                <?php if ($error = Arr::get($errors, 'message')) : ?>
            			<div class="it-error"><?php echo $error ?></div>
            		<?php endif ?>
            </div> 
            <div class="it-row">
                <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
                <button class="it-button a" name="send" value="1">Задать</button>
            </div>
</form>
<? endif ?>