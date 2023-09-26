package server.utils;

public class VisualManager {
    public static String addSpaces(String str, int length) {
        for (int i = str.length(); i < length; i++) {
            str += " ";
        }
        return str;
    }
}
