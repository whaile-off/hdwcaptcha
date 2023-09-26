package api.api;

import javax.imageio.ImageIO;
import java.awt.image.BufferedImage;
import java.io.*;
import java.net.Socket;

public class HDWapi {

    public static String serverAddress = "127.0.0.1";
    public static int serverPort = 8080;

    public static String api(File captcha, String key, String login, String mod) {
        try (Socket socket = new Socket(serverAddress, serverPort)) {
            OutputStream outputStream = socket.getOutputStream();

            String hwid = System.getProperty("user.name") +
                    System.getenv("PROCESSOR_IDENTIFIER") +
                    System.getenv("PROCESSOR_ARCHITECTURE") +
                    System.getenv("PROCESSOR_LEVEL") +
                    System.getProperty("os.arch");
            sendTextToServer(outputStream, hwid);
            sendTextToServer(outputStream, key);
            sendTextToServer(outputStream, login);
            sendTextToServer(outputStream, mod);

            byte[] captchaBytes = convertImageByte(captcha);
            outputStream.write(captchaBytes);
            outputStream.flush();

            socket.shutdownOutput();

            byte[] receivedBytes = receiveBytesFromServer(socket);
            String receivedMessage = new String(receivedBytes);

            return receivedMessage;

        } catch (IOException ignored) {
            return null;
        }
    }

    private static void sendTextToServer(OutputStream outputStream, String message) throws IOException {
        outputStream.write(message.getBytes());
        outputStream.write('\n');
        outputStream.flush();
    }

    private static byte[] receiveBytesFromServer(Socket socket) throws IOException {
        InputStream inputStream = socket.getInputStream();
        ByteArrayOutputStream outputStream = new ByteArrayOutputStream();

        byte[] buffer = new byte[4096];
        int bytesRead;
        while ((bytesRead = inputStream.read(buffer)) != -1) {
            outputStream.write(buffer, 0, bytesRead);
        }

        byte[] receivedBytes = outputStream.toByteArray();

        outputStream.close();
        inputStream.close();

        return receivedBytes;
    }

    private static byte[] convertImageByte(File file) {
        BufferedImage image = null;
        try {
            image = ImageIO.read(file);
        } catch (IOException ignored) {}

        ByteArrayOutputStream outputStream = new ByteArrayOutputStream();
        try {
            assert image != null;
            ImageIO.write(image, "png", outputStream);
        } catch (IOException ignored) {}

        return outputStream.toByteArray();
    }
}