<h1>Логи</h1>
   <div class="sort">
        <?php $sort_field = array() ?> 
        <?php foreach($sort_field as $field) : ?>
            <div class="field">
              <a href="<?php echo $field->url() ?>" title=""></a>  <?php echo $field['name'] ?>
            </div>
        <?php endforeach ?>
   </div>
<?php if ($logs) : ?>
   <table class="table">
        <thead>
            <tr>
                <th>Дата/время</th>
                <th>Пользователь</th>
                <th>Target</th>
                <th>Действие</th>
                <th>Запрос</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach ($logs as $log) : ?>
        		<tr class="item">
        		        <td><?php echo date("d.m.Y H:i:s", $log->created) ?></td>
                        <td><?php echo ($log->user_id ? $log->user->login : 'guest') ?></td>
                        <td><?php echo $log->target() ?></td>
                        <td><?php echo $log->action ?></td>
                        <td><?php if (! empty($log->content)) : ?>
                            <? echo $log->content ?>
                            <? endif ?>
                        </td>
                        <td><?php echo $log->ip ?></td>
        		</tr>
        	<?php endforeach ?>
        </tbody>
    </table>
	<?php echo $paging ?>
<?php endif ?>