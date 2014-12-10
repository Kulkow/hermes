<?php if (Arr::get($_REQUEST, 'id')) : ?>
	<h1>Редактирование Слайдера &laquo;<?php echo Arr::get($_REQUEST, 'id') ?>&raquo;</h1>
<?php else : ?>
	<h1>Новый слайдер</h1>
<?php endif ?>
<form action="" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
    <div class="it-row">
		<label for="title-id"><?php echo t('slider.title') ?></label>
		<div class="it-text"><input type="text" id="title-id" name="title" value="<?php echo Arr::get($_REQUEST, 'title') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'title')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
		<label for="url-id"><?php echo t('slider.url') ?></label>
		<div class="it-text"><input type="text" id="url-id" name="url" value="<?php echo Arr::get($_REQUEST, 'url') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'url')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="image-id"><?php echo t('banner.image') ?></label>
        <?php $image = ORM::factory('image', intval( Arr::get($_REQUEST, 'image_id'))); ?>
        <?php if($image->loaded()) : ?>
           <div style="width: 150px;overflow: hidden;">
            <?php echo $image->render('small', array('width' => 150)) ?>
           </div>
           <input type="checkbox" id="delete_image-id" name="delete_image" value="<?php echo $image->id ?>" <?php echo (Arr::get($_REQUEST, 'delete_image', null) ? 'checked="checked"' : '') ?>  />
           <label for="delete_image-id">Удалить картинку</label> 
        <?php endif ?>
		<div class="it-text"><input type="file" id="image-id" name="image" value="<?php echo Arr::get($_REQUEST, 'image') ?>" /></div>
		<?php if ($error = Arr::get($errors, 'image')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
    <div class="it-row">
		<label for="description-id"><?php echo t('slider.description') ?></label>
		<div class="it-textarea">
            <textarea name="description" rows="15" class="it-editor" id="description-id"><?php echo Arr::get($_REQUEST, 'description') ?></textarea>
        </div>    
		<?php if ($error = Arr::get($errors, 'description')) : ?>
			<div class="it-error"><?php echo $error ?></div>
		<?php endif ?>
	</div>
	<div class="it-row">
        <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
		<button type="submit" name="submit" value="1" class="it-button">Сохранить</button>
	</div>
</form>
<script type="text/javascript" src="/media/tinymce4/tinymce.min.js"></script>
<?php echo View::factory('tinymce')->set('selector','it-editor') ?>