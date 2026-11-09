<?php
class ControllerAccount extends Controller{
    //CONSTRUCT
    public function __construct(ViewHeader $newViewHeader, ViewFooter $newViewFooter, ViewAccount $newViewAccount, ModelAuth $newModelAuth){
        $this->addView('header',$newViewHeader);
        $this->addView('footer', $newViewFooter);
        $this->addView('compte', $newViewAccount);
        $this->addModel('connection', $newModelAuth);
    }
    //METHODS
    public function getInfo(): string{
        $liste = "";
        foreach(["firstname", "lastname", "email", "address", "city", "zip_code", "country"] as $val){
            $liste .= "<li>".$_SESSION[$val]."</li>";
        }
            return $liste;
    }
    public function modifyUser(): string{
        if(!isset($_POST['modif'])){
            return "";
        }
        foreach(['email','Apswrd','lastname','firstname','address','zip_code','city','country'] as $champ){
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
        $model = $this->getModels()['connection'];
        $model->setEmail($email)
            ->setLastN(normalize($_POST['lastname']))
            ->setFirstN(normalize($_POST['firstname']))
            ->setAddress(normalize($_POST['address']))
            ->setZip((int)$_POST['zip_code'])
            ->setCity(normalize($_POST['city']))
            ->setCountry(normalize($_POST['country']));
            
        $data = $model->getAllByEmail();
        if(!empty($_POST['newPswrd'])){
            if(mb_strlen($_POST['newPswrd'],'UTF-8') <12){
                return "Mot de passe trop court.";
            }
            if($_POST['newPswrd'] !== $_POST['newPswrd2']){
                return "Les mots de passe ne correspondent pas.";
            }
            
        $model->setPassword(password_hash($_POST['newPswrd'], PASSWORD_DEFAULT));
        }else{//On évite de laisser le mot de passe vide pour la modif
            $model->setPassword($data['password_user']);
        }
        if(!$data || !password_verify($_POST['Apswrd'],$data['password_user'])){
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
        return $model->modify();
        //[IMPROVE] Faire une condition si rien ne change
    }
    public function deleteUser(){
        $model = $this->getModels()['connection'];
        if(isset($_POST['deleter'])){
        return $model->delete();
        }
    }
    public function render(): void
    {
        if(!isset($_SESSION['id'])){
            header('Location: /');
            exit;
        }
        $message = $this->modifyUser();
        $list = $this->getInfo();
        $this->deleteUser();
        $this->getViews()['header']->setTitle("Compte")->display();
        $this->getViews()['compte']->setMessage($message)->setList($list)->display();
        $this->getViews()['footer']->display();
    }
}