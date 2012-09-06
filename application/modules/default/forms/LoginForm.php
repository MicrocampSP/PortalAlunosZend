<?php

class Default_Form_LoginForm extends Zend_Form
{

    public function __construct()
    {
        parent::__construct();
        
        $this->setName('login');
        
        $codUnidade = new Zend_Form_Element_Select('unidade');
        $codUnidade->setLabel('Unidade: ')
                   ->setRequired();
        
        $consulta = new Default_Model_Unidades();
        foreach ($consulta->listaUnidades() as $unidade) {
            $codUnidade->addMultiOption($unidade['CodUnidade'], $unidade['Unidade']);
        }                 
        
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Username: ')
                 ->setRequired();
        
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password: ')
                 ->setRequired();
        
        $login = new Zend_Form_Element_Submit('login');
        $login->setLabel('Login');
        
        $this->addElements(array($codUnidade, $username, $password, $login));
        $this->setMethod('post');
        $this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/authentication/login');
        $this->setAttrib('accept-charset', 'utf-8');
    }


}

