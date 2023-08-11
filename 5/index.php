<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Задание 5</title>
</head>
<body>
  <header>
    <h1>Задание 5</h1>
    <h2>Задание: С помощью php выведите из БД (дамп должен прилагаться к ТЗ) следующие данные. Количество пользователей, привязанных больше, чем к одной компании. Компании, в которых состоят только пользователи, не привязанные к другим компаниям.</h2>
  </header>
  <main>
    <?php
      $host = "localhost";
      $username = "root";
      $password = "mysql_root";
      $database = "meetorra_db";

      $connection = new mysqli($host, $username, $password, $database);

      if ($connection->connect_error) {
          die("Connection failed: " . $connection->connect_error);
      }

      // Количество пользователей, привязанных больше, чем к одной компании
      $users_with_multiple_companies = "SELECT COUNT(*) AS user_count
      FROM (
        -- получаем список пользователей и всех компаний, к которым они привязаны
        SELECT u.user_id
        FROM user u
        JOIN company_user cu ON u.user_id = cu.user_id
        -- группируем ряды по юзеру, чтобы мы могли посчитать их количество
        GROUP BY u.user_id
        -- выбираем только те ряды, где количество компаний больше 1
        HAVING COUNT(DISTINCT cu.company_id) > 1
      ) AS users_with_multiple_companies;";
      $result = $connection->query($users_with_multiple_companies);
      
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // результат = 2
          ?>
          <div>Количество пользователей, привязанных больше, чем к одной компании: <?php print_r($row);?></div>
          <?php
        }
      } else {
          echo "No results found.";
      }

      // Компании, в которых состоят только пользователи, не привязанные к другим компаниям
      $companies_with_exclusive_users = "SELECT c.company_name
      -- связываем компании и информацию о них с пользователями, которые к ним привязаны, и информацией о них
      FROM company c
      JOIN company_user cu ON c.company_id = cu.company_id
      JOIN user u ON cu.user_id = u.user_id
      -- находим компании, в которых состоят пользователи, которые привязаны к нескольким компаниям
      LEFT JOIN (
        SELECT DISTINCT cu.company_id
        FROM company_user cu
        JOIN user u ON cu.user_id = u.user_id
        LEFT JOIN company_user cu2 ON u.user_id = cu2.user_id AND cu.company_id != cu2.company_id
        WHERE cu2.company_id IS NOT NULL
      ) multiple_companies ON c.company_id = multiple_companies.company_id
      -- исключаем эти компании, оставляя только те, в которых состоят пользователи, привязанные к 0 или 1 компании
      WHERE multiple_companies.company_id IS NULL
      GROUP BY c.company_id, c.company_name;";
      $result = $connection->query($companies_with_exclusive_users);
      
      if ($result->num_rows > 0) {
        ?>
        <div>Компании, в которых состоят только пользователи, не привязанные к другим компаниям:
          <?php
          // результат = 3 и 5 компания
          while ($row = $result->fetch_assoc()) {
            print_r($row);
          }
        ?>
        </div>
        <?php
      } else {
          echo "No results found.";
      }

      $connection->close();
    ?>
  </main>
</body>
</html>