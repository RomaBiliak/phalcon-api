<?php
declare(strict_types=1);
namespace Apps\Modules\Establishment\Models;
use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
class Establishments extends Model
{
    public $id;
    public $name;
    public $phone;
    public $email;
    public $password;
    public $token;

    public function validation()
    {
        $validator = new Validation();
        $validator->add(
            'email',
            new Uniqueness([
                'model' => $this,
                'message' => 'Sorry, That email is already taken',
            ])
        );
        return $this->validate($validator);
    }
    public function beforeCreate()
    {
        $this->created_at = date('Y-m-d H:i:s');
        $this->password = $this->getDI()
            ->getSecurity()
            ->hash($this->password);
    }
    public function beforeUpdate()
    {
        $this->updated_at = date('Y-m-d H:i:s');
    }
}