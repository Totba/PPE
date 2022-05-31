package fr.applicationandroidzoo;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

import androidx.annotation.Nullable;

import java.util.ArrayList;
import java.util.List;

import fr.applicationandroidzoo.obj.Soignant;

public class MyDatabaseHelper extends SQLiteOpenHelper {

    private final static fr.applicationandroidzoo.API API = new API();

    private static final String TAG = "SQLite";

    private static final String TABLE_SPE = "Soignant";

    private static final String COLUMN_SPE_matricule = "matricule";

    private static final String COLUMN_SPE_nomsoignant = "nomsoignant";

    private static final String COLUMN_SPE_prenomsoignant = "prenomsoignant";

    private static final String COLUMN_SPE_telsoignant = "telsoignant";

    private static final String COLUMN_SPE_connected = "connected";

    //*******
    private static final String Personne_TABLE_CREATE =
            "CREATE TABLE Soignant(matricule INTEGER PRIMARY KEY AUTOINCREMENT," +
                    "nomsoignant TEXT," +
                    "prenomsoignant TEXT," +
                    "telsoignant TEXT," +
                    "connected INTEGER)";
    private static final String DB_NAME = "Soignant.sqlite";
    private static final int DB_VERSION = 1;
    private SQLiteDatabase db;
    //*******


    public MyDatabaseHelper(Context context) {
        super(context, DB_NAME, null, DB_VERSION);
        SQLiteDatabase db = this.getWritableDatabase();
        this.db = db;
    }

    public MyDatabaseHelper(@Nullable Context context, @Nullable String name, @Nullable SQLiteDatabase.CursorFactory factory, int version) {
        super(context, name, factory, version);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        Log.i(TAG, "MyDatabaseHelper.onCreate");
        db.execSQL(Personne_TABLE_CREATE);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {

    }

    public void insertSoignant(String nomsoignant, String prenomsoignant, String telsoignant, Boolean connected) {
        ContentValues cv = new ContentValues();
        cv.put("nomsoignant", nomsoignant);
        cv.put("prenomsoignant", prenomsoignant);
        cv.put("telsoignant", telsoignant);
        cv.put("connected", connected ? 1 : 0);
        db.insert(TABLE_SPE, null, cv);
    }

    public void insertSoignant(Soignant soignant) {
        ContentValues cv = new ContentValues();
        cv.put("matricule", soignant.getMatricule());
        cv.put("nomsoignant", soignant.getNomsoignant());
        cv.put("prenomsoignant", soignant.getPrenomsoignant());
        cv.put("telsoignant", soignant.getTelsoignant());
        cv.put("connected", soignant.isConnected() ? 1 : 0);
        db.insert(TABLE_SPE, null, cv);
    }

    public Soignant getSoignant(int id) {
        Log.i(TAG, "MyDatabaseHelper.getPersonne..." + id);
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor cursor = db.query(TABLE_SPE, new String[]{COLUMN_SPE_matricule, COLUMN_SPE_nomsoignant, COLUMN_SPE_prenomsoignant, COLUMN_SPE_telsoignant, COLUMN_SPE_connected}, COLUMN_SPE_matricule + "+?",
                new String[]{String.valueOf(id)},
                null, null, null, null);
        if (cursor != null)
            cursor.moveToFirst();
        Soignant soignant = new Soignant(
                cursor.getInt(0),
                cursor.getString(1),
                cursor.getString(2),
                cursor.getString(3),
                (cursor.getInt(4) == 1));
        return soignant;
    }

    public List<Soignant> getAllSoignant() {
        Log.i(TAG, "MyDatabaseHelper.getAllPersonnes...");
        List<Soignant> soignantList = new ArrayList<>();

        String selectQuery = "SELECT * FROM " + TABLE_SPE;

        SQLiteDatabase db = this.getWritableDatabase();
        Cursor cursor = db.rawQuery(selectQuery, null);

        if (cursor.moveToFirst()) {
            do {
                Soignant soignant = new Soignant(
                        cursor.getInt(0),
                        cursor.getString(1),
                        cursor.getString(2),
                        cursor.getString(3),
                        (cursor.getInt(4) == 1));
                soignantList.add(soignant);
            } while (cursor.moveToNext());
        }
        return soignantList;
    }

    public void updateSoignant(Soignant soignant) {
        Log.i(TAG, "MyDatabaseHelper.updatePersonne..." + soignant);
        SQLiteDatabase db = this.getWritableDatabase();

        ContentValues cv = new ContentValues();
        cv.put("nomsoignant", soignant.getNomsoignant());
        cv.put("prenomsoignant", soignant.getPrenomsoignant());
        cv.put("telsoignant", soignant.getTelsoignant());
        cv.put("connected", soignant.isConnected());

        db.update(TABLE_SPE, cv, COLUMN_SPE_matricule + " = ? ",
                new String[]{Integer.toString(soignant.getMatricule())});
    }

    public void deleteSoignant(Soignant soignant) {
        Log.i(TAG, "MyDatabaseHelper.deletePersonne..." + soignant);
        SQLiteDatabase db = this.getWritableDatabase();
        db.delete(TABLE_SPE, COLUMN_SPE_matricule + " =? ",
                new String[]{String.valueOf(soignant.getMatricule())});
    }
}
