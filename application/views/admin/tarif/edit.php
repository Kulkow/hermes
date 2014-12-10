<?php if (Arr::get($_REQUEST, 'id')) : ?>
	<h1>Редактирование тарифа &laquo;<?php echo Arr::get($_REQUEST, 'id') ?>&raquo;</h1>
<?php else : ?>
	<h1>Новый тариф</h1>
<?php endif ?>
<? $currencys = ORM::factory('currency')->find_all(); ?>
<form action="" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
     <div class="it-row">
		<label for="h1-id"><?php echo t('tarif.h1') ?></label>
		<div class="it-text"><input type="text" id="h1-id" name="h1" value="<?php echo Arr::get($_REQUEST, 'h1') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'h1')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    
    <? if(FALSE): ?>
    <div class="it-row">
		<label for="image-id"><?php echo t('tarif.image') ?></label>
        <?php $image = ORM::factory('image', intval( Arr::get($_REQUEST, 'image_id'))); ?>
        <?php if($image->loaded()) : ?>
           <div style="width: 150px;overflow: hidden;">
            <?php echo $image->render('small', array('width' => 150)) ?>
           </div>
           <input type="checkbox" id="delete_image-id" name="delete_image" value="<?php echo $image->id ?>" <?php echo (Arr::get($_REQUEST, 'delete_image', null) ? 'checked="checked"' : '') ?>  />
           <label for="delete_image-id">Удалить картинку</label> 
        <?php endif ?>
		<div class="it-text"><input type="file" id="image-id" name="image" value="<?php //echo Arr::get($_REQUEST, 'image') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'image')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <? endif ?>
    <div class="it-row">
		<label for="percent-id"><?php echo t('tarif.percent') ?></label>
		<div class="it-text"><input type="text" id="percent-id" name="percent" value="<?php echo Arr::get($_REQUEST, 'percent') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'percent')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="frost-id"><?php echo t('tarif.frost') ?></label>
		<div class="it-text"><input type="text" id="frost-id" name="frost" value="<?php echo Arr::get($_REQUEST, 'frost') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'frost')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    
    <div class="it-row">
       <div class="row-inline">
            <label for="from_value-id"><?php echo t('tarif.from_value') ?></label>
       </div> 
       <div class="row-inline"> 
    		<div class="it-text"><input type="text" id="from_value-id" name="from_value" value="<?php echo Arr::get($_REQUEST, 'from_value') ?>" /></div>
    		<?php if ($error = Arr::get($errors, 'from_value')) : ?>
    			<div class="it-error"><?php echo $error ?></div>
    		<?php endif ?>
        </div>
       <div class="row-inline">
		  <div class="it-select">
             <? $_currency = Arr::get($_REQUEST, 'from_currency_id'); ?>
              <select name="from_currency_id">
              <? foreach($currencys as $currency): ?>
                    <option value="<? echo $currency->id ?>" <? echo ($currency->id == $_currency ? 'selected': '') ?>><? echo $currency->code ?></option>
              <? endforeach ?>
              </select>
          </div>
       </div>
	</div>
    <div class="it-row">
       <div class="row-inline">
            <label for="to_value-id"><?php echo t('tarif.to_value') ?></label>
       </div> 
       <div class="row-inline"> 
    		<div class="it-text"><input type="text" id="to_value-id" name="to_value" value="<?php echo Arr::get($_REQUEST, 'to_value') ?>" /></div>
    		<?php if ($error = Arr::get($errors, 'to_value')) : ?>
    			<div class="it-error"><?php echo $error ?></div>
    		<?php endif ?>
        </div>
       <div class="row-inline">
		  <div class="it-select">
             <? $_currency = Arr::get($_REQUEST, 'to_currency_id'); ?>
              <select name="to_currency_id">
              <? foreach($currencys as $currency): ?>
                    <option value="<? echo $currency->id ?>" <? echo ($currency->id == $_currency ? 'selected': '') ?>><? echo $currency->code ?></option>
              <? endforeach ?>
              </select>
          </div>
       </div>
       
	</div>
    <div class="it-row">
		<label for="content-id"><?php echo t('tarif.content') ?></label>
		<div class="it-textarea">
            <textarea name="content" rows="15" class="it-editor" id="content-id"><?php echo Arr::get($_REQUEST, 'content') ?></textarea>
        </div>    
		<?php if ($error = Arr::get($errors, 'content')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="code-id"><?php echo t('tarif.code') ?></label>
		<div class="it-text"><input type="text" id="code-id" name="code" value="<?php echo Arr::get($_REQUEST, 'code') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'code')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="title-id"><?php echo t('tarif.title') ?></label>
		<div class="it-text"><input type="text" id="title-id" name="title" value="<?php echo Arr::get($_REQUEST, 'title') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'title')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="keywords-id"><?php echo t('tarif.keywords') ?></label>
		<div class="it-text"><input type="text" id="keywords-id" name="keywords" value="<?php echo Arr::get($_REQUEST, 'keywords') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'keywords')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="description-id"><?php echo t('tarif.description') ?></label>
		<div class="it-text"><input type="text" id="description-id" name="description" value="<?php echo Arr::get($_REQUEST, 'description') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'description')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>
<style>
.row-inline{float: left; margin: 0 15px 0 0; width: 250px;}
</style>
<script type="text/javascript" src="/media/tinymce4/tinymce.min.js"></script>
<?php echo View::factory('tinymce')->set('selector','it-editor') ?>
