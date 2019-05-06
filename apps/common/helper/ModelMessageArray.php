<?php
declare(strict_types=1);
namespace Apps\Common\Helper;
class ModelMessageArray
{
	public static function toArray(array $messages):array
	{
		$data = [];
		foreach($messages as &$message){
            $data[] = [
               'type' => $message->getType(),
               'message' => $message->getMessage(),
               'type' => $message->getType(),
               'field' => $message->getField(),
               'code' => $message->getCode(),
            ];
        }
		return $data;
	}
}