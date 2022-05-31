package fr.applicationandroidzoo.obj;

public class Soignant {
    int matricule;
    String nomsoignant;
    String prenomsoignant;
    String telsoignant;
    boolean connected;

    public Soignant(int matricule, String nomsoignant, String prenomsoignant, String telsoignant, boolean connected) {
        this.matricule = matricule;
        this.nomsoignant = nomsoignant;
        this.prenomsoignant = prenomsoignant;
        this.telsoignant = telsoignant;
        this.connected = connected;
    }

    public int getMatricule() {
        return matricule;
    }

    public String getNomsoignant() {
        return nomsoignant;
    }

    public void setNomsoignant(String nomsoignant) {
        this.nomsoignant = nomsoignant;
    }

    public String getPrenomsoignant() {
        return prenomsoignant;
    }

    public void setPrenomsoignant(String prenomsoignant) {
        this.prenomsoignant = prenomsoignant;
    }

    public String getTelsoignant() {
        return telsoignant;
    }

    public void setTelsoignant(String telsoignant) {
        this.telsoignant = telsoignant;
    }

    public boolean isConnected() {
        return connected;
    }

    public void Connexion() {
        this.connected = true;
    }

    public void Deconnexion() {
        this.connected = false;
    }

    public String toString(){
        return this.nomsoignant+" "+this.prenomsoignant+" "+this.telsoignant;
    }
}
