<?php
declare(strict_types=1);
namespace Apps\Modules\Establishment\Validation;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
class PersonalValidation extends Validation
{
    public function initialize()
    {
        /*
        $establishments = new Establishments();

        $this->add(
            "email",
            new Uniqueness(
                [
                    "model"     => new $establishments,
                    "attribute" => "email",
                ]
            )
        );*/

        $this->add(
            [
                "name",
            ],
            new StringLength(
                [
                    "max" => [
                        "name"  => 50,
                    ],
                    "min" => [
                        "name"  => 2,
                    ],
                    "messageMaximum" => [
                        "name"  => "We don't like really long  names",
                    ],
                    "messageMinimum" => [
                        "name"  => "We don't like too short  names",
                    ]
                ]
            )
        );
        $this->add(
            'name',
            new PresenceOf(
                [
                    'message' => 'The name is required',
                ]
            )
        );
        $this->add(
            'phone',
            new PresenceOf(
                [
                    'message' => 'The phone is required',
                ]
            )
        );

        $this->add(
            'email',
            new PresenceOf(
                [
                    'message' => 'The e-mail is required',
                ]
            )
        );

        $this->add(
            'email',
            new Email(
                [
                    'message' => 'The e-mail is not valid',
                ]
            )
        );
    }
}
