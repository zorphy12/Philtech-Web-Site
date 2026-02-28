<?php

    $host = "localhost";
    $username = "root";
    $password = ""; 
    $database = "users_db";
    
    //connect to database
    $conn = new mysqli($host, $username, $password, $database);


    $name = "";
    $email = "";
    $address = "";
    $phone = "";
    $birthdate = "";
    $age = "";
    $gender = "";
    $strand = "";
    $grade = ""; 

    $errorMessage = "";
    $successMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
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

             //add new client to database

         $sql = "INSERT INTO shs_clients(name,email,address,phone,birthdate,age,gender,strand,grade)"." VALUES('$name','$email','$address','$phone','$birthdate','$age','$gender','$strand','$grade')";
         $result = $conn->query($sql);

             $name = "";
            $email = "";
            $address = "";
            $phone = "";
            $birthdate = "";
            $age = "";
            $gender = "";
            $strand = "";
            $grade = ""; 

            $successMessage = "Client added successfully!";

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