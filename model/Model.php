<?php
class Model{
    //ATTRIBUT
    private PDO $pdo;

    //CONSTRUCT
    public function __construct(PDO $newPDO)
    {
        $this->pdo = $newPDO;
    }

    // #region GETTER ET SETTER


    /**
     * Get the value of pdo
     *
     * @return PDO
     */
    public function getPdo(): PDO {
        return $this->pdo;
    }

    /**
     * Set the value of pdo
     *
     * @param PDO $pdo
     *
     * @return self
     */
    public function setPdo(PDO $pdo): self {
        $this->pdo = $pdo;
        return $this;
    }
    // #endregion
    
    //METHOD
}