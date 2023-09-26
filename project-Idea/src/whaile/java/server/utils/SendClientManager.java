package server.utils;

import java.io.IOException;
import java.io.OutputStream;

public class SendClientManager {
    public static void sendTextToClient(OutputStream outputStream, String message) throws IOException {
        if (message != null && !message.isEmpty()) {
            outputStream.write(message.getBytes());
            outputStream.flush();
        }
    }
}
