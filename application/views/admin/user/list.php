<h1>Пользователи</h1>
<?php if ($users) : ?>
   <div class="sort">
        <?php $sort_field = array() ?> 
        <?php foreach($sort_field as $field) : ?>
            <div class="field">
              <a href="<?php echo $field->url() ?>" title=""></a>  <?php echo $field['name'] ?>
            </div>
        <?php endforeach ?>
   </div>
   <div class="right">
    	<!--<a href="/admin/user/order" class="ico ok text hidden" id="order-update">Сохранить</a>-->
    	<a href="/admin/user/add" class="ico add text">Добавить пользователя</a>
    </div>
   <table class="table">
        <thead>
            <tr>
                <th>Логин - ИД БК</th>
                <th>ФИО</th>
                <th>E-mail</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Дата регистрации</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($users as $user) : ?>
        		<tr class="item">
        		        <td><?php echo $user->login ?></td>
                        <td><?php echo $user->name ?></td>
                        <td><?php echo $user->email ?></td>
                        <td><?php echo $user->phone ?></td>
                        <td><?php echo $user->address ?></td>
                        <td><?php echo date("d.m.Y H:i:s", $user->created) ?></td>
                        <td>
                           
                           <?php foreach($user->roles->find_all() as $role): ?>
                              <?php //print_r($role->as_array()) ?>
                              <?php echo(' '.$role->name) ?>
                           <?php endforeach ?>
                        </td>
                        <td class="actions">
        					<a href="<?php echo $user->url_admin('edit') ?>" class="ico edit" title="Редактировать"></a>
        					<a href="<?php echo $user->url_admin('toggle') ?>" class="ico hide" title="Видимость"></a>
        					<a href="<?php echo $user->url_admin('delete') ?>" class="ico del" title="Удалить"></a>
                        </td>	
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>