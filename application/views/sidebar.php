<aside id="sidebar"> 
    <div class="title">Личный кабинет</div>
    <nav class="nav">
    <?php // Menu::render('left') ?>
      <ul>
        <li class="item balance <?php echo ($side_menu == '' ? 'active' : '') ?>" >
            <a href="<?php echo $user->url() ?>" title="Баланс"><div class="label">Ваш баланс:</div> <div class="total"><? echo $user->balance() ?><span class="curency">$</span></div></a>
            <? $income = $card->summary_income(); echo $income ? $income : '' ?>
        </li>
        <li class="item <?php echo ($side_menu == 'up' ? 'class="active' : '') ?>" ><a href="<?php echo Site::url('money/up') ?>" title="Пополнение счета">Пополнение счета</a></li>
        <li class="item <?php echo ($side_menu == 'out' ? 'active' : '') ?>" ><a href="<?php echo Site::url('money/out') ?>" title="Вывод средств">Вывод средств</a></li>
        <? if($card->allow('out_percent')): ?>
            <li class="item <?php echo ($side_menu == 'out_percent' ? 'active' : '') ?>" ><a href="<?php echo Site::url('money/out_percent') ?>" title="Вывод процентов">Вывод процентов</a></li>
        <? endif ?>
        <li <?php echo ($side_menu == 'reports' ? 'class="active"' : '') ?> ><a href="<?php echo $user->url('reports') ?>" title="Статистика">Статистика</a></li>
        <li <?php echo ($side_menu == 'referral' ? 'class="active"' : '') ?> ><a href="<?php echo $user->url('referral') ?>" title="Реферальная программа">Реферальная программа</a></li>
        <?php $settings = array('new_password', 'setting', 'profile', 'subscription'); ?>
        <li <?php echo (in_array($side_menu, $settings)  ? 'class="active"' : '') ?> ><a href="<?php echo $user->url('setting') ?>" title="Настройки">Настройки</a></li>
      </ul>
    </nav>
</aside>