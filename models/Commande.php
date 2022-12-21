<?php
require('dao/daoLigneCommande.php');

class Commande
{
    //DECLARATION DES ATTRIBUTS DE LA CLASSE
    private int $commandeId;
    private Client $client;
    private string $commandeDate;


    //cette méthode est une procédure (elle ne renvoie rien)
    /**
     * @param int $commandeId
     * @param Client $leClient
     * @param string $commandeDate
     */
    public function __construct(int $commandeId, Client $leClient, string $commandeDate)
    {
        $this->setCommandeId($commandeId);
        $this->setClient($leClient);
        $this->setCommandeDate($commandeDate);
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        $dao = new  daoLigneCommande();
        return $dao->totalCommande($this->getCommandeId());
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }


    public function setCommandeId(int $commandeId): void
    {
        $this->commandeId = $commandeId;
    }

    //getter pour l'attribut clientId permet d'accéder en lecture à l'attribut
    //cette méthode est une fonction (elle renvoie un résultat typé)
    /*
     * param string $commandeId
     */
    public function getCommandeId(): int
    {
        return $this->commandeId;
    }

    /**
     * @return string
     */
    public function getCommandeDate(): string
    {
        return $this->commandeDate;
    }

    /**
     * @param string $commandeDate
     */
    public function setCommandeDate(string $commandeDate): void
    {
        $this->commandeDate = $commandeDate;
    }
}