<?php
    $host = "localhost";
    $username = "root";
    $password = ""; 
    $database = "user_db";
    
    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    //connect to database
    $conn = new mysqli($host, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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

    // Check if we need to fix the database
    $needsDatabaseFix = false;
    $columnInfo = $conn->query("SHOW COLUMNS FROM shs_clients LIKE 'phone'");
    if ($columnInfo && $row = $columnInfo->fetch_assoc()) {
        $columnType = strtolower($row['Type']);
        if (strpos($columnType, 'int') !== false || strpos($columnType, 'bigint') !== false) {
            $needsDatabaseFix = true;
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $birthdate = $_POST['birthdate'] ?? '';
        $age = $_POST['age'] ?? '';
        $gender = trim($_POST['gender'] ?? '');
        $strand = $_POST['strand'] ?? '';
        $grade = $_POST['grade'] ?? '';
        
        do{
            if(empty($name) || empty($email) || empty($address) || empty($phone) || empty($birthdate) || empty($age) || empty($gender) || empty($strand) || empty($grade)){
                $errorMessage = "All fields are required";
                break;
            }
            
            // Keep phone as string (don't convert to number)
            $phone_cleaned = $phone; // Keep as is, don't remove leading zeros
            
            // Validate email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessage = "Please enter a valid email address";
                break;
            }
            
            // Validate age
            if($age < 18 || $age > 100) {
                $errorMessage = "Age must be between 18 and 100";
                break;
            }
            
            // Validate phone - allow numbers, spaces, +, -, ()
            if(!preg_match('/^[0-9+\-\s\(\)]+$/', $phone_cleaned)) {
                $errorMessage = "Please enter a valid phone number (numbers, +, -, spaces only)";
                break;
            }

            // Using prepared statement to prevent SQL injection
            $sql = "INSERT INTO shs_clients (name, email, address, phone, birthdate, age, gender, strand, grade) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            if(!$stmt) {
                $errorMessage = "Prepare failed: " . $conn->error;
                break;
            }
            
            // Note: phone is bound as string (s)
            $stmt->bind_param("sssssisss", $name, $email, $address, $phone_cleaned, $birthdate, $age, $gender, $strand, $grade);
            
            if($stmt->execute()) {
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
                
                // Redirect after 2 seconds
                echo "<script>setTimeout(function() { window.location.href = 'Shs_clients.php'; }, 2000);</script>";
            } else {
                // Get detailed error information
                $errorMessage = "Error adding client: " . $stmt->error;
                if(strpos($stmt->error, 'Out of range') !== false) {
                    $errorMessage .= "<br><strong>DATABASE FIX REQUIRED:</strong> Your phone column is set to a numeric type. Please run this SQL in phpMyAdmin:<br>";
                    $errorMessage .= "<code>ALTER TABLE shs_clients MODIFY phone VARCHAR(20);</code>";
                }
                break;
            }
            
            $stmt->close();

        } while(false);
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
        
        <!-- Show database fix warning if needed -->
        <?php if($needsDatabaseFix): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>⚠️ DATABASE ERROR DETECTED!</strong><br>
            Your <code>phone</code> column is set to a numeric type (INT/BIGINT). 
            Phone numbers must be stored as VARCHAR to preserve leading zeros and special characters.<br><br>
            <strong>Please run this SQL command in phpMyAdmin to fix:</strong><br>
            <code>ALTER TABLE shs_clients MODIFY phone VARCHAR(20) NOT NULL;</code><br><br>
            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="alert">Dismiss</button>
        </div>
        <?php endif; ?>
        
        <?php
        if( !empty($errorMessage)){
            echo"
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Error:</strong> $errorMessage
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        
        if( !empty($successMessage)){
            echo"
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> $successMessage
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" placeholder="Enter Name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" name="email" placeholder="Enter Email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="address" placeholder="Enter Address" value="<?php echo htmlspecialchars($address); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-sm-6">
                        <input type="tel" class="form-control" name="phone" placeholder="Enter Phone Number (e.g., 09123456789)" value="<?php echo htmlspecialchars($phone); ?>" required>
                        <small class="text-muted">Enter phone number with or without country code (e.g., 09123456789 or +639123456789)</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Birthdate</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" name="birthdate" value="<?php echo $birthdate; ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Age</label>
                    <div class="col-sm-6">
                        <input type="number" min="18" max="100" step="1" name="age" placeholder="Enter Age" class="form-control" value="<?php echo $age; ?>" required>
                    </div>    
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Gender</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="gender" required>
                            <option value="" disabled <?php echo empty($gender) ? 'selected' : ''; ?>>Select Gender</option>
                            <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo ($gender == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Strand</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="strand" required>
                            <option value="" disabled <?php echo empty($strand) ? 'selected' : ''; ?>>Select Strand</option>
                            <?php
                                $strands = ['ABM', 'ICT', 'HUMMS', 'H.E'];
                                foreach ($strands as $s) {
                                    $selected = ($strand == $s) ? 'selected' : '';
                                    echo "<option value=\"$s\" $selected>$s</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Grade</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="grade" required>
                            <option value="" disabled <?php echo empty($grade) ? 'selected' : ''; ?>>Select Grade</option>
                            <?php
                                $grades = ['11', '12'];
                                foreach ($grades as $g) {
                                    $selected = ($grade == $g) ? 'selected' : '';
                                    echo "<option value=\"$g\" $selected>$g</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
           
                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a href="Shs_clients.php" class="btn btn-outline-primary">Cancel</a>
                    </div>
                </div>
        </form>
        
        <!-- Display table structure for debugging -->
        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <strong>Database Table Structure (for debugging)</strong>
                    </div>
                    <div class="card-body">
                        <?php
                        $result = $conn->query("DESCRIBE shs_clients");
                        if($result && $result->num_rows > 0) {
                            echo "<table class='table table-sm table-bordered'>";
                            echo "<thead><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr></thead><tbody>";
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['Field']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Null']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Key']) . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody></table>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
