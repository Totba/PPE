package fr.applicationandroidzoo;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import fr.applicationandroidzoo.obj.Espece;

public class ChoixEspece extends AppCompatActivity {

// Similaire Connexion, Spinner -> ListView

    ListView lv;
    ArrayAdapter<Espece> especeadapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_choixespece);

        getSupportActionBar().setTitle(MainActivity.soignantConnected.getPrenomsoignant()+" "+MainActivity.soignantConnected.getNomsoignant());

        if(MainActivity.listespece != null) {

            if (MainActivity.listespece.size() == 0) {
                Intent intent = new Intent(MainActivity.context, MainActivity.class);
                Bundle bundle = new Bundle();
                bundle.putString("Whatload", "GetListEspece");
                intent.putExtra("Message", bundle);
                MainActivity.context.startActivity(intent);
            }
        } else {
            Intent intent = new Intent(MainActivity.context, MainActivity.class);
            Bundle bundle = new Bundle();
            bundle.putString("Whatload", "GetListEspece");
            intent.putExtra("Message", bundle);
            MainActivity.context.startActivity(intent);
        }

        lv = findViewById(R.id.listview);

        lv.setChoiceMode(ListView.CHOICE_MODE_SINGLE);

        especeadapter = new ArrayAdapter<Espece>(this,
                android.R.layout.simple_list_item_checked, android.R.id.text1, MainActivity.listespece);

        lv.setAdapter(especeadapter);

// fonction quand on clique sur la list view pour choisir
        lv.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

// Set dans MainActivity espece = a l'espece choisis
                MainActivity.espece = (Espece) lv.getItemAtPosition(lv.getCheckedItemPosition());

                Toast.makeText(ChoixEspece.this, MainActivity.espece.toString(), Toast.LENGTH_LONG).show();

//redirection choix animal
                Intent intent = new Intent(MainActivity.context, ChoixAnimal.class);
                MainActivity.context.startActivity(intent);
            }
        });
    }


    //Ajout du Menu
    @SuppressLint("ResourceType")
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menuwithout, menu);
        return (super.onCreateOptionsMenu(menu));
    }

    //EventHandler bouton du menu cliquer
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.Deconnection:
                MainActivity.Deconnexion(item);
                return true;
        }

        return super.onOptionsItemSelected(item);
    }
}