import java.io.IOException;

public class getXY {
    public static void main(String[] args) {
        try {
            String fileName = args[0];
            String position = args[1];
            GetCharLocationAndSize getCharPosXY_test = new GetCharLocationAndSize();
            String resultat = getCharPosXY_test.GetKeyCharPosXY(fileName, position);
            System.out.println(resultat);
        } catch (IOException e) {
            System.out.println(e.toString());
        }
    }
}
