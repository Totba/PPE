package fr.applicationandroidzoo.obj;

import fr.applicationandroidzoo.MainActivity;

public class Enclos {
    private String codeenclos;
    private String nom;
    private String superficie;
    private String nombre;

    public Enclos(String codeenclos, String nom, String superficie, String nombre) {
        this.codeenclos = codeenclos;
        this.nom = nom;
        this.superficie = superficie;
        this.nombre = nombre;
    }

    public String getCodeenclos() {
        return codeenclos;
    }

    public void setCodeenclos(String codeenclos) {
        this.codeenclos = codeenclos;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getSuperficie() {
        return superficie;
    }

    public void setSuperficie(String superficie) {
        this.superficie = superficie;
    }

    public String getNombre() {
        return nombre;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public String toString() {
        if (MainActivity.animal != null) {
            if (MainActivity.animal.getenclos() != null) {
                if (this == MainActivity.animal.getenclos()) {
                    return getNom() + " (Enclos actuelle) \n nb : " + getNombre() + "   Superficie: " + getSuperficie();

                } else {
                    return getNom() + "\n nb : " + getNombre() + "   Superficie: " + getSuperficie();
                }
                
            } else {
                return getNom() + "\n nb : " + getNombre() + "   Superficie: " + getSuperficie();
            }

        } else {
            return getNom() + "\n nb : " + getNombre() + "   Superficie: " + getSuperficie();
        }
    }
}
