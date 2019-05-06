<?php
declare(strict_types=1);
namespace Apps\Modules\Establishment\Validation;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class EstablishmentAdminValidation extends Validation
{
    public function initialize()
    {
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

    }
}
