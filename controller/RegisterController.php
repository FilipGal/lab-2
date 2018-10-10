<?php

namespace Controller;

class RegisterController
{
    private $v;
    private $pur;

    public function __construct(\View\RegisterView $v, \Model\PersistentUserRegistry $pur)
    {
        $this->rv = $v;
        $this->pur = $pur;
    }

    public function registerResponse(): void
    {
        if ($this->rv->userWantsToRegister()) {
            $this->pur->addUser(
                $this->rv->getUsername(),
                $this->rv->getPassword(),
                $this->rv->getRepeatPassword()
            );
        }
    }
}
