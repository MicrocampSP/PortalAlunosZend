<?php

class Instrutores_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance();
        $authStorage = $auth->getStorage()->read();
        
        Zend_Debug::dump($authStorage);
    }

    public function indexAction()
    {
               
    }


}

