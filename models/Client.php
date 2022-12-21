<?php

class Client
{
    //DECLARATION DES ATTRIBUTS DE LA CLASSE
    private int $clientId;
    private string $clientPrenom;
    private string $clientNom;
    private string $clientNaissance;
    private string $clientMail;
    private string $clientPassword;
    private string $clientRole;

    /**  CONSTRUCTEUR
     * @param int $clientId
     * @param string $clientPrenom
     * @param string $clientNom
     * @param string $clientNaissance
     * @param string $clientMail
     * @param string $clientPassword
     */
    public function __construct(int $clientId, string $clientPrenom, string $clientNom, string $clientNaissance, string $clientMail, string $clientPassword, string $clientRole)
    {
        $this->setClientId($clientId);
        $this->setClientPrenom($clientPrenom);
        $this->setClientNom($clientNom);
        $this->setClientNaissance($clientNaissance);
        $this->setClientMail($clientMail);
        $this->setClientPassword($clientPassword);
        $this->setClientRole($clientRole);
    }



    //**************METHODES ACCESSEURS (GETTERS AND SETTERS************)
    //setter pour l'attribut clientId permet d'accéder en écriture à l'attribut
    //cette méthode est une procédure (elle ne renvoie rien)


    /**
     * @return string
     */
    public function getClientPrenom(): string
    {
        return $this->clientPrenom;
    }

    /**
     * @param string $clientPrenom
     */
    public function setClientPrenom(string $clientPrenom): void
    {
        $this->clientPrenom = $clientPrenom;
    }

    /**
     * @return string
     */
    public function getClientNom(): string
    {
        return $this->clientNom;
    }

    /**
     * @param string $clientNom
     */
    public function setClientNom(string $clientNom): void
    {
        $this-> clientNom = $clientNom;
    }

    /**
     * @return string
     */
    public function getClientNaissance(): string
    {
        return $this->clientNaissance;
    }

    /**
     * @param string $clientNaissance
     */
    public function setClientNaissance(string $clientNaissance): void
    {
        $this->clientNaissance = $clientNaissance;
    }
    public function getClientAge(): int
    {
        return calculerAge($this->getClientNaissance());
    }

    public function getClientSigne(): string
    {
        $naissance = strftime('%d/%m/%Y', strtotime($this->getClientNaissance()));
        return $signe = trouverSigneZodiaque($naissance);
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @param int $clientId
     */
    public function setClientId(int $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getClientMail(): string
    {
        return $this->clientMail;
    }

    /**
     * @param string $clientMail
     */
    public function setClientMail(string $clientMail): void
    {
        $this->clientMail = $clientMail;
    }

    /**
     * @return string
     */
    public function getClientPassword(): string
    {
        return $this->clientPassword;
    }

    /**
     * @param string $clientPassword
     */
    public function setClientPassword(string $clientPassword): void
    {
        $this->clientPassword = $clientPassword;
    }

    /**
     * @return string
     */
    public function getClientRole(): string
    {
        return $this->clientRole;
    }

    /**
     * @param string $clientRole
     */
    public function setClientRole(string $clientRole): void
    {
        $this->clientRole = $clientRole;
    }



}