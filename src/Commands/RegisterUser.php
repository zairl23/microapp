<?php namespace Neychang\Microapp\Commands;

class RegisterUser {
    private $emailAddress;
    private $plainTextPassword;

    public function __construct($emailAddress, $plainTextPassword)
    {
        $this->emailAddress = $emailAddress;
        $this->plainTextPassword = $plainTextPassword;
    }

    public function emailAddress()
    {
        return $this->emailAddress;
    }

    public function plainTextPassword()
    {
        return $this->plainTextPassword;
    }
}