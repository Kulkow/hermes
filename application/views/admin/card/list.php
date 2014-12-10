<h1>Пользователи</h1>
<div class="right">
    	<a href="/admin/user/add" class="ico add text">Добавить карту</a>
    </div>
<?php if ($cards) : ?>
   <div class="sort">
        <?php $sort_field = array() ?> 
        <?php foreach($sort_field as $field) : ?>
            <div class="field">
              <a href="<?php echo $field->url() ?>" title=""></a>  <?php echo $field['name'] ?>
            </div>
        <?php endforeach ?>
   </div>
   <table class="table">
        <thead>
            <tr>
                <th>номер</th>
                <th>Владелец</th>
                <th>Баланс</th>
                <th>Активность</th>
                <th>Тариф</th>
                <th>Посленее действие</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($cards as $card) : ?>
        		<tr class="item <?php echo $card->active ? '' : 'hide' ?>">
        		        <td><?php echo $card->code ?></td>
                        <td><?php echo $card->user->fullname() ?></td>
                        <td><?php echo $card->ball.' '.$card->currency->render(); ?> -<?php echo $card->percent ?>%</td>
                        <td><?php echo $card->active() ?></td>
                        <td><?php echo $card->_tarif() ?></td>
                        <td><?php echo ($card->last_event ? $card->last_event(1) : t('event.null')) ?></td>
                        <td class="actions">
        					<a href="<?php echo $card->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
        					<a href="<?php echo $card->url_admin('toggle') ?>" class="ico hide" title="<?php echo $card->active ? 'Активна' : 'Не активна' ?>"></a>
        					<a href="<?php echo $card->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>