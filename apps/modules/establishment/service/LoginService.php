<?php
declare(strict_types=1);
namespace Apps\Modules\Establishment\Service;

use Apps\Common\Helper\ModelMessageArray;
use Apps\Modules\Establishment\Models\Establishments;
use Apps\Modules\Establishment\Validation\{LoginValidation};
use Apps\Modules\Establishment\Exceptions\{ValidateException};
use Apps\Common\Exceptions\LoginException;
class LoginService extends \Phalcon\DI\Injectable
{

    public function login():string
    {
        $validation = new LoginValidation();
        $messages = $validation->validate($this->request->get());
        if (count($messages)) {
            $m=[];
            foreach($messages as $message) $m[]=$message;
            throw new ValidateException(serialize(ModelMessageArray::toArray($m)));
        }
        $establishment = Establishments::findFirst([
            "email = :email:",
            'bind' => [
                'email' => $this->request->get('email')
            ]
        ]);

        if ($this->security->checkHash($this->request->get('password'), $establishment->password)) {
            return $this->JWT->generateUserJWT(['establishment_id'=>$establishment->id]);

        }

        throw new LoginException();

    }


}
