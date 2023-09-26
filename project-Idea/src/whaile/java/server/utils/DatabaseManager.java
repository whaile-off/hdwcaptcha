package server.utils;

import server.errors.Errors;

import java.io.IOException;
import java.io.OutputStream;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import static server.utils.SendClientManager.sendTextToClient;

public class DatabaseManager {
    private static final String DB_URL = "jdbc:mysql://65.21.114.251:3306/hdw";
    private static final String DB_USERNAME = "whaile";
    private static final String DB_PASSWORD = "Astra78563412!";

    public static boolean key(String login, String key, OutputStream outputStream) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection connection = DriverManager.getConnection(DB_URL, DB_USERNAME, DB_PASSWORD);

            String query = "SELECT * FROM hdwcaptchakeys WHERE username = ? AND secret = ?";
            PreparedStatement statement = connection.prepareStatement(query);
            statement.setString(1, login);
            statement.setString(2, key);

            ResultSet resultSet = statement.executeQuery();

            if (resultSet.next()) {
                resultSet.close();
                statement.close();
                connection.close();
                return true;
            } else {
                sendTextToClient(outputStream, Errors.no_in_bd);
                Thread.sleep(1000);
                return false;
            }
        } catch (ClassNotFoundException | SQLException | IOException | InterruptedException ignored) {}
        return false;
    }

    public static boolean hwid(String key, String hwid, OutputStream outputStream) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection connection = DriverManager.getConnection(DB_URL, DB_USERNAME, DB_PASSWORD);

            String querySelect = "SELECT * FROM hdwcaptchakeys WHERE secret = ?";
            PreparedStatement selectStatement = connection.prepareStatement(querySelect);
            selectStatement.setString(1, key);

            ResultSet resultSet = selectStatement.executeQuery();

            if (resultSet.next()) {
                String savedHwid = resultSet.getString("hwid");
                if (savedHwid == null) {
                    String queryUpdate = "UPDATE hdwcaptchakeys SET hwid = ? WHERE secret = ?";
                    PreparedStatement updateStatement = connection.prepareStatement(queryUpdate);
                    updateStatement.setString(1, hwid);
                    updateStatement.setString(2, key);
                    updateStatement.executeUpdate();
                    updateStatement.close();

                    resultSet.close();
                    selectStatement.close();
                    connection.close();
                    return true;
                } else if (hwid.equals(savedHwid)) {
                    resultSet.close();
                    selectStatement.close();
                    connection.close();
                    return true;
                } else {
                    sendTextToClient(outputStream, Errors.no_in_bd);
                    Thread.sleep(1000);
                    resultSet.close();
                    selectStatement.close();
                    connection.close();
                    return false;
                }
            } else {
                sendTextToClient(outputStream, Errors.no_in_bd);
                Thread.sleep(1000);
                resultSet.close();
                selectStatement.close();
                connection.close();
                return false;
            }
        } catch (ClassNotFoundException | SQLException | IOException | InterruptedException ignored) {
            return false;
        }
    }

    public static boolean captcha(String login) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection connection = DriverManager.getConnection(DB_URL, DB_USERNAME, DB_PASSWORD);

            String updateQuery = "UPDATE hdwcaptchasite SET captchas = captchas + 1 WHERE username = ?";
            PreparedStatement preparedStatement = connection.prepareStatement(updateQuery);
            preparedStatement.setString(1, login);

            int rowsUpdated = preparedStatement.executeUpdate();
            preparedStatement.close();
            connection.close();

            if (rowsUpdated > 0) {
                return true;
            } else {
                return false;
            }

        } catch (ClassNotFoundException | SQLException ignored) {
            return false;
        }
    }

    public static boolean sub(String username, String subtype) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection connection = DriverManager.getConnection(DB_URL, DB_USERNAME, DB_PASSWORD);

            String query = "SELECT COUNT(*) FROM hdwcaptchasube WHERE username = ? AND subetype LIKE ?";
            PreparedStatement preparedStatement = connection.prepareStatement(query);
            preparedStatement.setString(1, username);
            preparedStatement.setString(2, "%" + subtype + "%");

            ResultSet resultSet = preparedStatement.executeQuery();
            resultSet.next();
            int count = resultSet.getInt(1);

            resultSet.close();
            preparedStatement.close();
            connection.close();

            return count > 0;

        } catch (ClassNotFoundException | SQLException ignored) {
            return false;
        }
    }
}
