<?php
declare(strict_types=1);
namespace Apps\Modules\Establishment\Validation;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class PasswordValidation extends Validation
{
    public function initialize()
    {
        $this->add(
            [
                "password",
            ],
            new StringLength(
                [
                    "max" => [
                        "password" => 50,
                    ],
                    "min" => [
                        "password" => 6,
                    ],
                    "messageMaximum" => [
                        "password" => "We don't like really long password",
                    ],
                    "messageMinimum" => [
                        "password" => "We don't like too short password",
                    ]
                ]
            )
        );

        $this->add(
            'password',
            new PresenceOf(
                [
                    'message' => 'The password is required',
                ]
            )
        );
        $this->add(
            "password",
            new Confirmation(
                [
                    "message" => "Password doesn't match confirmation",
                    "with"    => "confirmPassword",
                ]
            )
        );

    }
}
