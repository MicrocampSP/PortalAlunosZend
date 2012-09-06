<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout()->setLayout('initial');
    }

    public function indexAction()
    {
        //Listando todas as unidades e mandando para a view
        $modelUnidades = new Default_Model_Unidades();
        $consultaUnidades = $modelUnidades->listaUnidades();
        
        $this->view->unidades = $consultaUnidades;
    }


}

