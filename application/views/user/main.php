<div class="user_profile main">
    <h1><?php echo $user->fullname() ?></h1>
    <div class="content">
        <p><?php echo $user->login;  ?></p>
        <p>Баланс: <?php echo $user->balance();  ?>$</p>
        <? if($card->isactive()): ?>
            <p><? echo $income = $card->income(); ?></p>
        <? else: ?>
        <p>Пополните баланс и участвуйте в программе</p>
        <? endif ?>
        <? if($card->tarif->loaded()): ?>
        <p>Текущий тарифный план : <a href="<? echo $card->tarif->url() ?>"><? echo $card->tarif->h1  ?></a></p>
            <? if(! $card->isactive()): ?>
                <a href="<? echo $user->url('start');  ?>">Активировать Тарифный План для начала начисления процентов</a>
            <? endif ?>
        <? endif ?>
        
        <h2>Контакты</h2>
            <ul>
                <li><p>Телефон: <?php echo $user->phone;  ?></p></li>
                <li><p>E-mail: <?php echo $user->email;  ?></p></li>
                <?php if($user->address AND FALSE) : ?>
                    <li><p>Адрес: <?php echo $user->address;  ?></p></li>
                <?php endif ?>
                <?php if($user->vk) : ?>
                    <li><p>Страница в соц. сети: <a href="<?php echo $user->vk;  ?>" title="<?php echo $user->vk;  ?>"><?php echo $user->vk;  ?></a></p></li>
                <?php endif ?>
                <?php if($user->skype) : ?>
                    <li><p class="skype">Skype: <?php echo $user->skype;  ?></p></li>
                <?php endif ?>
            </ul>
    </div>
</div>