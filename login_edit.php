<?php

    $host = "localhost";
    $username = "root";
    $password = ""; 
    $database = "users_db";
    
    //connect to database
    $conn = new mysqli($host, $username, $password, $database);

    $id="";
    $name = "";
    $email = "";
    $password ="";
    

    $errorMessage="";
    $successMessage="";


    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        //GET method:Show the data of client
        if(!isset($_GET["id"])){
            header("location: login_clients.php");
            exit();
        }

        $id = $_GET["id"];

        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(!$row){
            header("location: login_clients.php");
            exit();
        }

        $name = $row["name"];
        $email = $row["email"];
        $password = $row["password"];
        
       
    }
    else{
        //POST method: Update the data of client
        $id = $_POST["id"];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
       


       do{
            if(empty($name)||empty($email)||empty($password)){
                $errorMessage = "All fields are required";
                break;
            }

            
            $sql = "UPDATE users " .
             "SET name = '$name', email = '$email', password = '$password'".
            "WHERE id = $id";
            $result = $conn->query($sql);

            if(!$result){
                $errorMessage = "Invalid query: " . $conn->error;
                break;
            }

            $successMessage = "Client updated successfully!";

            header("location: login_clients.php");
            exit();
         }while(false);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login Clients</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>New Client</h2>
            <?php
            if( !empty($errorMessage)){
                echo"
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
            }
          
            ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" placeholder="Enter Name" value="<?php echo $name; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" name="email" placeholder="Enter Email" value="<?php echo $email; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">password</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="password" placeholder="Enter Password" value="<?php echo $password; ?>">
                    </div>
                </div>
                

                    <?php
                    if (!empty($successMessage)) {
                        echo "
                        <div class='row mb-3'>
                            <div class='offset-sm-3 col-sm-6'>
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <strong>$successMessage</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            </div>
                        </div>";
                    }
                    ?>
                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a href="login_clients.php" class="btn btn-outline-primary">Cancel</a>
                </div>
                
        </form>
    </div>
</body>
</html>