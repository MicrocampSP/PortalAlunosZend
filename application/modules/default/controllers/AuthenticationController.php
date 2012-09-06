<?php

class Default_AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        //Habilita o layout "initial".
        $this->_helper->layout()->setLayout('initial');
    }

    public function indexAction()
    {
        //Something
    }

    public function loginAction()
    {    
        //Verifica se o usuario esta logado, se estiver redireciona-o.
        if (Zend_Auth::getInstance()->hasIdentity()) {
            
            //Verifica o nivel de acesso para decidir em que model irá joga-lo.
            switch (Zend_Auth::getInstance()->getStorage()->read()->NIVEL) {
               case 1:
                   $this->_redirect('/alunos/index/index');
                   break;
               case 2:
                   $this->_redirect('/instrutores/index/index');
                   break;
               case 3:
                   $this->_redirect('/coordenadores/index/index');
                   break;
               default:
                   $this->logoutAction();
                   break;
               }
        }

        
        //Instancia-se o formulario e recupera as informações vindas dele.
        $formLogin = new Default_Form_LoginForm();
        $request = $this->getRequest();
        
        //Se o formulario vier por metodo post então prossegue.
        if ($request->isPost()) {
            
            //Se os valores forem válidos então prossegue.
            if ($formLogin->isValid($this->_request->getPost())) {
                
                //pega as informações da função privada getAuthAdapter() no fim da pagina.
                $authAdapter = $this->getAuthAdapter();
                
                //Pega o usuario e a senha vindos do form  LoginForm do Model Default.
                $codUnidadeForm = $formLogin->getValue('unidade');
                $username       = $formLogin->getValue('username');
                $password       = $formLogin->getValue('password');
                
                //Atribui as informações vindas do formulario
                $authAdapter->setIdentity($username)
                            ->setCredential($password);
                
                //Cria uma instancia e autentica o login.
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                
                //Se a autenticação for valida então prossegue.
                if ($result->isValid()) {
                    
                    //Consulta todas as colunas do banco do usuario validado.
                    $identity = $authAdapter->getResultRowObject();
                    
                    //Abre uma sessão e escreve os valores do usuario na sessão.
                    $authStorage = $auth->getStorage()->write($identity);
                    
                    //Recupera o Nivel e o CodUnidade da sessão do usuario.
                    $nivel             = $auth->getStorage()->read()->NIVEL;
                    $codUnidadeStorage = $auth->getStorage()->read()->CodUnidade;
                    
                    //Verifica o nivel de acesso para decidir em que model irá joga-lo.
                    if ($codUnidadeStorage == $codUnidadeForm) {
                        
                        //Com base no nivel redireciona.
                        switch ($nivel) {
                            case 1:
                                $this->_redirect('/alunos/index/index');
                                break;
                            case 2:
                                $this->_redirect('/instrutores/index/index');
                                break;
                            case 3:
                                $this->_redirect('/coordenadores/index/index');
                                break;
                            default:
                                $this->logoutAction();
                                break;
                        }
                        
                    //Caso seje diferente os Cod's, mandará uma mensagem de erro para a view e apagará os dados da session.
                    } else {
                        $this->view->errorMessage = 'Este usuario não pertence a esta unidade.';
                        echo 'Este usuario não pertence a esta unidade.';
                        Zend_Auth::getInstance()->clearIdentity();
                    }

                //Caso a autenticação falhar mandará uma mensagem de erro para a view.
                } else {
                    $this->view->errorMessage = 'Usuario ou senha invalidos.';
                    echo 'Usuario ou senha invalidos.';
                }
            }
        }
        
        //Renderiza o formulário.
        $this->view->formLogin = $formLogin;
        
    }

    public function logoutAction()
    {
        //Limpa os dados da sessão e redireciona o usuario
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('index/index');
    }
    
    private function getAuthAdapter()
    {
        //Informamos em qual tabela e campos estão os valores de username e password.
        $authAdapter = new Zend_Auth_Adapter_DbTable();
        $authAdapter->setTableName('TAB_LOGIN')
                    ->setIdentityColumn('Codigo')
                    ->setCredentialColumn('SENHA');
        
        return $authAdapter;
    }

}





