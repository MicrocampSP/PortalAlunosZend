<?php

class Default_Model_Unidades extends Zend_Db_Table_Abstract
{
    protected $_name = 'TAB_Unidades';
    protected $_primary = 'CodUnidade';
    
    public function listaUnidades()
    {
        $consultaUnidades = new Default_Model_Unidades();
        $result = $consultaUnidades->fetchAll()->toArray();
         return $result;
    }
}

