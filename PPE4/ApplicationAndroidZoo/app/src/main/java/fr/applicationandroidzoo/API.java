package fr.applicationandroidzoo;

import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.nio.charset.StandardCharsets;

public class API {

    private static final String globalurl = "http://gr14.sio-cholet.fr/apiPPE4/methodes/";

    public static String urlgetSoignant = globalurl+"getListeSoignants.php";

    public static String urlgetespsoi = globalurl+"getEspeceSoignant.php";

    public static String urlgetaniesp = globalurl+"getListeAnimauxEspece.php";

    public static String urlgetencesp = globalurl+"getListeEnclosdispo.php";

    public static String urlMoveAnimal = globalurl+"placerOuDeplacerAnimal.php";

    private static Double multiplicateur;

    static String APIRequest(String url, JSONObject PostArg, String Method, Double Multiplicateur) throws Exception {
        multiplicateur = Multiplicateur;
        return APIRequest(url, PostArg, Method);
    }

    static String APIRequest(String url, JSONObject PostArg, String Method) throws Exception {
        if(multiplicateur == null) {
            multiplicateur = 1.0;
        }

        API.updateProgressBar((int) ((MainActivity.myWorkTask.getProgressBar()+3)*multiplicateur), "Préparation connexion API");
        StringBuffer response = null;
        String readLine = null;
        URL urlForGetRequest = new URL(url);

        API.updateProgressBar((int) ((MainActivity.myWorkTask.getProgressBar()+5)*multiplicateur), "Connexion API");
        HttpURLConnection conection = (HttpURLConnection) urlForGetRequest.openConnection();
        conection.setRequestMethod(Method);
        System.out.println(conection);
        if (PostArg != null) {
            API.updateProgressBar((int) ((MainActivity.myWorkTask.getProgressBar()+4)*multiplicateur), "Envoie des données");
            conection.setDoOutput(true);
            conection.setRequestProperty("Accept", "application/json");
            conection.setRequestProperty("Content-Type", "application/json");
            String data = PostArg.toString();
            byte[] out = data.getBytes(StandardCharsets.UTF_8);
            OutputStream stream = conection.getOutputStream();
            stream.write(out);

        } else {
            API.updateProgressBar((int) ((MainActivity.myWorkTask.getProgressBar()+4)*multiplicateur), "Connexion API");
        }

        API.updateProgressBar((int) ((MainActivity.myWorkTask.getProgressBar()+3)*multiplicateur), "Récupération des données");
        int responseCode = conection.getResponseCode();
        if (responseCode == 200) {
            BufferedReader in = new BufferedReader(new InputStreamReader(conection.getInputStream()));
            response = new StringBuffer();
            while ((readLine = in.readLine()) != null)
                response.append(readLine);
            in.close();
            conection.disconnect();
            return response.toString();
        }
        API.updateProgressBar((int) ((MainActivity.myWorkTask.getProgressBar()+5)*multiplicateur), "Données récupéré");
        conection.disconnect();
        return response.toString();
    }

    public static void updateProgressBar(int prct, String Message) {
        MainActivity.myWorkTask.updateProgressBar(prct, Message);
    }
}
