import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.io.Writer;
import java.util.List;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.text.PDFTextStripper;
import org.apache.pdfbox.text.TextPosition;

public class GetCharLocationAndSize extends PDFTextStripper {
    private String id;
    private String PosX;
    private String PosY;

    public GetCharLocationAndSize() throws IOException {
    }

    public String getId() {
        return this.id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getPosX() {
        return this.PosX;
    }

    public void setPosX(String newPosX) {
        this.PosX = newPosX;
    }

    public String getPosY() {
        return this.PosY;
    }

    public void setPosY(String newPosY) {
        this.PosY = newPosY;
    }

    public String SayHello() {
        return "HelloWorld";
    }

    public String GetKeyCharPosXY(String fileName, String KeyChar) throws IOException {
        PDDocument document = PDDocument.load(new File(fileName));
        PDFTextStripper stripper = new GetCharLocationAndSize();
        stripper.setSortByPosition(true);
        stripper.setStartPage(0);
        stripper.setEndPage(document.getNumberOfPages());
        Writer dummy = new OutputStreamWriter(new ByteArrayOutputStream());
        stripper.writeText(document, dummy);
        document.close();
        return this.getPosX() + "_" + this.getPosY();
    }

    @Override
    protected void writeString(String string, List<TextPosition> textPositions) throws IOException {
        // 1. Recherche prioritaire du repère "###"
        if (string.contains("###")) {
            int index = string.indexOf("###");
            if (index >= 0 && index < textPositions.size()) {
                TextPosition text = textPositions.get(index);
                this.setPosX(String.valueOf(text.getXDirAdj()));
                this.setPosY(String.valueOf(text.getYDirAdj()));
                System.out.println(text.getXDirAdj() + "_" + text.getYDirAdj());
                return;
            }
        }

        // 2. Recherche de secours du repère "#"
        for (TextPosition text : textPositions) {
            if (text.getUnicode().equals("#")) {
                this.setPosX(String.valueOf(text.getXDirAdj()));
                this.setPosY(String.valueOf(text.getYDirAdj()));
                System.out.println(text.getXDirAdj() + "_" + text.getYDirAdj());
                return;
            }
        }
    }

    public static void main(String[] args) throws IOException {
        if (args.length > 0) {
            PDDocument document = PDDocument.load(new File(args[0]));
            PDFTextStripper stripper = new GetCharLocationAndSize();
            stripper.setSortByPosition(true);
            stripper.setStartPage(0);
            stripper.setEndPage(document.getNumberOfPages());
            Writer dummy = new OutputStreamWriter(new ByteArrayOutputStream());
            stripper.writeText(document, dummy);
            document.close();
        }
    }
}
