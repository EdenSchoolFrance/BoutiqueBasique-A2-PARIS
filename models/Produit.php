<?php

class Produit
{
    //DECLARATION DES ATTRIBUTS DE LA CLASSE
    private int $produitId;
    private string $produitNom;
    private float $produitPrix;
    private string $produitImage;


    //**************METHODES ACCESSEURS (GETTERS AND SETTERS************)
    //setter pour l'attribut produitId permet d'accéder en écriture à l'attribut
    //cette méthode est une procédure (elle ne renvoie rien)
    /**
     * @param int $produitId
     * @param string $produitNom
     * @param float $produitPrix
     * @param string $produitImage
     */

    public function __construct(int $produitId, string $produitNom, float $produitPrix, string $produitImage)
    {
        $this->setProduitId($produitId);
        $this->setProduitNom($produitNom);
        $this->setProduitPrix($produitPrix);
        $this->setProduitImage($produitImage);
    }
    /*
    * @param string $produitId
    */
    public function setProduitId(int $produitId): void
    {
        $this->produitId = $produitId;
    }

    //getter pour l'attribut produitId permet d'accéder en lecture à l'attribut
    //cette méthode est une fonction (elle renvoie un résultat typé)
    public function getProduitId(): int
    {
        return $this->produitId;
    }

    /**
     * @return string
     */
    public function getProduitNom(): string
    {
        return $this->produitNom;
    }

    /**
     * @param string $produitNom
     */
    public function setProduitNom(string $produitNom): void
    {
        $this->produitNom = $produitNom;
    }

    /**
     * @return float
     */
    public function getProduitPrix(): float
    {
        return $this->produitPrix;
    }

    /**
     * @param float $produitPrix
     */
    public function setProduitPrix(float $produitPrix): void
    {
        if ($produitPrix >= 0) {
            $this->produitPrix = $produitPrix;
        } else {
            echo "LE PRIX DOIT ETRE SUPERIEUR A ZERO";
        }
    }

    /**
     * @return string
     */
    public function getProduitImage(): string
    {
        return $this->produitImage;
    }

    /**
     * @param string $produitImage
     */
    public function setProduitImage(string $produitImage): void
    {
        $this->produitImage = $produitImage;
    }


}