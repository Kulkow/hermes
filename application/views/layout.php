<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
    <title><?php echo ($site->title ? $site->title : $site->name) ?></title>
	<meta name="keywords" content="<?php echo $site->keywords ?>" />
	<meta name="description" content="<?php echo $site->description ?>" />
     <link rel="icon" href="/media/images/favicon.ico" type="image/x-icon" />
	<!--[if lte IE 8]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="<?php echo URL::site('media/css/reset.css') ?>" />
	<link rel="stylesheet" href="<?php echo URL::site('media/css/style.css') ?>" />
    <link rel="stylesheet" href="<?php echo URL::site('media/css/forms.css') ?>" />
	<script type="text/javascript" src="<?php echo URL::site('/media/js/jquery-2.0.3.min.js')?> "></script>
    <script type="text/javascript" src="<?php echo URL::site('/media/js/script.js')?> "></script>
</head>
<body>
<div id="container">
  <div id="wrapper">
    <header id="header">
      <div class="holder">
          <div class="w">
                   <div class="logo">
                        <a href="<?php echo URL::site('/')?>" title="<?php echo $site->name ?>"></a>
                   </div>
                   <div class="center">
                            
                   </div>
                   <div class="r">
                       <div class="wrapper"> 
                            <div class="faq"><a href="<? echo URL::site('faq.html') ?>" title="faq">FAQ</a> </div>
                            <div class="private">
                                <?php if(! $auth_user): ?>
                                    <ul class="nav">
                                        <li><a href="<?php echo URL::site('login') ?>" title="<? echo t('auth.signin') ?>"><? echo t('auth.signin') ?></a></li>
                                    </ul>
                                <?php else: ?>
                                    <ul class="nav">
                                        <li><a href="<?php echo $auth_user->url() ?>" title="<? echo t('auth.private') ?>"><? echo t('auth.private') ?></a></li>
                                        <li class="logout"><a href="<?php echo URL::site('logout') ?>" title="<? echo t('auth.logout') ?>"><? echo t('auth.logout') ?></a></li>
                                    </ul>
                                <?php endif  ?>
                            </div>
                        </div>
                        <div class="social">
                            <a href="skype:?chat&blob=YIShr_mT6Vl3ehOAZIvqlcftSY4qGyUAVw0QDtXtYm0_PNTr1YBVitVbBUta5fOtgHV09r4pwfSNLHpdkKLG" title="<? echo t('site.skype') ?>" class="skype"></a>
                            <a href="https://vk.com/hermes_inv" title="<? echo t('site.vk') ?>" class="vk" rel="nofollow" target="_blank"></a>
                        </div>
                   </div>
               </div>    
               <nav class="menu">
                   <?php echo Menu::render('home') ?>
               </nav>
           </div>
     </header>  
        <div id="content"  <?php echo (! $sidebar ? 'class="full"' : ''); ?> >
           <div id="holder" <?php echo (! $sidebar ? 'class="full"' : ''); ?> >
               <div id="page" <?php echo (! $sidebar ? 'class="full"' : ''); ?> >
              <? if(Menu::$current !== 'home' AND ! $sidebar): ?>
                    <div class="holder b">
              <? endif ?>  
              <?php if (isset($exception)) : ?>
						<h3><?php echo t('error.'.$exception.'.title') ?></h3>
						<div class="block content">
							<?php echo t('error.'.$exception.'.content') ?>
						</div>
						<div class="links">
							<a href="<?php echo URL::site() ?>"><?php echo t('site.go.home') ?></a>
							<a href="javascript:history.go(-1)"><?php echo t('site.go.back') ?></a>
						</div>
					<?php else : ?>
						<?php echo Message::render() ?>
						<?php echo $content ?>
					<?php endif ?>
                    <? if(Menu::$current !== 'home' AND ! $sidebar): ?>
                        </div>
                    <? endif ?>  
               </div>
           </div>
           <?php if($sidebar) : ?>
              <?php echo View::factory('sidebar'); ?>
        <?php endif ?>
        
    </div>
 </div>
</div>
<footer id="footer">
   <div class="wrapper">
    <div class="feed">
        <div class="title"><? echo t('feed.title') ?></div>
        <form action="<? echo Site::url('feed') ?>" method="POST" class="form">
            <div class="it-row w50">
                <div class="inline">
                    <label for="id-feed-email"><? echo t('feed.email') ?></label>
                    <div class="it-text">
                        <input type="text" placeholder="<?  echo t('feed.email') ?>" name="email" value="" />
                    </div>
                </div>
                <div class="inline r">
                    <label for="id-feed-name"><? echo t('feed.name') ?></label>
                    <div class="it-text">
                        <input type="text" placeholder="<?  echo t('feed.name') ?>" name="name" value="" />
                    </div>
                </div>
             </div>  
            <div class="it-row w100">
                <label for="id-feed-message"><? echo t('feed.message') ?></label>
                <div class="it-area">
                    <textarea name="message" placeholder="<?  echo t('feed.message') ?>" ></textarea>    
                </div>
            </div>   
            <div class="it-row">
                <input type="hidden" name="token" value="<?php echo Security::token() ?>" />
                <button class="it-button a" name="send" value="1">Задать вопрос</button>
            </div>
        </form>
    </div>
   </div>
   <div class="bottom">
   <div class="wrapper">
       <div class="copyright">
           <p>&copy; <? echo date('Y') ?> Hermes</p> 
           <span> Все права защищены.</span>
       </div>
     </div>  
   </div>    
</footer>
<? echo View::factory('metrika') ?>
</body>
</html>