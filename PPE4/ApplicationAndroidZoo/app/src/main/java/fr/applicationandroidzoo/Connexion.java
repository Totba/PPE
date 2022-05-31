package fr.applicationandroidzoo;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Spinner;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import fr.applicationandroidzoo.obj.Soignant;

public class Connexion extends AppCompatActivity {

    Spinner spinner;
    ArrayAdapter<Soignant> soignantadapter;

// l'Activity Connexion et celles qui commence par Choix sont très similaire

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_connexion);

// hide du menu en haut pour faire plus beau
        getSupportActionBar().hide();

// Si la liste des soignants est null ou égal a 0 l'appli redirige vers MainActivity avec "GetListSoignant" dans le bundle
        if (MainActivity.listsoignant != null) {
            if (MainActivity.listsoignant.size() == 0) {
                Intent intent = new Intent(MainActivity.context, MainActivity.class);
                Bundle bundle = new Bundle();
                bundle.putString("Whatload", "GetListSoignant");
                intent.putExtra("Message", bundle);
                MainActivity.context.startActivity(intent);
            }
        } else {
            Intent intent = new Intent(MainActivity.context, MainActivity.class);
            Bundle bundle = new Bundle();
            bundle.putString("Whatload", "GetListSoignant");
            intent.putExtra("Message", bundle);
            MainActivity.context.startActivity(intent);
        }

// Récupération du spinner
        this.spinner = findViewById(R.id.spinner);

// Création de l'ArrayAdapter avec la liste des soignants
        soignantadapter = new ArrayAdapter<Soignant>(this,
                android.R.layout.simple_spinner_item, MainActivity.listsoignant);

        this.spinner.setAdapter(soignantadapter);
    }

// Fonction Trigger par le bouton connection
    public void GoSoignant(View view) {
        Spinner spinner = findViewById(R.id.spinner);
        Object obj = spinner.getSelectedItem();
        if (obj instanceof Soignant) {
// Set dans MainActivity soignant connecter = aux soignant choisis
            MainActivity.soignantConnected = (Soignant) obj;
            MainActivity.soignantConnected.Connexion();
            MainActivity.myDatabaseHelper.updateSoignant(MainActivity.soignantConnected);
        } else {
            Toast.makeText(this, "Erreur\nSoignant selectionner invalide", Toast.LENGTH_SHORT).show();
        }
//  Redirection choix espece
        Intent intent = new Intent(MainActivity.context, ChoixEspece.class);
        MainActivity.context.startActivity(intent);
    }
}