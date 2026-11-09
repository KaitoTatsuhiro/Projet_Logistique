<?php
class ControllerHome extends Controller{
    //CONSTRUCT
    public function __construct(ViewHeader $newViewHeader, ViewFooter $newViewFooter, ViewHome $newViewHome){
        $this->addView('header', $newViewHeader);
        $this->addView('footer', $newViewFooter);
        $this->addView('accueil', $newViewHome);
    }

    //METHODS
    public function render(): void
    {
        $this->getViews()['header']->setTitle('Accueil')->display();
        $this->getViews()['accueil']->display();
        $this->getViews()['footer']->display();
    }
}