package server.checker;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

public class KeyActiveChecker {
    private static final String DB_URL = "";
    private static final String DB_USERNAME = "";
    private static final String DB_PASSWORD = "";

    public static void main(String[] args) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection connection = DriverManager.getConnection(DB_URL, DB_USERNAME, DB_PASSWORD);

            while (true) {
                checkKeyExpiration(connection);
                Thread.sleep(300000);
            }
        } catch (ClassNotFoundException | SQLException | InterruptedException ignored) {}
    }

    private static void checkKeyExpiration(Connection connection) throws SQLException {
        String query = "SELECT username, keystart, keytype, active FROM hdwcaptchakeys";
        PreparedStatement statement = connection.prepareStatement(query);
        ResultSet resultSet = statement.executeQuery();

        LocalDateTime now = LocalDateTime.now();

        while (resultSet.next()) {
            String username = resultSet.getString("username");
            String targetDateStr = resultSet.getString("keystart");
            String keyType = resultSet.getString("keytype");
            boolean isActive = resultSet.getBoolean("active");

            if (!isActive) continue;

            DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss");
            LocalDateTime targetDate = LocalDateTime.parse(targetDateStr, formatter);

            if (now.isAfter(targetDate) && keyType != "Навсегда") {
                updateKeyStatus(connection, username, targetDateStr);
            }
        }

        resultSet.close();
        statement.close();
    }

    private static void updateKeyStatus(Connection connection, String username, String targetDateStr) throws SQLException {
        String updateQuery = "UPDATE hdwcaptchakeys SET active = ? WHERE username = ? AND keystart = ?";
        PreparedStatement updateStatement = connection.prepareStatement(updateQuery);
        updateStatement.setBoolean(1, false);
        updateStatement.setString(2, username);
        updateStatement.setString(3, targetDateStr);

        int updatedKeys = updateStatement.executeUpdate();

        System.out.println("Обновлено " + updatedKeys + " ключей для пользователя " + username + ". Ключи, срок которых истек, теперь неактивны.");
    }
}
