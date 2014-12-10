<h1>Пользователи</h1>
<div class="search form">
  <form action="" accept-charset="UTF-8" method="POST">
            <div class="it-row">
              <label for="it-field">Поле </label>
               <div class="it-select" id="it-field">
                    <select name="field">
                       <option value="login" <?php echo ($search_field == 'login' ? 'selected="selected"' : '') ?>><?php echo t('auth.login') ?></option>
                       <option value="email" <?php echo ($search_field == 'email' ? 'selected="selected"' : '') ?>><?php echo t('auth.email') ?></option>
                       <option value="phone" <?php echo ($search_field == 'phone' ? 'selected="selected"' : '') ?>><?php echo t('auth.phone') ?></option>
                       <option value="name" <?php echo ($search_field == 'name' ? 'selected="selected"' : '') ?>><?php echo t('auth.name') ?></option>
                    </select>
                </div>
            </div>
            <div class="it-row">
                <label for="it-search">Поиск</label>
                <div class="it-text">
                    <input type="text" id="it-search" name="search" value="<?php echo $search ?>" />
                </div>
            </div>
            <div class="it-row last">
                <button class="it-button" value="1" name="send">Поиск</button>
            </div>
        </form>
</div>
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
                <th>Дата регистрации/добавления(активация)</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <?php if ($users) : ?>
        <tbody>
        	<?php foreach ($users as $user) : ?>
        		<tr class="item">
        		        <td><?php echo $user->login ?></td>
                        <td><?php echo $user->name ?></td>
                        <td><?php echo $user->email ?></td>
                        <td><?php echo $user->phone ?></td>
                        <td><?php echo $user->address ?></td>
                        <td>
                           <?php if(intval($user->active_time) > 0 AND intval($user->active_time) > time()) : ?>
                             <b>Активируется</b>:<?php echo date("d.m.Y H:i:s", $user->active_time) ?>
                           <?php else : ?>
                                <?php echo date("d.m.Y H:i:s", $user->created) ?>
                           <?php endif ?>
                        </td>
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
        <?php endif ?>
    </table>
	<?php echo $paging ?>
<style>
 .search.form {position: relative; overflow: hidden;}
 .search.form .it-row {float: left; width: 350px; clear: none; margin-right: 15px;}
 .search.form .it-row.last {padding-top: 20px;}
</style>