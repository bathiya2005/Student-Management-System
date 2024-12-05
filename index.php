<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'student_management');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding/updating student
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if ($id > 0) {
        // Update existing student
        $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $phone, $id);
    } else {
        // Add new student
        $stmt = $conn->prepare("INSERT INTO students (name, email, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $phone);
    }

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle delete action
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Secure integer conversion
    if ($conn->query("DELETE FROM students WHERE id = $id")) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch specific student for editing
$editStudent = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM students WHERE id = $id");
    $editStudent = $result->fetch_assoc();
}

// Fetch all students
$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="DP_education_logo_2x_si-removebg-preview.png" type="DP_education_logo_2x_si-removebg-preview.png">
    <title>DP Education Student Management</title>


    <style>
      body {
        font-family: Arial, sans-serif;
        height: 100vh; /* Use full viewport height */
        margin: 0; /* Remove default margin */
        overflow-y: scroll; /* Allow vertical scrolling */
        background-image: url('156022.jpg');
        background-size: cover;
        background-attachment: fixed; /* Keeps the background fixed */
        background-position: center;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        position: relative; /* Ensure it stays fixed within the scrolling page */
        background: rgba(255, 255, 255, 0.9); 
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        top: 50%; /* Center the container vertically */
        transform: translateY(-50%);
    }

        

        h1 {
            text-align: center;
            color: #333;
        }


        .form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .form input {
            width: 30%;
            padding: 10px;
            margin: 0 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form button {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form button:hover {
            background-color: #4cae4c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        .delete, .edit {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            
        }

       

    

     
    </style>


</head>
<body>
    <div class="container">
    <h1 style="display: flex; align-items: center; justify-content: center; gap: 10px;">
    <img src="DP_education_logo_2x_si-removebg-preview.png" alt="DP Education Logo" style="height: 50px; width: auto;">
    DP Education Student Management
</h1>


        



        <form method="POST" class="form">
            <input type="hidden" name="id" value="<?= $editStudent['id'] ?? '' ?>">
            <input type="text" name="name" placeholder="Student Name" value="<?= htmlspecialchars($editStudent['name'] ?? '') ?>" required>
            <input type="email" name="email" placeholder="Student Stu Account" value="<?= htmlspecialchars($editStudent['email'] ?? '') ?>" required>
            <input type="text" name="phone" placeholder="Phone Number" value="<?= htmlspecialchars($editStudent['phone'] ?? '') ?>" required>
            <button type="submit"><?= isset($editStudent) ? 'Update' : 'Add' ?> Student</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td>
                        <a href="?edit=<?= htmlspecialchars($row['id']) ?>" class="edit">Edit</a>
                        <a href="?delete=<?= htmlspecialchars($row['id']) ?>" class="delete">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        


        <button onclick="window.location.href='admin.php';" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 870px; margin-top: 10px;">
                    Go to Dashboard
        </button>


        <footer style="background-color: #f4f4f4; text-align: center; padding: 10px; margin-top: 20px; border-top: 1px solid #ddd;">
             <p>&copy; <?= date('Y') ?> DP Education. All Rights Reserved.</p>
        </footer>

       

    </div>

   

  


        
    


</body>
</html>