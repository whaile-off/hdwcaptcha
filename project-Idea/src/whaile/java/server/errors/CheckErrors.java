package server.errors;

import server.HDWcaptcha;
import server.utils.LogerManager;
import server.utils.VisualManager;

import java.io.IOException;
import java.io.OutputStream;
import java.util.Objects;

import static server.utils.SendClientManager.sendTextToClient;

public class CheckErrors {
    public static Boolean CheckConnect(String key, String hwid, String login, OutputStream outputStream, String ip) throws IOException, InterruptedException {
        if (Objects.equals(key, "")){

            String part_1 = HDWcaptcha.getTimestamp() + " Клиент: " + ip;
            String part_2 = " | " + Errors.no_key;

            part_1 = VisualManager.addSpaces(part_1, 35);
            LogerManager.SaveLog(part_1 + part_2);

            sendTextToClient(outputStream, Errors.no_key);
            Thread.sleep(1000);

            return false;
        } else if (Objects.equals(hwid, "")) {
            String part_1 = HDWcaptcha.getTimestamp() + " Клиент: " + ip;
            String part_2 = " | " + Errors.no_hwid;

            part_1 = VisualManager.addSpaces(part_1, 35);
            LogerManager.SaveLog(part_1 + part_2);

            sendTextToClient(outputStream, Errors.no_hwid);
            Thread.sleep(1000);

            return false;
        } else if (Objects.equals(login, "")) {
            String part_1 = HDWcaptcha.getTimestamp() + " Клиент: " + ip;
            String part_2 = " | " + Errors.no_login;

            part_1 = VisualManager.addSpaces(part_1, 35);
            LogerManager.SaveLog(part_1 + part_2);

            sendTextToClient(outputStream, Errors.no_login);
            Thread.sleep(1000);

            return false;
        }
        return true;
    }
}
