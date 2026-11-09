<?php
class ViewHome extends View{
    

    public function display(): void{
?>
        <main>
            <?php
            if(isset($_SESSION['id'])){
                ?>
            <h3>Bienvenue, <?= strtolower(e($_SESSION['firstname'])); ?></h3>
            <?php
            }
            ?>
            <label for="recherche">Rechercher <input type="text" name="search" id="recherche" placeholder="Rechercher"></label>
        </main>
<?php
    }
}