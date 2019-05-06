<?php
declare(strict_types=1);
namespace Apps\Modules\Establishment\Models;
use Phalcon\Mvc\Model;

class EstablishmentAdmin extends Model
{
    public $id;
    public $name;
    public $status;
    public $establishment_id;
    public $password;
    public $token;

    public function beforeValidationOnCreate()
    {
        $this->password = $this->getDI()
                            ->getSecurity()
                             ->hash($this->password);
    }
}