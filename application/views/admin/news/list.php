<h1>Новости</h1>
   <div class="sort">
        <?php $sort_field = array() ?> 
        <?php foreach($sort_field as $field) : ?>
            <div class="field">
              <a href="<?php echo $field->url() ?>" title=""></a>  <?php echo $field['name'] ?>
            </div>
        <?php endforeach ?>
   </div>
   <div class="right">
    	<a href="/admin/news/add" class="ico add text">Добавить новость</a>
    </div>
<?php if ($news) : ?>
   <table class="table">
        <thead>
            <tr>
                <th style="width: 10%;">Дата</th>
                <th>Заголовок</th>
                <th>Ссылка</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($news as $new) : ?>
        		<tr class="item">
                        <td><?php echo date('j F Y, H:i:s', $new->created); ?></td>
        		        <td><div style="width: 150px;overflow: hidden;"><?php echo $new->image->render('small', array('width' => 150)) ?></div>
                        <?php echo $new->name ?></td>
                        <td><a href="<?php echo $new->url() ?>" title="<?php echo $new->title ?>"><?php echo $new->url() ?></a></td>
                        <td class="actions">
        					<a href="<?php echo $new->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
        					<a href="<?php echo $new->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>