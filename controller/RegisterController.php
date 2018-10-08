<?php

class RegisterController
{
    private $v;
    private $m;

    public function __construct(RegisterView $v, RegisterModel $m)
    {
        $this->rv = $v;
        $this->rm = $m;
    }

    public function registerResponse(): void
    {
        if ($this->rv->userWantsToRegister()) {
            $this->rm->registerUser(
                $this->rv->getUsername(),
                $this->rv->getPassword(),
                $this->rv->getRepeatPassword()
            );
        }
    }
}
