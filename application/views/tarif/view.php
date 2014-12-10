<article class="article">
    <h1><? echo $tarif->h1 ?></h1>
    
    <div class="content">
        <div class="values">
            <p>от <?php echo $tarif->from_value.' '.$tarif->from_currency->render() ?></p>
            <p>до <?php echo $tarif->to_value.' '.$tarif->to_currency->render() ?></p>
            <p>Процент в день: <?php echo $tarif->percent ?>%</p>
            <p>Время заморозки счета <?php echo $tarif->frost ?> дней</p>
        </div>
        <?php echo $tarif->content ?>
    </div>
</article>