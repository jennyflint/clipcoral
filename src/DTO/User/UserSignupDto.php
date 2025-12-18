<?php

declare(strict_types=1);

namespace App\DTO\User;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserSignupDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Email cannot be empty')]
        #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
        public string $email,
        #[Assert\NotBlank(message: 'Password cannot be empty')]
        #[Assert\Length(min: 6, minMessage: 'Password must be at least 6 characters long')]
        public string $password,
    ) {
    }
}
