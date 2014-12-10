<? if($page->loaded()): ?>
    <h1><? echo $page->content->h1 ?> </h1>
    <p>Ваша партнерская ссылка: <span><?php echo $user->url_referal();?></span></p>
    <hr />
<? if(! empty($referrals)): ?>
<h2>Ваши приглашенные:</h2>
<table class="table">
    <thead>
        <tr>
            <td><? echo t('user.fio') ?></td>
            <td>доход за все время</td>
        </tr>
    </thead>
    <tbody>
        <? foreach($referrals as $referral): ?>
        <tr>
            <td><? echo $referral['user']->fullname() ?></td>
            <td> <? if(! empty($referral['all_income'])): ?>
                <? echo $referral['card']::summa_format($referral['all_income']).$referral['currency']->render() ?>
                <? else: ?>
                <p>Не активна</p>
                <? endif ?>
            </td>
        </tr>
        <? endforeach ?>
    </tbody>
</table>
<p> </p>
    <div class="content"><? echo $page->content->content ?></div>
<? else: ?>
    <h1>Реферралы</h1>
    <div class="content">Участвуй в нашей программе</div>
<? endif ?>



<? endif ?>