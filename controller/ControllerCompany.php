<?php
class ControllerCompany extends Controller{
    public function __construct(ViewHeader $newViewHeader, ViewFooter $newViewFooter, ViewCompany $newViewCompany, ModelCompany $newModelCompany){
        $this->addView('header',$newViewHeader);
        $this->addView('footer', $newViewFooter);
        $this->addView('company', $newViewCompany);
        $this->addModel('entreprise', $newModelCompany);
        }

    public function getCompanyInfo()/*:string*/{
        /*$list = "";
        foreach(["firstname", "lastname", "email", "address", "city", "zip_code", "country"] as $val){ //mettre les infos de l'entreprise si elle existe
            $list .= "<li>".$_SESSION[$val]."</li>";
        }
            return $list;*/
    }

    public function createCompany(){

    }
    public function modifyCompany(){

    }
    public function deleteCompany(){

    }
    
    public function render(): void{
        if($_SESSION['role'] != 4){
            header('Location: /');
            exit;
        }
        
        $this->getViews()['header']->setTitle("Entreprise")->display();
        $this->getViews()['company']->setMessage()->display();
        $this->getViews()['footer']->display();
    }
}