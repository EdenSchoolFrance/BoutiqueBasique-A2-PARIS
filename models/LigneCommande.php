<?php

class LigneCommande
{
    //DECLARATION DES ATTRIBUTS DE LA CLASSE
    private Commande $Commande;
    private Produit $produit;
    private int $quantite;
    private float $prix;

    /**
     * @param Commande $Commande
     * @param Produit $produit
     * @param int $quantite
     * @param float $prix
     */
    public function __construct(Commande $Commande, Produit $produit, int $quantite, float $prix)
    {
        $this->setCommande($Commande);
        $this->setProduit($produit);
        $this->setQuantite($quantite);
        $this->setPrix($prix);
    }


    /**
     * @return Commande
     */
    public function getCommande(): Commande
    {
        return $this->Commande;
    }

    /**
     * @param Commande $Commande
     */
    public function setCommande(Commande $Commande): void
    {
        $this->Commande = $Commande;
    }

    /**
     * @return Produit
     */
    public function getProduit(): Produit
    {
        return $this->produit;
    }

    /**
     * @param Produit $produit
     */
    public function setProduit(Produit $produit): void
    {
        $this->produit = $produit;
    }

    /**
     * @return int
     */
    public function getQuantite(): int
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite(int $quantite): void
    {
        $this->quantite = $quantite;
    }

    /**
     * @return float
     */
    public function getPrix(): float
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    /**
     * @param float $prix
     */
    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }

    //FAUX GETTER
    public function getTotal(): float
    {
        return $this->getPrix() * $this->getQuantite();
    }
}



