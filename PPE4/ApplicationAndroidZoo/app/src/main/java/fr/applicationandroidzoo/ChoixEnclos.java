package fr.applicationandroidzoo;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import fr.applicationandroidzoo.obj.Enclos;

public class ChoixEnclos extends AppCompatActivity {

    ListView lv;
    ArrayAdapter<Enclos> enclosadapter;
    TextView tv;
    AlertDialog.Builder builder;

// Similaire choix espece

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_choixenclos);

        getSupportActionBar().setTitle(MainActivity.soignantConnected.getPrenomsoignant() + " " + MainActivity.soignantConnected.getNomsoignant());

        if (MainActivity.listenclos != null) {

            if (MainActivity.listenclos.size() == 0) {
                Intent intent = new Intent(MainActivity.context, MainActivity.class);
                Bundle bundle = new Bundle();
                bundle.putString("Whatload", "GetListEnclos");
                intent.putExtra("Message", bundle);
                MainActivity.context.startActivity(intent);

            }
        } else {
            Intent intent = new Intent(MainActivity.context, MainActivity.class);
            Bundle bundle = new Bundle();
            bundle.putString("Whatload", "GetListEnclos");
            intent.putExtra("Message", bundle);
            MainActivity.context.startActivity(intent);
        }

        builder = new AlertDialog.Builder(this);

        lv = findViewById(R.id.listview);

        lv.setChoiceMode(ListView.CHOICE_MODE_SINGLE);

        enclosadapter = new ArrayAdapter<Enclos>(this,
                android.R.layout.simple_list_item_checked, android.R.id.text1, MainActivity.listenclos);
        lv.setAdapter(enclosadapter);

        tv = findViewById(R.id.textView2);

        tv.setText(tv.getText() + "\n de " + MainActivity.animal.getNombapteme());

        lv.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

                Enclos enclos = (Enclos) lv.getItemAtPosition(lv.getCheckedItemPosition());

// Création Alert avec le text et les choix

                //Setting message manually and performing action on button click
                builder.setMessage("Voulez vous vraiment envoyer le " + MainActivity.espece + " " + MainActivity.animal.getNombapteme() + " dans l'enclos " + enclos.getNom()).setCancelable(false)

                        .setPositiveButton("OUI", new DialogInterface.OnClickListener() {
//Quand on clique sur OUI
                            public void onClick(DialogInterface dialog, int id) {
                                Toast.makeText(getApplicationContext(), MainActivity.animal.getNombapteme() + " a été envoyer dans l'enclos " + enclos.getNom(), Toast.LENGTH_SHORT).show();

                                MainActivity.animal.setenclos(enclos);

                                System.out.println(MainActivity.animal);

                                Intent intent = new Intent(MainActivity.context, MainActivity.class);
                                Bundle bundle = new Bundle();
                                bundle.putString("Whatload", "MoveAnimal");
                                intent.putExtra("Message", bundle);
                                MainActivity.context.startActivity(intent);

                                lv.setAdapter(enclosadapter);
                            }
                        })

                        .setNegativeButton("NON", new DialogInterface.OnClickListener() {
//Quand on clique sur NON
                            public void onClick(DialogInterface dialog, int id) {
                                //  Action for 'NO' Button
                                dialog.cancel();

                                lv.setAdapter(enclosadapter);
                            }
                        });
                //Creating dialog box
                AlertDialog alert = builder.create();
                //Setting the title manually
                alert.setTitle("Déplacement Animaux");
                alert.show();
            }
        });
    }

    //Ajout du Menu
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu, menu);
        return (super.onCreateOptionsMenu(menu));
    }

    //EventHandler bouton du menu cliquer
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.Deconnection:
                MainActivity.Deconnexion(item);
                return true;
            case R.id.Retour:
                MainActivity.Retour("ChoixEnclos");
                return true;
        }

        return super.onOptionsItemSelected(item);
    }
}