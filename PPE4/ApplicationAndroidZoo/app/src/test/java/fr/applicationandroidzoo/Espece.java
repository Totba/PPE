package fr.applicationandroidzoo;

public class Espece {

    public String codeespece;
    public String libelle;

    public Espece(String codeespece, String libelle) {
        this.codeespece = codeespece;
        this.libelle = libelle;
    }

    public String getCodeespece() {
        return codeespece;
    }

    public String getLibelle() {
        return libelle;
    }
}
