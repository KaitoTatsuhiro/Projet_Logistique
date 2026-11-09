<?php
class ViewHeader extends View{
    //ATTRIBUTS
    private string $title;
    //CONSTRUCT

    //GETTER ET SETTER
    
    /**
     * Get the value of title
     *
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self {
        $this->title = $title;
        return $this;
    }
    
    public function display(): void{
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= $this->getTitle() ?></title>
        </head>
        <body>
            <header>
                <h1><?= $this->getTitle() ?></h1>
                <nav>
                    <?php 
                    echo '<a href="/">Accueil</a> ';
                    $connect="";
                    if(isset($_SESSION['id'])){
                        $connect .= '<a href="/account">Profil</a> ';
                        $connect .= '<a href="/logout">Se Déconnecter</a> ';
                    }else{
                        $connect .= '<a href="/connection">Connection/Inscription</a> ';
                    }
                    echo $connect;
                    ?>
                </nav>
            </header>
<?php
    }

}