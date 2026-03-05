<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Clients </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>List of Clients</h2>
        <a href="/Web-Site/assist/college_create.php" class="btn btn-primary"> New Client</a>
        <br>

        <table class="table">
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>email</th>
                    <th>address</th>
                    <th>phone</th>
                    <th>birthdate</th>
                    <th>age</th>
                    <th>gender</th>
                    <th>course</th>
                    <th>year</th>
                    
                </tr>
            </thead>
            <tbody>

                  <?php
                  $host = "localhost";
                  $username = "root";
                 $password = "";
                 $database = "users_db";

                  $conn = new mysqli($host, $username, $password, $database);

                       if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                  $sql = "SELECT * FROM college_clients";
                   $result = $conn->query($sql);

                   if(!$result){
                     die("Invalid query: " . $conn->error);
                    }

                  while ($row = $result->fetch_assoc()) {
                       echo"<tr>
                        <td>$row[id]</td>
                        <td>$row[name]</td>
                        <td>$row[email]</td>
                        <td>$row[address]</td>
                        <td>$row[phone]</td>
                        <td>$row[birthdate]</td>
                        <td>$row[age]</td>
                        <td>$row[gender]</td>
                        <td>$row[course]</td>
                        <td>$row[year]</td>
                        <td>
                        <a class = 'btn btn-primary btn-sm' href='/Web-Site/assist/colle_edit.php?id=$row[id]'>Edit</a>
                        <a class = 'btn btn-danger btn-sm' href='/Web-Site/assist/college_delete.php?id=$row[id]'>Delete</a>
                       </td>

                     </tr>";
                    }
                ?>

               

            </tbody>
        </table>

    </div>
    
</body>
</html>