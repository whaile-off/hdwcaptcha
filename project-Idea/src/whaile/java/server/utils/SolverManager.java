package server.utils;

import server.errors.Errors;

import java.io.OutputStream;
import java.util.Objects;

import static server.HDWcaptcha.getTimestamp;
import static server.utils.SendClientManager.sendTextToClient;

public class SolverManager {
    public static void solver(byte[] imageBytes, String ip, OutputStream outputStream, String mod, String login) {
        try {
            if (Objects.equals(mod, "all")) {
                //TODO solver
            } else if (Objects.equals(mod, "int") && DatabaseManager.sub(login, "int")) {
                //TODO solver
            } else if (Objects.equals(mod, "eng") && DatabaseManager.sub(login, "eng")) {
                //TODO solver
            } else if (Objects.equals(mod, "rus") && DatabaseManager.sub(login, "rus")) {
                //TODO solver
            } else {
                SendClientManager.sendTextToClient(outputStream, Errors.no_sub_bd);
                return;
            }

            String code = "ответ";

            String part_1 = getTimestamp() + " Клиент: " + ip;
            String part_2 = " | Ответ: " + code;

            part_1 = VisualManager.addSpaces(part_1, 35);

            System.out.println(part_1 + part_2);
            LogerManager.SaveLog(part_1 + part_2);

            DatabaseManager.captcha(login);
            sendTextToClient(outputStream, code);
        } catch (Exception ignored) {}
    }
}
