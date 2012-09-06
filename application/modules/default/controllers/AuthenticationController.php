<?php

class Default_AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('instrutores/index');
        }
        
        $formLogin = new Default_Form_LoginForm();
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            if ($formLogin->isValid($this->_request->getPost())) {
                
                $authAdapter = $this->getAuthAdapter();
                
                $username = $formLogin->getValue('username');
                $password = $formLogin->getValue('password');
                
                $authAdapter->setIdentity($username)
                ->setCredential($password);
                
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                
                if ($result->isValid()) {
                
                    $identity = $authAdapter->getResultRowObject();
                
                    $authStorage = $auth->getStorage();
                    $authStorage->write($identity);
                
                    $this->_redirect('instrutores/index');
                
                } else {
                
                    $this->view->errorMessage = 'Usuario ou senha invalidos';
                
                }
            }
        }
        
        
        $this->view->formLogin = $formLogin;
        
        
    }

    public function logoutAction()
    {
        // action body
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('index/index');
    }
    
    private function getAuthAdapter()
    {
        $authAdapter = new Zend_Auth_Adapter_DbTable();
        $authAdapter->setTableName('TAB_LOGIN')
                    ->setIdentityColumn('Codigo')
                    ->setCredentialColumn('SENHA');
        
        return $authAdapter;
    }

}





