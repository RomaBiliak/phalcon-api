<?php
declare(strict_types=1);
namespace Apps\Common\Service;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Http\Request;
class TranslateService
{
	protected $translate_dir = '';
	public function __construct($translate_dir)
	{
		$this->translate_dir = $translate_dir;
	}
	
	public function getTranslation()
	{
		
        $request = new Request();
        $language = $request->getBestLanguage();

        $translationFile = $this->translate_dir . $language. '.php';

     
        if (file_exists($translationFile)) {
            $messages = include $translationFile;
        } else {

            $messages = include  $this->translate_dir .'en.php';
        }


        return new NativeArray(
            [
                'content' => $messages,
            ]
        );
	}
}