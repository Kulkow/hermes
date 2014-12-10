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
    	<a href="/admin/tarif/add" class="ico add text">Добавить тариф</a>
    </div>
<?php if ($tarifs) : ?>
   <table class="table">
        <thead>
            <tr>
                <th style="width: 10%;">Дата</th>
                <th>Заголовок</th>
                <th>Процент</th>
                <th>тариф</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($tarifs as $tarif) : ?>
        		<tr class="item">
                        <td><?php echo date('j F Y, H:i:s', $tarif->created); ?></td>
                        <td><a href="<?php echo $tarif->url() ?>" title="<?php echo $tarif->title ?>"><?php echo $tarif->h1 ?></a></td>
                        <td><?php echo $tarif->percent.'% - Заморозка '.$tarif->frost ?> дней</td>
                        <td><?php echo $tarif->render() ?></td>
                        <td class="actions">
        					<a href="<?php echo $tarif->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
        					<a href="<?php echo $tarif->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>