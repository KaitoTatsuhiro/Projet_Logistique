<?php
class ViewAuth extends View{
    //ATTRIBUT
    private string $message = "";
    //CONSTRUCT

    //GETTER ET SETTER
    
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
    public function display(): void
    {
?>
        <main>
        <?= e($this->message) ?>
    <section>
        <h2>Connection</h2>
        <form action="" method="post">
            <label for="emailCo">E-mail : <input type="email" name="emailCo" id="emailCo" placeholder="votre.email@exemple.com"></label>
            <label for="pswdCo">Mot de passe : <input type="password" name="pswrdCo" id="pswdCo" placeholder="12 caractères minimum"></label><br>
            <input type="submit" name="login" value="Valider">
        </form>
    </section>
    <section>
        <h2>Inscription</h2>
        <form action="" method="post">
            <label for="login">E-mail : <input type="email" name="email" id="login" value="<?= $_POST['email']?? '' ?>" placeholder="votre.email@exemple.com"></label><br>
            <label for="pswd1">Mot de passe : <input type="password" name="pswrd1" id="pswd1" placeholder="12 caractères minimum"></label>
            <label for="pswd2">Mot de passe : <input type="password" name="pswrd2" id="pswd2" placeholder="12 caractères minimum"></label><br>
            <label for="last">Nom : <input type="text" name="lastname" id="last" value="<?= $_POST['lastname']?? '' ?>" placeholder="Dupont"></label>
            <label for="first">Prénom : <input type="text" name="firstname" id="first" value="<?= $_POST['firstname']?? '' ?>" placeholder="Patrick"></label><br>
            <label for="address">Adresse : <textarea type="text" name="address" rows="4" cols="40" id="address" placeholder="123 Rue du Fort"><?= $_POST['address']?? '' ?></textarea></label><br>
            <label for="zip">Code postal : <input type="number" name="zip_code" id="zip" value="<?= $_POST['zip_code']?? '' ?>" placeholder="12345"></label>
            <label for="cty">Ville : <input type="text" name="city" id="cty" value="<?= $_POST['city']?? '' ?>" placeholder="Ville"></label><br>
            <label for="country">Pays : <input type="text" name="country" id="country" value="<?= $_POST['country']?? '' ?>" placeholder="Pays"></label><br>
            <select name="role" id="">
            <option value="">--Veuillez choisir une option--</option>
            <option value="3">Client</option>
            <option value="4">Fournisseur</option>
            </select>
            <input type="submit" name="register" value="Valider">
        </form>
    </section>
</main>
<?php
    }
}