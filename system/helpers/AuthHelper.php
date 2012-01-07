<?php
    class AuthHelper{
            
        protected $sessionHelper;
        protected $redirectHelper;
        protected $tableName;
        protected $userColumn;
        protected $passColumn;
        protected $user;
        protected $pass;
        protected $loginController = 'home';
        protected $loginAction = 'index';
        protected $logoutController = 'index';
        protected $logoutAction = 'index';
     
        public function __construct(){
            $this->sessionHelper = new SessionHelper();
            $this->redirectHelper = new RedirectHelper();
        }
        
        public function setTableName($tableName){
            $this->tableName = $tableName;
            return $this;
        }
        
        public function setUserColumn($userColumn){
            $this->userColumn = $userColumn;
            return $this;
        }
        
        public function setPassColumn($passColumn){
            $this->passColumn = $passColumn;
            return $this;
        }
        
        public function setUser($user){
            $this->user = mysql_escape_string(addslashes($user));
            return $this;
        }
        
        public function setPass($pass){
            $this->pass = md5($pass);
            return $this;
        }
        
        public function setLoginControllerAction($controller, $action = null){
            $this->loginAction = ($action=="index"||$action==null?"indexaction":$action);
            $this->loginController = $controller;
            return $this;
        }
         
        public function setLogoutControllerAction($controller, $action = null){
            $this->logoutAction = ($action=="index"||$action==null?"indexaction":$action);
            $this->logoutController = $controller;
            return $this;
        }
        
        public function login(){
            $dao = new DAO();
            $sql = "SELECT * FROM $this->tableName WHERE $this->userColumn='$this->user' AND $this->passColumn='$this->pass' LIMIT 1";
            $result = mysql_query($sql, $dao->connection);
            echo mysql_error();
            if(mysql_fetch_assoc($result)){
                $this->sessionHelper->createSession("userAuth", true)
                                    ->createSession("userData", mysql_fetch_row($result));
                $this->redirectHelper->goToControllerAction($this->loginController, ($this->loginAction=='indexaction'?'index':$this->loginAction));
            }else{
                unset($dao);
                die('Login e/ou senha errado(s)');
            }
            unset($dao);
            return $this;   
        }
        
        public function logout(){
            $this->sessionHelper->deleteSession("userAuth")
                                ->deleteSession("userData");
            $this->redirectHelper->goToControllerAction($this->logoutController, ($this->logoutAction=='indexaction'?'index':$this->logoutAction));
            return $this;
        }
        
        public function checkLogin($action){
            switch ($action){
                case "boolean":
                    if(!$this->sessionHelper->checkSession('userAuth'))
                        return false;
                    else
                        return true;
                    break;
                case "redirect":
                    if(!$this->sessionHelper->checkSession('userAuth')){
                        if($this->redirectHelper->getCurrentController() != $this->logoutController || $this->redirectHelper->getCurrentAction() != $this->logoutAction)
                            $this->redirectHelper->goToControllerAction ($this->logoutController, ($this->logoutAction=='indexaction'?'index':$this->logoutAction));
                    }
                    else{
                        if($this->redirectHelper->getCurrentController() != $this->loginController || $this->redirectHelper->getCurrentAction() != $this->loginAction)
                            $this->redirectHelper->goToControllerAction ($this->loginController, ($this->loginAction=='indexaction'?'index':$this->loginAction));
                    }
                    break;
                case "stop":
                    if(!$this->sessionHelper->checkSession('userAuth'))
                        exit;
                    break;
            }
        }
        
        public function userData($key){
            $s = $this->sessionHelper->selectSession("userData");
            return $s[$key];
        }
    }
