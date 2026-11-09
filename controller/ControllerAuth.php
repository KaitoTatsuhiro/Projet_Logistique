<?php
class ControllerAuth extends Controller{
    //CONSTRUCT
    public function __construct(ViewHeader $newViewHeader, ViewFooter $newViewFooter, ViewAuth $newViewAuth, ModelAuth $newModelAuth){
        $this->addView('header',$newViewHeader);
        $this->addView('footer', $newViewFooter);
        $this->addView('authentification', $newViewAuth);
        $this->addModel('connection', $newModelAuth);
    }
    //METHODS

    //Connection
    public function connectUser(){
        if(!isset($_POST['login'])){
            return "";
        }
        foreach(['emailCo','pswrdCo'] as $champ){
            if(empty($_POST[$champ])){
                return "Veuillez remplir les champs.";
            }
        }
        $email = normalize($_POST['emailCo']);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return "E-mail invalide.";
        }
        if(mb_strlen($_POST['pswrdCo'],'UTF-8') <12){
            return "Mot de passe trop court.";
        }
        $model = $this->getModels()['connection'];
        $model->setEmail($email);
        $data = $model->getAllByEmail();
        if(!$data || !password_verify($_POST['pswrdCo'],$data['password_user'])){
            return "E-mail ou mot de passe incorrect.";
        }
            $_SESSION['id'] =           $data['id_user'];
            $_SESSION['email'] =        $data['login_user'];
            $_SESSION['firstname'] =    $data['firstname_user'];
            $_SESSION['lastname'] =     $data['lastname_user'];
            $_SESSION['address'] =      $data['address_user'];
            $_SESSION['created_at'] =   $data['created_at'];
            $_SESSION['zip_code'] =     $data['zip_code_city'];
            $_SESSION['city'] =         $data['name_city'];
            $_SESSION['country'] =      $data['name_country'];
            $_SESSION['role'] =         $data['id_role'];
            header('Location: /');
        

    }
    //Inscription
    public function registerUser(): string{
        if(!isset($_POST['register'])){
            return "";
        }
        foreach(['email','pswrd1','pswrd2','lastname','firstname','address','zip_code','city','country','role'] as $champ){
            if(empty($_POST[$champ])){
                return "Veuillez remplir les champs.";
            }
        }
        $email = normalize($_POST['email']);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return "E-mail invalide.";
        }
        if(!filter_var($_POST['zip_code'], FILTER_VALIDATE_INT)){
            return "Code postal invalide.";
        }
        if(mb_strlen($_POST['pswrd1'],'UTF-8') <12){
            return "Mot de passe trop court.";
        }
        if($_POST['pswrd1'] !== $_POST['pswrd2']){
            return "Les mots de passe ne correspondent pas.";
        }
        if($_POST['role'] < 3 || $_POST['role'] > 4){
            return "Mauvais role choisis.";
        }
        $model = $this->getModels()['connection'];
        $model->setEmail($email)
            ->setLastN(normalize($_POST['lastname']))
            ->setFirstN(normalize($_POST['firstname']))
            ->setAddress(normalize($_POST['address']))
            ->setZip((int)$_POST['zip_code'])
            ->setCity(normalize($_POST['city']))
            ->setCountry(normalize($_POST['country']))
            ->setPassword(password_hash($_POST['pswrd1'], PASSWORD_DEFAULT))
            ->setRole((int)$_POST['role']);
        return $model->register();
    }

    public function render(): void
    {
        if(isset($_SESSION['id'])){
            header('Location: /');
            exit;
        }
        $message = $this->connectUser();
        if($message === ""){
            $message = $this->registerUser();
        }
        $this->getViews()['header']->setTitle("Connection/Inscription")->display();
        $this->getViews()['authentification']->setMessage($message)->display();
        $this->getViews()['footer']->display();
    }
}