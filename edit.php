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
    $address="";
    $phone="";
    $birthdate="";
    $age="";
    $gender="";
    $strand="";
    $grade="";

    $errorMessage="";
    $successMessage="";


    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        //GET method:Show the data of client
        if(!isset($_GET["id"])){
            header("location: Shs_clients.php");
            exit();
        }

        $id = $_GET["id"];

        $sql = "SELECT * FROM shs_clients WHERE id = $id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(!$row){
            header("location: Shs_clients.php");
            exit();
        }

        $name = $row["name"];
        $email = $row["email"];
        $address = $row["address"];
        $phone = $row["phone"];
        $birthdate = $row["birthdate"];
        $age = $row["age"];
        $gender = $row["gender"];
        $strand = $row["strand"];
        $grade = $row["grade"];
       
    }
    else{
        //POST method: Update the data of client
        $id = $_POST["id"];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $birthdate = $_POST['birthdate'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $strand = $_POST['strand'];
        $grade = $_POST['grade'];


       do{
            if(empty($name)||empty($email)||empty($address)||empty($phone)||empty($birthdate)||empty($age)||empty($gender)||empty($strand)||empty($grade)){
                $errorMessage = "All fields are required";
                break;
            }

            
            $sql = "UPDATE shs_clients " .
             "SET name = '$name', email = '$email', address = '$address', phone = '$phone', birthdate = '$birthdate', age = '$age', gender = '$gender', strand = '$strand', grade = '$grade'".
            "WHERE id = $id";
            $result = $conn->query($sql);

            if(!$result){
                $errorMessage = "Invalid query: " . $conn->error;
                break;
            }

            $successMessage = "Client updated successfully!";

            header("location: Shs_clients.php");
            exit();
         }while(false);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shs Clients</title>
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
                    <label class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="address" placeholder="Enter Address" value="<?php echo $address; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="phone" placeholder="Enter Phone Number" value="<?php echo $phone; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Birthdate</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" name="birthdate" value="<?php echo $birthdate; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Age</label>
                    <div class="col-sm-6">
                        <input type = "number" min = "18" max = "100" step = "1" name = "age" placeholder = "Enter Age" class="form-control" value="<?php echo $age; ?>"/>
                    </div>    
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">gender</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="gender" placeholder="Enter Gender" value="<?php echo $gender; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">strand</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="strand" placeholder="Enter Strand" value="<?php echo $strand; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">grade</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="grade" placeholder="Enter Grade" value="<?php echo $grade; ?>">
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
                        <a href="Shs_clients.php" class="btn btn-outline-primary">Cancel</a>
                </div>
                
        </form>
    </div>
</body>
</html>