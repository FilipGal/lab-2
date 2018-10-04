<?php

class RegisterController
{
    private $v;

    public function __construct(RegisterView $v)
    {
        $this->registerView = $v;
    }
}
