package server.utils;

import java.io.*;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.zip.ZipEntry;
import java.util.zip.ZipOutputStream;

import static server.HDWcaptcha.getTimestamp;

public class LogerManager {
    private static final File folder = new File("logs/");
    private static final File last = new File("logs/last.txt");

    public static void SaveLog(String text) throws IOException {
        FileWriter fileWriter = new FileWriter(last, true);
        BufferedWriter bufferedWriter = new BufferedWriter(fileWriter);

        bufferedWriter.newLine();
        bufferedWriter.write(text);

        bufferedWriter.close();
    }

    public static void CheckSize() {
        String filePath = String.valueOf(last);
        String outputFolderPath = "logs/";
        long maxSizeInBytes = 20 * 1024 * 1024;

        File file = new File(filePath);
        long fileSizeInBytes = file.length();

        if (fileSizeInBytes > maxSizeInBytes) {
            String zipFileName = getZipFileName();

            try {
                String zipFilePath = outputFolderPath + zipFileName;
                zipFile(filePath, zipFilePath);
                
                last.delete();
                last.createNewFile();
                LogerManager.SaveLog(getTimestamp() + " Сервер запущен и ожидает подключений...");
            } catch (IOException ignored) {}
        }
    }

    public static void CheckFiles() throws IOException {
        if (!folder.exists()) folder.mkdir();
        if (!last.exists()) last.createNewFile();
    }

    private static String getZipFileName() {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd_HH-mm-ss");
        String timestamp = sdf.format(new Date());
        return "log_" + timestamp + ".zip";
    }

    private static void zipFile(String sourceFilePath, String zipFilePath) throws IOException {
        try (FileOutputStream fos = new FileOutputStream(zipFilePath);
             ZipOutputStream zos = new ZipOutputStream(fos);
             FileInputStream fis = new FileInputStream(sourceFilePath)) {

            ZipEntry zipEntry = new ZipEntry(new File(sourceFilePath).getName());
            zos.putNextEntry(zipEntry);

            byte[] buffer = new byte[1024];
            int bytesRead;
            while ((bytesRead = fis.read(buffer)) != -1) {
                zos.write(buffer, 0, bytesRead);
            }

            zos.closeEntry();
        }
    }
}
