<?php
class ModelAuth extends Model{
    //ATTRIBUT
    private int $idUser;
    private string $firstN = "";
    private string $lastN = "";
    private string $email = "";
    private string $password = "";
    private string $createdAt = "";
    private string $address = "";
    private string $role = "";
    private string $city = "";
    private int $zip;
    private string $country = "";
    //CONSTRUCT

    // #region GETTER ET SETTER


    /**
     * Get the value of idUser
     *
     * @return int
     */
    public function getIdUser(): int {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @param int $idUser
     *
     * @return self
     */
    public function setIdUser(int $idUser): self {
        $this->idUser = $idUser;
        return $this;
    }

    /**
     * Get the value of firstN
     *
     * @return string
     */
    public function getFirstN(): string {
        return $this->firstN;
    }

    /**
     * Set the value of firstN
     *
     * @param string $firstN
     *
     * @return self
     */
    public function setFirstN(string $firstN): self {
        $this->firstN = $firstN;
        return $this;
    }

    /**
     * Get the value of lastN
     *
     * @return string
     */
    public function getLastN(): string {
        return $this->lastN;
    }

    /**
     * Set the value of lastN
     *
     * @param string $lastN
     *
     * @return self
     */
    public function setLastN(string $lastN): self {
        $this->lastN = $lastN;
        return $this;
    }

    /**
     * Get the value of email
     *
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of password
     *
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password): self {
        $this->password = $password;
        return $this;
    }

    /**
     * Get the value of createdAt
     *
     * @return string
     */
    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param string $createdAt
     *
     * @return self
     */
    public function setCreatedAt(string $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get the value of address
     *
     * @return string
     */
    public function getAddress(): string {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @param string $address
     *
     * @return self
     */
    public function setAddress(string $address): self {
        $this->address = $address;
        return $this;
    }

    /**
     * Get the value of role
     *
     * @return string
     */
    public function getRole(): string {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @param string $role
     *
     * @return self
     */
    public function setRole(string $role): self {
        $this->role = $role;
        return $this;
    }

    /**
     * Get the value of city
     *
     * @return string
     */
    public function getCity(): string {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @param string $city
     *
     * @return self
     */
    public function setCity(string $city): self {
        $this->city = $city;
        return $this;
    }

    /**
     * Get the value of zip
     *
     * @return int
     */
    public function getZip(): int {
        return $this->zip;
    }

    /**
     * Set the value of zip
     *
     * @param int $zip
     *
     * @return self
     */
    public function setZip(int $zip): self {
        $this->zip = $zip;
        return $this;
    }

    /**
     * Get the value of country
     *
     * @return string
     */
    public function getCountry(): string {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @param string $country
     *
     * @return self
     */
    public function setCountry(string $country): self {
        $this->country = $country;
        return $this;
    }
    // #endregion
    //METHOD
    public function getCountryByCountry():int | false{
        $request = $this->getPdo()->prepare('SELECT id_country FROM country WHERE name_country = ?');
        $request->bindParam(1,$this->country,PDO::PARAM_STR);
        $request->execute();
        return $request->fetchColumn(); // On récupère l'id seul pour savoir quel id de pays assigné sur la ville
        //faire le insert into demain pour la ville et du coup une vérif (peut être faire un autre register pour la ville et l'utilisateur au final...)
        
    }
    public function getCityByCity():int | false{
        $request = $this->getPdo()->prepare('SELECT id_city FROM city WHERE zip_code_city = ?');
        $request->bindParam(1,$this->zip,PDO::PARAM_INT);
        $request->execute();
        return $request->fetchColumn(); //On récupère l'id seul pour savoir si le code postal existe
    }
    public function getAllByEmail():array | false{
        $request = $this->getPdo()->prepare('SELECT u.id_user, cty.zip_code_city, u.login_user, u.password_user, u.lastname_user, u.firstname_user, u.address_user, u.created_at, cty.name_city, c.name_country, r.id_role FROM user u INNER JOIN city cty ON u.id_city = cty.id_city INNER JOIN country c ON cty.id_country = c.id_country INNER JOIN `role` r ON u.id_role = r.id_role WHERE u.login_user = ?');
        $request->bindParam(1,$this->email,PDO::PARAM_STR);
        $request->execute();
        return $request->fetch(PDO::FETCH_ASSOC);
    }
    private function addCity($newCountryID){
        try{
            $request = $this->getPdo()->prepare('INSERT INTO city(id_country, zip_code_city, name_city) VALUES(?, ?, ?)');
            $request->bindParam(1,$newCountryID,PDO::PARAM_INT);
            $request->bindParam(2,$this->zip,PDO::PARAM_INT);
            $request->bindParam(3,$this->city,PDO::PARAM_STR);
            $request->execute();
            return $this->getPdo()->lastInsertId();
        }catch(Exception $error){
            die($error->getMessage());
        }
    }
    public function register():string{
        try{
            $data = $this->getAllByEmail();
            if($data){
                return "Email déjà utilisé.";
            }
            $data = $this->getCityByCity();
            if(!$data){
                $data = $this->getCountryByCountry();
                    if($data){
                    $data = $this->addCity($data);
                }else{
                    return "Pays non disponible.";
                }
            }
                $request = $this->getPdo()->prepare('INSERT INTO User(login_user, password_user, lastname_user, firstname_user, address_user, id_city, id_role) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $request->bindParam(1,$this->email,PDO::PARAM_STR);
                $request->bindParam(2,$this->password,PDO::PARAM_STR);
                $request->bindParam(3,$this->lastN,PDO::PARAM_STR);
                $request->bindParam(4,$this->firstN,PDO::PARAM_STR);
                $request->bindParam(5,$this->address,PDO::PARAM_STR);
                $request->bindParam(6,$data,PDO::PARAM_INT);
                $request->bindParam(7,$this->role,PDO::PARAM_STR);
                $request->execute();
                return "Utilisateur enregistré.";
            
        }catch(Exception $error){
            die($error->getMessage());
        }
    }
    public function modify():string{
        try{
            $data = $this->getAllByEmail();
            if($data && $data['id_user'] != $_SESSION['id']){
                return "Email déjà utilisé.";
            }
            $idCity = $this->getCityByCity();
            if(!$idCity){
                $data = $this->getCountryByCountry();
                    if($data){
                    $idCity = $this->addCity($data);
                }else{
                    return "Pays non disponible.";
                }
            }
                $request = $this->getPdo()->prepare('UPDATE User SET login_user = ?, password_user = ?, lastname_user = ?, firstname_user = ?, address_user = ?, id_city = ? WHERE id_user = ?');
                $request->bindParam(1,$this->email,PDO::PARAM_STR);
                $request->bindParam(2,$this->password,PDO::PARAM_STR);
                $request->bindParam(3,$this->lastN,PDO::PARAM_STR);
                $request->bindParam(4,$this->firstN,PDO::PARAM_STR);
                $request->bindParam(5,$this->address,PDO::PARAM_STR);
                $request->bindParam(6,$idCity,PDO::PARAM_INT);
                $request->bindParam(7,$_SESSION['id'],PDO::PARAM_INT);
                $request->execute();
                return "Utilisateur modifié.";

        }catch(Exception $error){
            die($error->getMessage());
        }
    }
    public function delete(){
        try{
            $request = $this->getPdo()->prepare('DELETE FROM user WHERE id_user = ?');
            $request->bindParam(1,$_SESSION['id'],PDO::PARAM_INT);
            $request->execute();
            session_destroy();
            header("Location: /");
            exit;
        }catch(Exception $error){
            die($error->getMessage());
        }
    }
}