package fr.applicationandroidzoo.obj;

import fr.applicationandroidzoo.MainActivity;

public class Animal {

    private String codeespece;
    private String nombapteme;
    private String sexe;
    private String dateNaissance;
    private String dateDeces;
    private Enclos enclos;

    public Animal(String codeespece, String nombapteme, String sexe, String dateNaissance, String dateDeces, Enclos enclos) {
        this.codeespece = codeespece;
        this.nombapteme = nombapteme;
        this.sexe = sexe;
        this.dateNaissance = dateNaissance;
        this.dateDeces = dateDeces;
        this.enclos = enclos;
    }

    public String getCodeespece() {
        return codeespece;
    }

    public String getNombapteme() {
        return nombapteme;
    }

    public void setNombapteme(String nombapteme) {
        this.nombapteme = nombapteme;
    }

    public String getSexe() {
        return sexe;
    }

    public void setSexe(String sexe) {
        this.sexe = sexe;
    }

    public String getDateNaissance() {
        return dateNaissance;
    }

    public void setDateNaissance(String dateNaissance) {
        this.dateNaissance = dateNaissance;
    }

    public String getDateDeces() {
        return dateDeces;
    }

    public void setDateDeces(String dateDeces) {
        this.dateDeces = dateDeces;
    }

    public Enclos getenclos() {
        return enclos;
    }

    public void setenclos(Enclos enclos) {
        this.enclos = enclos;
    }

    public String toString() {
        String enclos = "";
        if (this.enclos == null) {
            enclos = "      aucun enclos";

        } else {
            enclos = "      enclos : " + this.enclos.getNom();
        }
        return MainActivity.espece.getLibelle() + "   " + this.nombapteme + " " + enclos;
    }
}
