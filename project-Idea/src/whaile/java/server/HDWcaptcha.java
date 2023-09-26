package server;

import org.apache.commons.io.IOUtils;
import server.errors.CheckErrors;
import server.utils.ConverterManager;
import server.utils.DatabaseManager;
import server.utils.LogerManager;

import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;
import java.time.LocalTime;

import static server.utils.SolverManager.solver;

public class HDWcaptcha {

    private static final int port = 8080;

    public static void main(String[] args) throws IOException {

        LogerManager.CheckFiles();
        new Thread(() -> { while (true) LogerManager.CheckSize(); }).start();

        try (ServerSocket serverSocket = new ServerSocket(port)) {

            System.out.println(getTimestamp() + " Сервер запущен и ожидает подключений...");
            LogerManager.SaveLog(getTimestamp() + " Сервер запущен и ожидает подключений...");

            while (true) {
                Socket clientSocket = serverSocket.accept();
                String ip = clientSocket.getInetAddress().getHostAddress();

                new Thread(() -> handleClient(clientSocket, ip)).start();
            }
        } catch (IOException ignored) {}
    }

    private static void handleClient(Socket clientSocket, String ip) {
        try (InputStream inputStream = clientSocket.getInputStream();
             OutputStream outputStream = clientSocket.getOutputStream();
             BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream))) {

            String hwid = bufferedReader.readLine();
            String key = bufferedReader.readLine();
            String login = bufferedReader.readLine();
            String mod = bufferedReader.readLine();

            if (CheckErrors.CheckConnect(key, hwid, login, outputStream, ip)) {
                if (DatabaseManager.key(login, key, outputStream) && DatabaseManager.hwid(key, hwid, outputStream)) {
                    byte[] imageBytes = IOUtils.toByteArray(inputStream);
                    byte[] newImageBytes = ConverterManager.convertImageTo256x256(imageBytes, 130, 50);

                    solver(newImageBytes, ip, outputStream, mod, login);
                }
            }

        } catch (IOException | InterruptedException ignored) {}
    }

    public static String getTimestamp() {
        String getTime = LocalTime.now().toString();
        return "[" + getTime.substring(0, getTime.length() - 4) + "]";
    }
}