<?php defined('SYSPATH') OR die('No direct access allowed.');

class Jevix {

   protected static $oJevix;

   protected $cJevix;

    public static function instance($type = 'guest', $bClear = TRUE)
    {
        if (Jevix::$oJevix === NULL)
        {
            if ( ! class_exists('cJevix', FALSE))
    		{
    			require Kohana::find_file('vendors', 'jevix/jevix.class');
    		}

            Jevix::$oJevix = new Jevix();
            $parse = Jevix::$oJevix->cJevix = new cJevix();

            if ($bClear) {
    			$parse->tagsRules=array();
    		}

            $aConfig = Kohana::$config->load('jevix')->get($type);

    		if (is_array($aConfig)) {
    			foreach ($aConfig as $sMethod => $aExec) {
    				foreach ($aExec as $aParams) {
    					if (in_array(strtolower($sMethod),array_map("strtolower",array('cfgSetTagCallbackFull','cfgSetTagCallback')))) {
    						if (isset($aParams[1][0]) and $aParams[1][0]=='_this_') {
    							$aParams[1][0] = Jevix::$oJevix;
    						}
    					}
                        call_user_func_array(array($parse,$sMethod), $aParams);
    				}
    			}
    			/**
    			 * Хардкодим некоторые параметры
    			 */
    			unset($parse->entities1['&']); // разрешаем в параметрах символ &

                /*if (Config::Get('view.noindex') and isset($this->oJevix->tagsRules['a'])) {
    				$this->oJevix->cfgSetTagParamDefault('a','rel','nofollow',true);
    			}*/
    		}
        }
        return Jevix::$oJevix;
    }
    
    
    protected function parse_img_src($src)
    {
        $main_domain = "teenterra.ip-test.info"; 
        if (preg_match('/:\/\//i',$src,$match))
        {
            $explode = explode('://',$src);
            $path = explode('/',$src);$explode[1];
            if ($path[0] !== $main_domain)
            {
               $src = '';  
            }
            //$src = str_replace('',);
        }
       return $src;
    } 

	/**
	 * Парсинг текста с помощью Jevix
	 *
	 * @param string $sText	Исходный текст
	 * @param array $aError	Возвращает список возникших ошибок
	 * @return string
	 */
	public function parsetext($sText,&$aError=null) {

       // Если конфиг пустой, то загружаем его
		if (!count($this->cJevix->tagsRules)) {
			Jevix::instance();
		}
		$sResult=$this->cJevix->parse($sText,$aError);
		return $sResult;
	}
	/**
	 * Парсинг текста на предмет видео
	 * Находит теги <pre><video></video></pre> и реобразовываетих в видео
	 *
	 * @param string $sText	Исходный текст
	 * @return string
	 */
	public function VideoParser($sText) {
		/**
		 * youtube.com
		 */
		$sText = preg_replace('/<video>http:\/\/(?:www\.|)youtube\.com\/watch\?v=([a-zA-Z0-9_\-]+)(&.+)?<\/video>/Ui', '<iframe width="560" height="315" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>', $sText);
		/**
		 * vimeo.com
		 */
		$sText = preg_replace('/<video>http:\/\/(?:www\.|)vimeo\.com\/(\d+).*<\/video>/i', '<iframe src="http://player.vimeo.com/video/$1" width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>', $sText);
		/**
		 * rutube.ru
		 */
		$sText = preg_replace('/<video>http:\/\/(?:www\.|)rutube\.ru\/tracks\/(\d+)\.html.*<\/video>/Ui', '<OBJECT width="470" height="353"><PARAM name="movie" value="http://video.rutube.ru/$1"></PARAM><PARAM name="wmode" value="window"></PARAM><PARAM name="allowFullScreen" value="true"></PARAM><EMBED src="http://video.rutube.ru/$1" type="application/x-shockwave-flash" wmode="window" width="470" height="353" allowFullScreen="true" ></EMBED></OBJECT>', $sText);
		/**
		 * video.yandex.ru
		 */
		$sText = preg_replace('/<video>http:\/\/video\.yandex\.ru\/users\/([a-zA-Z0-9_\-]+)\/view\/(\d+).*<\/video>/i', '<object width="467" height="345"><param name="video" value="http://video.yandex.ru/users/$1/view/$2/get-object-by-url/redirect"></param><param name="allowFullScreen" value="true"></param><param name="scale" value="noscale"></param><embed src="http://video.yandex.ru/users/$1/view/$2/get-object-by-url/redirect" type="application/x-shockwave-flash" width="467" height="345" allowFullScreen="true" scale="noscale" ></embed></object>', $sText);
		return $sText;
	}
	/**
	 * Парсит текст, применя все парсеры
	 *
	 * @param string $sText Исходный текст
	 * @return string
	 */
	public function parse($sText) {
		if (!is_string($sText)) {
			return '';
		}
		$sResult=$this->FlashParamParser($sText);
		$sResult=$this->parsetext($sResult);
		$sResult=$this->VideoParser($sResult);
		$sResult=$this->CodeSourceParser($sResult);
		return $sResult;
	}
	/**
	 * Заменяет все вхождения короткого тега <param/> на длиную версию <param></param>
	 * Заменяет все вхождения короткого тега <embed/> на длиную версию <embed></embed>
	 *
	 * @param string $sText Исходный текст
	 * @return string
	 */
	protected function FlashParamParser($sText) {
		if (preg_match_all("@(<\s*param\s*name\s*=\s*(?:\"|').*(?:\"|')\s*value\s*=\s*(?:\"|').*(?:\"|'))\s*/?\s*>(?!</param>)@Ui",$sText,$aMatch)) {
			foreach ($aMatch[1] as $key => $str) {
				$str_new=$str.'></param>';
				$sText=str_replace($aMatch[0][$key],$str_new,$sText);
			}
		}
		if (preg_match_all("@(<\s*embed\s*.*)\s*/?\s*>(?!</embed>)@Ui",$sText,$aMatch)) {
			foreach ($aMatch[1] as $key => $str) {
				$str_new=$str.'></embed>';
				$sText=str_replace($aMatch[0][$key],$str_new,$sText);
			}
		}
		/**
		 * Удаляем все <param name="wmode" value="*"></param>
		 */
		if (preg_match_all("@(<param\s.*name=(?:\"|')wmode(?:\"|').*>\s*</param>)@Ui",$sText,$aMatch)) {
			foreach ($aMatch[1] as $key => $str) {
				$sText=str_replace($aMatch[0][$key],'',$sText);
			}
		}
		/**
		 * А теперь после <object> добавляем <param name="wmode" value="opaque"></param>
		 * Решение не фантан, но главное работает :)
		 */
		if (preg_match_all("@(<object\s.*>)@Ui",$sText,$aMatch)) {
			foreach ($aMatch[1] as $key => $str) {
				$sText=str_replace($aMatch[0][$key],$aMatch[0][$key].'<param name="wmode" value="opaque"></param>',$sText);
			}
		}
		return $sText;
	}
	/**
	 * Подсветка исходного кода
	 *
	 * @param string $sText Исходный текст
	 * @return mixed
	 */
	public function CodeSourceParser($sText) {
		$sText=str_replace("<code>",'<pre class="prettyprint"><code>',$sText);
		$sText=str_replace("</code>",'</code></pre>',$sText);
		return $sText;
	}
	/**
	 * Производить резрезание текста по тегу cut.
	 * Возвращаем массив вида:
	 * <pre>
	 * array(
	 * 		$sTextShort - текст до тега <cut>
	 * 		$sTextNew   - весь текст за исключением удаленного тега
	 * 		$sTextCut   - именованное значение <cut>
	 * )
	 * </pre>
	 *
	 * @param  string $sText Исходный текст
	 * @return array
	 */
	public function Cut($sText) {
		$sTextShort = $sText;
		$sTextNew   = $sText;
		$sTextCut   = null;

		$sTextTemp=str_replace("\r\n",'[<rn>]',$sText);
		$sTextTemp=str_replace("\n",'[<n>]',$sTextTemp);

		if (preg_match("/^(.*)<cut(.*)>(.*)$/Ui",$sTextTemp,$aMatch)) {
			$aMatch[1]=str_replace('[<rn>]',"\r\n",$aMatch[1]);
			$aMatch[1]=str_replace('[<n>]',"\r\n",$aMatch[1]);
			$aMatch[3]=str_replace('[<rn>]',"\r\n",$aMatch[3]);
			$aMatch[3]=str_replace('[<n>]',"\r\n",$aMatch[3]);
			$sTextShort=$aMatch[1];
			$sTextNew=$aMatch[1].' <a name="cut"></a> '.$aMatch[3];
			if (preg_match('/^\s*name\s*=\s*"(.+)"\s*\/?$/Ui',$aMatch[2],$aMatchCut)) {
				$sTextCut=trim($aMatchCut[1]);
			}
		}

		return array($sTextShort,$sTextNew,$sTextCut ? htmlspecialchars($sTextCut) : null);
	}
	/**
	 * Обработка тега ls в тексте
	 * <pre>
	 * <ls user="admin" />
	 * </pre>
	 *
	 * @param string $sTag	Тег на ктором сработал колбэк
	 * @param array $aParams Список параметров тега
	 * @return string
	 */
	public function CallbackTagLs($sTag,$aParams) {
		$sText='';
		if (isset($aParams['user'])) {
			if ($oUser=$this->User_getUserByLogin($aParams['user'])) {
				$sText.="<a href=\"{$oUser->getUserWebPath()}\" class=\"ls-user\">{$oUser->getLogin()}</a> ";
			}
		}
		return $sText;
	}

}