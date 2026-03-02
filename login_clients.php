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
        <a href="/Web-Site/assist/login_create.php" class="btn btn-primary"> New Client</a>
        <br>

        <table class="table">
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>email</th>
                    <th>password</th>
                    
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

                  $sql = "SELECT * FROM users";
                   $result = $conn->query($sql);

                   if(!$result){
                     die("Invalid query: " . $conn->error);
                    }

                  while ($row = $result->fetch_assoc()) {
                       echo"<tr>
                       <td>$row[id]</td>
                        <td>$row[name]</td>
                        <td>$row[email]</td>
                        <td>$row[password]</td>
                       
                        <td>
                        <a class = 'btn btn-primary btn-sm' href='/Web-Site/assist/login_edit.php?id=$row[id]'>Edit</a>
                        <a class = 'btn btn-danger btn-sm' href='/Web-Site/assist/login_delete.php?id=$row[id]'>Delete</a>
                       </td>

                     </tr>";
                    }
                ?>

               

            </tbody>
        </table>

    </div>
    
</body>
</html>