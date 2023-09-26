package api;

import java.io.File;

import static api.api.HDWapi.api;

public class ExampleSolver {

    private static final File file = new File("captcha/693842801120.png");

    public static void main(String[] args) {
        System.out.println(api(file, "", "", "all"));
    }
}
