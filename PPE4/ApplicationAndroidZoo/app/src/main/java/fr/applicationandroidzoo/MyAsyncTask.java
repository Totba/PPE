package fr.applicationandroidzoo;

import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.widget.ProgressBar;
import android.widget.TextView;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Date;

import fr.applicationandroidzoo.jsp.ParamInfo;
import fr.applicationandroidzoo.jsp.ProgressInfo;
import fr.applicationandroidzoo.jsp.ResultInfo;
import fr.applicationandroidzoo.obj.Animal;
import fr.applicationandroidzoo.obj.Enclos;
import fr.applicationandroidzoo.obj.Espece;
import fr.applicationandroidzoo.obj.Soignant;

public class MyAsyncTask extends AsyncTask<ParamInfo, ProgressInfo, ResultInfo> {

    private final ProgressBar progressBar;
    private final TextView textViewInfo;
    private final String action;
    private final Context context;

    private final int PROGRESS_MAX;
    private int workCount = 0;
    private long startTimeInMillis;
    private int a = 0;

    /**
     * Une Async Task est une Tache qui s'éxécute en arriere plan<br>
     * elle s'execute dans l'ordre<br>
     * onPreExecute()<br>
     * doInBackground()<br>
     * onPostExecute()
     */
    public MyAsyncTask(ProgressBar progressBar, TextView textViewInfo, String action, Context context) {
        this.progressBar = progressBar;
        this.textViewInfo = textViewInfo;
        this.action = action;
        this.context = context;
        this.PROGRESS_MAX = this.progressBar.getMax();
    }

    @Override
    protected void onPreExecute() {
        this.progressBar.setVisibility(ProgressBar.VISIBLE);
        this.textViewInfo.setText("Chargement ...");
        updateProgressBar(0, action);
        this.startTimeInMillis = new Date().getTime();
    }

    @Override
    protected ResultInfo doInBackground(ParamInfo... params) {
//Selon le message l'on redirige vers la bonne fonction en fonction de l'action il faut execute

        if (action.equalsIgnoreCase("GetListSoignant")) {
            doinSoignant();

        } else {
            if (action.equalsIgnoreCase("GetListEspece")) {
                doinEspece();

            } else {
                if (action.equalsIgnoreCase("GetListAnimaux")) {
                    doinAnimaux();

                } else {
                    if (action.equalsIgnoreCase("GetListEnclos")) {
                        doinEnclos();

                    } else {
                        if (action.equalsIgnoreCase("MoveAnimal")) {
                            doinMoveAnimal();
                        }
                    }
                }
            }
        }


        long finishTimeInMillis = new Date().getTime();
        long workTimeInMillis = finishTimeInMillis - this.startTimeInMillis;
        ResultInfo result = new ResultInfo(true, workTimeInMillis);
        return result;
    }

    private void updateprogress(ProgressInfo progressInfo) {
        this.publishProgress(progressInfo);
    }

    @Override
    protected void onProgressUpdate(ProgressInfo... values) { // Progress ...values
        ProgressInfo progressInfo = values[0];

        int progress = progressInfo.getProgress();

        this.progressBar.setProgress(progress);
        this.textViewInfo.setText(progressInfo.getWorkingInfo());
    }

//Postexecute de l'AsyncTask
    @Override
    protected void onPostExecute(ResultInfo resultInfo) {
//Selon le message l'on redirige vers la bonne fonction Post en fonction de l'action il faut execute

        if (action.equalsIgnoreCase("GetListSoignant")) {
            PostSoignant();

        } else {
            if (action.equalsIgnoreCase("GetListEspece")) {
                PostEspece();

            } else {
                if (action.equalsIgnoreCase("GetListAnimaux")) {
                    PostAnimaux();

                } else {
                    if (action.equalsIgnoreCase("GetListEnclos")) {
                        PostEnclos();

                    } else {
                        if (action.equalsIgnoreCase("MoveAnimal")) {
                            PostMoveAnimal();
                        }
                    }
                }
            }
        }
    }

    @Override
    protected void onCancelled(ResultInfo resultInfo) {
    }

    public static void updateProgressBar(int prct, String Message) {
        ProgressInfo progressInfo = new ProgressInfo(prct, Message);
        MainActivity.myWorkTask.workCount = prct;
        MainActivity.myWorkTask.updateprogress(progressInfo);
    }

    public static int getProgressBar() {
        return MainActivity.myWorkTask.workCount;
    }

    /**
     * Le doInBackground executer pour les Soignants
     */
    private void doinSoignant() {
        try {
//updateProgressBar permet de changer le text et le pourcentage sur la MainActivity
            updateProgressBar(5, "Lancement Requete API");
//Appel API avec URL les Arguments et la methode
            String json = API.APIRequest(API.urlgetSoignant, null, "GET");
//String to JSONArray
            JSONArray jsona = new JSONArray(json);
            int a = 0;
            updateProgressBar(40, "Récupération des Soignants");

//Pour chaque Objet de la JSONArray
            while (a != jsona.length()) {

                JSONObject jsono = (JSONObject) jsona.get(a);
//Récupération des informations de l'objet
                String matricule = (String) jsono.get("matricule");
                String nomsoignant = (String) jsono.get("nomsoignant");
                String prenomsoignant = (String) jsono.get("prenomsoignant");
                String telsoignant = (String) jsono.get("telsoignant");

                updateProgressBar(((40/json.length()+1)*a), "Enregistrement du Soignant" + " " + (a + 1));

//Création d'un soignant
                Soignant soignant = new Soignant(Integer.parseInt(matricule), nomsoignant, prenomsoignant, telsoignant, false);
//Ajout du soignant des la liste API
                MainActivity.listsoignantAPI.add(soignant);

                a++;
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        updateProgressBar(80, "Vérification des soignants");
    }

    /**
     * Le onPostExecute executer pour les Soignants
     */
    private void PostSoignant() {

//Si des matricule du soignant du SQLite ne sont pas dans l'API, DELETE
        if (MainActivity.listsoignant.size() != 0) {
            int a = 0;
            while (a != MainActivity.listsoignant.size()) {
                Soignant soignant = MainActivity.listsoignant.get(a);

                int mat = soignant.getMatricule();

                Boolean contains = false;
                int b = 0;
                while (b != MainActivity.listsoignantAPI.size()) {
                    if (mat == MainActivity.listsoignantAPI.get(b).getMatricule()) {
                        contains = true;
                        break;
                    }
                    b++;
                }
                if (!contains) {
                    MainActivity.myDatabaseHelper.deleteSoignant(soignant);
                }
                a++;
            }
        }
        updateProgressBar(90, "Vérification des soignants");

//Si des matricule du soignant API ne sont pas dans le SQLite, INSERT
        if (MainActivity.listsoignantAPI.size() != 0) {
            int a = 0;
            while (a != MainActivity.listsoignantAPI.size()) {

                Soignant soignant = MainActivity.listsoignantAPI.get(a);

                int mat = soignant.getMatricule();

                Boolean contains = false;
                int b = 0;
                while (b != MainActivity.listsoignant.size()) {
                    if (mat == MainActivity.listsoignant.get(b).getMatricule()) {
                        contains = true;
                        break;
                    }
                    b++;
                }
                if (!contains) {
                    MainActivity.myDatabaseHelper.insertSoignant(soignant);
                }
                a++;
            }
        }
        MainActivity.listsoignantAPI = new ArrayList<>();

        updateProgressBar(95, "Soignants syncronisés");

//Si un soignant est connecter set MainActivity.soignantConnected
        for (Soignant soignant : MainActivity.listsoignant) {
            if (soignant.isConnected()) {
                MainActivity.soignantConnected = soignant;
            }
        }
//if un soignant estconnecter redirection vers choix espece
        if (MainActivity.soignantConnected != null) {
            updateProgressBar(100, "Redirection Gestion des especes");

            Intent intent = new Intent(context, ChoixEspece.class);
            context.startActivity(intent);

//sinon redirection vers Connexion
        } else {
            updateProgressBar(100, "Redirection Connexion");
            Intent intent = new Intent(context, Connexion.class);
            context.startActivity(intent);
        }
    }


    /**
     * Le doInBackground executer pour les Especes
     */
    private void doinEspece() {
        try {
            JSONObject jsonoo = new JSONObject();

            updateProgressBar(5, "Récupération des données");
            jsonoo.put("matricule", MainActivity.soignantConnected.getMatricule());

            updateProgressBar(10, "Lancement Requete API");
            String json = API.APIRequest(API.urlgetespsoi, jsonoo, "POST");
            JSONArray jsona = new JSONArray(json);
            int a = 0;
            updateProgressBar(40, "Récupération des Especes");
            while (a != jsona.length()) {
                JSONObject jsono = (JSONObject) jsona.get(a);
                String codeespece = (String) jsono.get("codeespece");
                String libelle = (String) jsono.get("libelle");

                updateProgressBar(((50/json.length()+1)*a), "Enregistrement de l'espece " + libelle);
                Espece espece = new Espece(codeespece, libelle);
                MainActivity.listespece.add(espece);

                a++;
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    /**
     * Le onPostExecute executer pour les Espece
     */
    private void PostEspece() {
        updateProgressBar(100, "Redirection choix de l'Especes");

        Intent intent = new Intent(context, ChoixEspece.class);
        Bundle extras = intent.getExtras();
        context.startActivity(intent);
    }


    /**
     * Le doInBackground executer pour les Animaux
     */
    private void doinAnimaux() {
        try {
            JSONObject jsonoo = new JSONObject();

            updateProgressBar(5, "Récupération des données");
            jsonoo.put("codeespece", MainActivity.espece.getCodeespece());

            updateProgressBar(10, "Lancement Requete API");
            String json = API.APIRequest(API.urlgetaniesp, jsonoo, "POST");
            JSONArray jsona = new JSONArray(json);

            a = 0;
            updateProgressBar(40, "Récupération des Especes");
            while (a != jsona.length()) {
                Animal animal;
                JSONObject jsono = (JSONObject) jsona.get(a);
                String nombapteme = (String) jsono.get("nombapteme");
                String sexe = (String) jsono.get("sexe");
                String dateNaissance = (String) jsono.get("dateNaissance");
                String dateDeces = (String) jsono.get("dateDeces");
                try {
                    String enclos = (String) jsono.get("enclos");
                    String code = (String) jsono.get("code");
                    updateProgressBar(((50/json.length()+1)*a), "Enregistrement de l'animal " + nombapteme);
                    animal = new Animal(MainActivity.espece.getCodeespece(), nombapteme, sexe, dateNaissance, dateDeces, new Enclos(code, enclos, "0", "0"));

                } catch (Exception e) {
                    animal = new Animal(MainActivity.espece.getCodeespece(), nombapteme, sexe, dateNaissance, dateDeces, null);
                }


                MainActivity.listanimaux.add(animal);

                a++;
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    /**
     * Le onPostExecute executer pour les Animaux
     */
    private void PostAnimaux() {
        updateProgressBar(100, "Redirection choix de l'animal");

        Intent intent = new Intent(context, ChoixAnimal.class);
        context.startActivity(intent);
    }


    /**
     * Le doInBackground executer pour les Enclos
     */
    private void doinEnclos() {
        try {
            JSONObject jsonoo = new JSONObject();
            updateProgressBar(5, "Récupération des données");
            jsonoo.put("codeespece", MainActivity.espece.getCodeespece());

            updateProgressBar(10, "Lancement Requete API");
//Récupération API json est égal a ce que l'API  renvoi
            String json = API.APIRequest(API.urlgetencesp, jsonoo, "POST");

//Création d'une liste d'objet avec la variable json
            JSONArray jsona = new JSONArray(json);
            int a = 0;
            updateProgressBar(40, "Récupération des enclos");
//Boucle pour chaque objet de la liste
            while (a != jsona.length()) {
//Récupération de l'objet
                JSONObject jsono = (JSONObject) jsona.get(a);
//Récupération des varaibles de l'object
                String nomenclos = (String) jsono.get("nom");
                String codeenclos = (String) jsono.get("id");
                String superficie = (String) jsono.get("superficie");
                String nb = (String) jsono.get("nb");

                updateProgressBar(((50/json.length()+1)*a), "Enregistrement de l'enclos " + nomenclos);
//création un enclos (prck la c'est les enclos)
                Enclos enclos = new Enclos(codeenclos, nomenclos, superficie, nb);

                if(MainActivity.animal.getenclos() != null) {
                    if(MainActivity.animal.getenclos().getCodeenclos() == enclos.getCodeenclos()) {
                        MainActivity.animal.setenclos(enclos);
                    }
                }
//Ajout de l'enclos dans la liste du MainActivity
                MainActivity.listenclos.add(enclos);

                a++;
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }


    /**
     * Le onPostExecute executer pour les Enclos
     */
    private void PostEnclos() {
        updateProgressBar(100, "Redirection choix de l'enclos");

        Intent intent = new Intent(context, ChoixEnclos.class);
        context.startActivity(intent);
    }

    /**
     * Le doInBackground executer pour déplacer l'animal
     */
    private void doinMoveAnimal() {
        try {
            JSONObject jsonoo = new JSONObject();

            updateProgressBar(10, "Récupération des Espece");
            jsonoo.put("codeespece", MainActivity.espece.getCodeespece());

            updateProgressBar(25, "Récupération des Nom");
            jsonoo.put("nombapteme", MainActivity.animal.getNombapteme());

            updateProgressBar(40, "Récupération des enclos");
            jsonoo.put("codeenclos", MainActivity.animal.getenclos().getCodeenclos());

            String json = API.APIRequest(API.urlMoveAnimal, jsonoo, "POST", 2.0);
            updateProgressBar(90, "Déplacement réussi");
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    /**
     * Le onPostExecute executer pour déplacer l'animal
     */
    private void PostMoveAnimal() {
        updateProgressBar(100, "Redirection choix de l'animal");

        Intent intent = new Intent(context, ChoixAnimal.class);
        context.startActivity(intent);
    }
}
