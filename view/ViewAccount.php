<?php
class ViewAccount extends View{
    //ATTRIBUT
    private string $list = "";
    private string $message = "";
    //GETTER ET SETTER

    /**
     * Get the value of list
     *
     * @return string
     */
    public function getList(): string {
        return $this->list;
    }

    /**
     * Set the value of list
     *
     * @param string $list
     *
     * @return self
     */
    public function setList(string $list): self {
        $this->list = $list;
        return $this;
    }
     /**
     * Get the value of message
     *
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @param string $message
     *
     * @return self
     */
    public function setMessage(string $message): self {
        $this->message = $message;
        return $this;
    }

    //METHODS
    public function display(): void{
?>
        <main>
            <?= $this->message ?>
            
            <ul>
                <?= $this->list ?>
            </ul>
            <?php
            if(isset($_POST['delete'])){
                ?>
                <p style="color: red;" >Êtes vous sûr de vouloir supprimer votre compte?</p>
            <form action="" method="post">
                <input type="submit" name="deleter" style="color: red;" value="Supprimer compte">
                <input type="submit" name="nope" value="Ne pas supprimer">
            </form>
        <?php
        }else{
                ?>
            <p>Modifier des informations</p>
            
            <form action="" method="post">
                <label for="login">E-mail : <input type="email" name="email" id="login" value="<?= $_SESSION['email']?? '' ?>" placeholder="votre.email@exemple.com"></label><br>
                <label for="last">Nom : <input type="text" name="lastname" id="last" value="<?= $_SESSION['lastname']?? '' ?>" placeholder="Dupont"></label>
                <label for="first">Prénom : <input type="text" name="firstname" id="first" value="<?= $_SESSION['firstname']?? '' ?>" placeholder="Patrick"></label><br>
                <label for="address">Adresse : <textarea type="text" name="address" rows="4" cols="40" id="address" placeholder="123 Rue du Fort"><?= $_SESSION['address']?? '' ?></textarea></label><br>
                <label for="zip">Code postal : <input type="number" name="zip_code" id="zip" value="<?= $_SESSION['zip_code']?? '' ?>" placeholder="12345"></label>
                <label for="cty">Ville : <input type="text" name="city" id="cty" value="<?= $_SESSION['city']?? '' ?>" placeholder="Ville"></label><br>
                <label for="country">Pays : <input type="text" name="country" id="country" value="<?= $_SESSION['country']?? '' ?>" placeholder="Pays"></label><br>
                <!--Nouveau mot de passe-->
                <label for="pswd1">Nouveau mot de passe : <input type="password" name="newPswrd" id="pswd1" placeholder="12 caractères minimum"></label>
                <label for="npswd2">Confirmer nouveau mot de passe : <input type="password" name="newPswrd2" id="npswd2" placeholder="12 caractères minimum"></label>
                <p>Veuillez taper votre mot de passe pour confirmer les changements.</p>
                <!--Ancien mot de passe-->
                <label for="pswd2">Ancien mot de passe : <input type="password" name="Apswrd" id="pswd2" placeholder="12 caractères minimum"></label><br>
                <input type="submit" name="modif" value="Valider">
            </form>
            <p>La suppression est définitive.</p>
            
            <form action="" method="post">
                <input type="submit" name="delete" value="Supprimer compte">
            </form>
        <?php

        }
            ?>
        </main>
<?php
    }

}