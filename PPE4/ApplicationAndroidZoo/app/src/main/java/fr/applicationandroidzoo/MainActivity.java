package fr.applicationandroidzoo;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.MenuItem;
import android.widget.ProgressBar;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import java.util.ArrayList;
import java.util.List;

import fr.applicationandroidzoo.jsp.ParamInfo;
import fr.applicationandroidzoo.obj.Animal;
import fr.applicationandroidzoo.obj.Enclos;
import fr.applicationandroidzoo.obj.Espece;
import fr.applicationandroidzoo.obj.Soignant;

//Cette class est l'activity afficher pendant les Appel API
public class MainActivity extends AppCompatActivity {

    public static Soignant soignantConnected = null;

    public static List<Soignant> listsoignant;
    public static List<Soignant> listsoignantAPI;

    public static List<Espece> listespece = new ArrayList<>();
    public static List<Animal> listanimaux = new ArrayList<>();
    public static List<Enclos> listenclos = new ArrayList<>();

    public static Context context;

    public static MyDatabaseHelper myDatabaseHelper;

    static MyAsyncTask myWorkTask;

    static ProgressBar progressBar;
    static TextView textViewInfo;

    public static Espece espece;
    public static Animal animal;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

//Set des informations principales de l'app

        context = this;

        getSupportActionBar().hide();

        myDatabaseHelper = new MyDatabaseHelper(this);

        listsoignant = myDatabaseHelper.getAllSoignant();

        listsoignantAPI = new ArrayList<>();

        this.progressBar = (ProgressBar) this.findViewById(R.id.progressBar);
        this.textViewInfo = (TextView) this.findViewById(R.id.textView_info);

//Pour faire un appel API, on redirige vers cette activity avec un message dans un bundle
        Bundle bundle = getIntent().getExtras();

        if (bundle != null) {

            Bundle bundle2 = bundle.getBundle("Message");

            String Whatload = bundle2.getString("Whatload");

//Selon le message l'on redirige vers la bonne fonction d'appel et de traitement des données API
            if (Whatload != null) {
                if (Whatload.equalsIgnoreCase("GetListSoignant")) {
                    LoadListSoignant();

                } else {
                    if (Whatload.equalsIgnoreCase("GetListEspece")) {
                        LoadListespece();

                    } else {
                        if (Whatload.equalsIgnoreCase("GetListAnimaux")) {
                            String codeespece = bundle2.getString("espece");
                            for (Espece espece : listespece) {
                                if (espece.getCodeespece().equalsIgnoreCase(codeespece)) {
                                    MainActivity.espece = espece;
                                }
                            }
                            LoadListanimaux();

                        } else {
                            if (Whatload.equalsIgnoreCase("GetListEnclos")) {
                                LoadListEnclos();

                            } else {

                                if (Whatload.equalsIgnoreCase("MoveAnimal")) {
                                    MoveAnimaux();

                                } else {
                                    LoadListSoignant();
                                }
                            }
                        }
                    }
                }
            } else {
                LoadListSoignant();
            }

        } else {
            LoadListSoignant();
        }
    }

//  fonctions d'appels et de traitement des données API

    /**
     * Execution de l'AsyncTask pour l'action GetListSoignant
     */
    public void LoadListSoignant() {
//Création d'une nouvelle AsyncTask avec en paramettre la progressBar et le text de MainActivity et quel action il faut execute
        this.myWorkTask = new MyAsyncTask(this.progressBar, this.textViewInfo, "GetListSoignant", this);

        ParamInfo param = new ParamInfo("Param 1", "Param 2");

//execution de l'AsyncTask
        this.myWorkTask.execute(param);
    }

    /**
     * Execution de l'AsyncTask pour l'action GetListEspece
     */
    public void LoadListespece() {
// Comme pour la fonction LoadListSoignant
        MainActivity.myWorkTask = new MyAsyncTask(MainActivity.progressBar, MainActivity.textViewInfo, "GetListEspece", this);

        ParamInfo param = new ParamInfo("Param 1", "Param 2");

        MainActivity.myWorkTask.execute(param);
    }

    /**
     * Execution de l'AsyncTask pour l'action GetListAnimaux
     */
    public void LoadListanimaux() {
// Comme pour la fonction LoadListSoignant
        MainActivity.myWorkTask = new MyAsyncTask(MainActivity.progressBar, MainActivity.textViewInfo, "GetListAnimaux", this);

        ParamInfo param = new ParamInfo("Param 1", "Param 2");

        MainActivity.myWorkTask.execute(param);
    }

    /**
     * Execution de l'AsyncTask pour l'action GetListEnclos
     */
    private void LoadListEnclos() {
// Comme pour la fonction LoadListSoignant
        MainActivity.myWorkTask = new MyAsyncTask(MainActivity.progressBar, MainActivity.textViewInfo, "GetListEnclos", this);

        ParamInfo param = new ParamInfo("Param 1", "Param 2");

        MainActivity.myWorkTask.execute(param);
    }

    /**
     * Execution de l'AsyncTask pour l'action MoveAnimal
     */
    private void MoveAnimaux() {
// Comme pour la fonction LoadListSoignant
        MainActivity.myWorkTask = new MyAsyncTask(MainActivity.progressBar, MainActivity.textViewInfo, "MoveAnimal", this);

        ParamInfo param = new ParamInfo("Param 1", "Param 2");

        MainActivity.myWorkTask.execute(param);
    }

    /**
     * Deconnexion du soignant connecter
     */
    public static void Deconnexion(MenuItem item) {
        MainActivity.soignantConnected.Deconnexion();
        MainActivity.myDatabaseHelper.updateSoignant(MainActivity.soignantConnected);
        MainActivity.soignantConnected = null;

        MainActivity.listespece = new ArrayList<>();
        MainActivity.listanimaux = new ArrayList<>();
        MainActivity.listenclos = new ArrayList<>();

        MainActivity.espece = null;
        MainActivity.animal = null;

        MainActivity.listsoignant = MainActivity.myDatabaseHelper.getAllSoignant();
        Intent intent = new Intent(MainActivity.context, Connexion.class);
        MainActivity.context.startActivity(intent);
    }

    /**
     * Retour a la page précédente<br>
     * retour correspond a la page actuelle
     */
    public static void Retour(String retour) {
        if(retour.equalsIgnoreCase("ChoixAnimal")) {
            MainActivity.listespece = new ArrayList<>();
            MainActivity.listanimaux = new ArrayList<>();
            MainActivity.listenclos = new ArrayList<>();

            MainActivity.espece = null;
            MainActivity.animal = null;

            Intent intent = new Intent(MainActivity.context, ChoixEspece.class);
            MainActivity.context.startActivity(intent);
        }
        if(retour.equalsIgnoreCase("ChoixEnclos")) {
            MainActivity.listanimaux = new ArrayList<>();
            MainActivity.listenclos = new ArrayList<>();

            MainActivity.animal = null;

            Intent intent = new Intent(MainActivity.context, ChoixAnimal.class);
            MainActivity.context.startActivity(intent);
        }
    }
}