package fr.applicationandroidzoo;

import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import androidx.appcompat.app.AppCompatActivity;

import fr.applicationandroidzoo.obj.Animal;
import fr.applicationandroidzoo.obj.Espece;

public class ChoixAnimal extends AppCompatActivity {

    ListView lv;
    ArrayAdapter<Animal> animaladapter;

// Similaire choix espece

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_choixanimal);

        getSupportActionBar().setTitle(MainActivity.soignantConnected.getPrenomsoignant()+" "+MainActivity.soignantConnected.getNomsoignant());

        if(MainActivity.espece == null) {
            Bundle bundleget = getIntent().getExtras();

            if (bundleget != null) {

                Bundle bundle2 = bundleget.getBundle("Message");

                String codeespece = bundle2.getString("espece");
                for(Espece espece : MainActivity.listespece) {
                    if(espece.getCodeespece().equalsIgnoreCase(codeespece)) {
                        MainActivity.espece = espece;
                    }
                }
            }
        }

        if(MainActivity.listanimaux != null) {

            if (MainActivity.listanimaux.size() == 0) {
                Intent intent = new Intent(MainActivity.context, MainActivity.class);
                Bundle bundle = new Bundle();
                bundle.putString("Whatload", "GetListAnimaux");
                intent.putExtra("Message", bundle);
                MainActivity.context.startActivity(intent);

            } else {
            }
        } else {
            Intent intent = new Intent(MainActivity.context, MainActivity.class);
            Bundle bundle = new Bundle();
            bundle.putString("Whatload", "GetListAnimaux");
            intent.putExtra("Message", bundle);
            MainActivity.context.startActivity(intent);
        }

        lv = findViewById(R.id.listview);

        lv.setChoiceMode(ListView.CHOICE_MODE_SINGLE);

        animaladapter = new ArrayAdapter<Animal>(this,
                android.R.layout.simple_list_item_checked, android.R.id.text1, MainActivity.listanimaux);
        lv.setAdapter(animaladapter);

        lv.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

                MainActivity.animal = (Animal) lv.getItemAtPosition(lv.getCheckedItemPosition());

                Intent intent = new Intent(MainActivity.context, ChoixEnclos.class);
                MainActivity.context.startActivity(intent);
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
                MainActivity.Retour("ChoixAnimal");
                return true;
        }

        return super.onOptionsItemSelected(item);
    }
}