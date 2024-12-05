<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'student_management');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total number of students
$total_students = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()['total'];

// Fetch all students
$result = $conn->query("SELECT * FROM students");

// Handle delete action
// if (isset($_GET['delete'])) {
//     $id = $_GET['delete'];
//     $conn->query("DELETE FROM students WHERE id = $id");
//     header("Location: dashboard.php");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="DP_education_logo_2x_si-removebg-preview.png" type="DP_education_logo_2x_si-removebg-preview.png">
    <title>DP Education Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
        }
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            height: 100vh;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 10px;
            margin: 10px 0;
            background-color: #444;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
        }
        .sidebar ul li:hover {
            background-color: #555;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }
        .card {
            width: 100%;
            max-width: 300px;
            margin: 15px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f2f2f2;
        }
        @media screen and (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                flex-direction: row;
                justify-content: space-around;
            }
            .main-content {
                margin-left: 0;
                padding: 10px;
            }
            .cards {
                flex-direction: column;
                align-items: center;
            }
        }
        @media screen and (max-width: 480px) {
            .sidebar ul li {
                padding: 8px;
            }
            table th, table td {
                font-size: 12px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="index.php">Add Student</a></li>
            <li>Reports</li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Welcome to Admin Dashboard</h1>
        <div class="cards">
            <div class="card">
                <h3>Total Students</h3>
                <p><?= $total_students ?></p>
            </div>
        </div>
        <h2>Student List</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
