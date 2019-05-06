<?php
namespace Apps\Modules\Establishment\Service;
class EstablishmentService extends \Phalcon\DI\Injectable
{
    public function getId():int
    {
        $data = $this->JWT->getJWTData();
        if(isset($data->establishment_id))
            return $data->establishment_id;
        else
            throw new \Exception(null, 401);
    }
   

}
