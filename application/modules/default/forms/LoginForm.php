<?php

class Default_Form_LoginForm extends Zend_Form
{

    public function __construct()
    {
        parent::__construct();
        
        $this->setName('login');
        
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Username: ')
                 ->setRequired();
        
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password: ')
                 ->setRequired();
        
        $login = new Zend_Form_Element_Submit('login');
        $login->setLabel('Login');
        
        $this->addElements(array($username, $password, $login));
        $this->setMethod('post');
        $this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/authentication/login');
    }


}

