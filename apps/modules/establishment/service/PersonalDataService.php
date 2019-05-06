<?php
declare(strict_types=1);
namespace Apps\Modules\Establishment\Service;

use Apps\Common\Helper\ModelMessageArray;
use Apps\Modules\Establishment\Models\Establishments;
use Apps\Modules\Establishment\Validation\{PersonalValidation, PasswordValidation};
use Apps\Modules\Establishment\Exceptions\{ValidateException};
use Apps\Common\Exceptions\{NotFoundException};
class PersonalDataService extends \Phalcon\DI\Injectable
{
    public function getPersonalData():Establishments
    {
        $id = $this->establishment->getId();
        $establishment = Establishments::findFirst("id = ".$id);
        if($establishment !==  false && $establishment->count())
        {
            return $establishment;
        }else{
            throw new NotFoundException();
        }
    }
    public function addPersonalData():Establishments
    {
        $establishment = new Establishments();
        $validation = new PersonalValidation();
        $validation_password = new PasswordValidation();

        $messages = $validation->validate($this->request->get());
        $messages_password = $validation_password->validate($this->request->get());
        if (count($messages) || count($messages_password)) {
            $m=[];
            foreach($messages as $message) $m[]=$message;
            foreach($messages_password as $message) $m[]=$message;

            throw new ValidateException(serialize(ModelMessageArray::toArray($m)));
        }

        $establishment->password = $this->request->get('password');
        if($establishment->save($this->request->get()) !==  false)
        {
            return $establishment;
        }else{
            throw new ValidateException(serialize(ModelMessageArray::toArray($establishment->getMessages())));
        }

    }

    public function editPersonalData():Establishments
    {
        $id = $this->establishment->getId();
        $establishment = Establishments::findFirst($id);
        if($establishment ===  false || !$establishment->count())
            throw new NotFoundException();

        $validation = new PersonalValidation();
        $messages = $validation->validate($this->request->get());
        $messages_password = [];
        if(!empty($this->request->get('password'))){
            $validation_password = new PasswordValidation();
            $messages_password = $validation_password->validate($this->request->get());
            $establishment->password = $this->getDI()
                ->getSecurity()
                ->hash($this->request->get('password'));
        }
        if (count($messages) || count($messages_password)) {
            $m=[];
            foreach($messages as $message) $m[]=$message;
            foreach($messages_password as $message) $m[]=$message;

            throw new ValidateException(serialize(ModelMessageArray::toArray($m)));
        }

        $establishment->name = $this->request->get('name');
        $establishment->phone = $this->request->get('phone');
        $establishment->email = $this->request->get('email');

        if($establishment->update() !==  false)
        {
            return $establishment;
        }else{
            throw new ValidateException(serialize(ModelMessageArray::toArray($establishment->getMessages())));
        }

    }
}
