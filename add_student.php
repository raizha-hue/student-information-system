<?php

session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

include "config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_id = $_POST["student_id"];
    $firstname = $_POST["firstname"];
    $middlename = $_POST["middlename"];
    $lastname = $_POST["lastname"];
    $birthdate = $_POST["birthdate"];
    $gender = $_POST["gender"];
    $college = $_POST["college"];
    $course = $_POST["course"];
    $year_level = $_POST["year_level"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];

    $sql = "INSERT INTO students
            (student_id, firstname, lastname, middlename, birthdate, gender,
             college, course, year_level, email, contact, address)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $error = "Database error: " . $conn->error;
    } else {

        $stmt->bind_param(
            "ssssssssssss",
            $student_id,
            $firstname,
            $lastname,
            $middlename,
            $birthdate,
            $gender,
            $college,
            $course,
            $year_level,
            $email,
            $contact,
            $address
        );

        if ($stmt->execute()) {

            header("Location: students.php?success=1");
            exit();

        } else {

            if ($stmt->errno == 1062) {
                $error = "The Student ID already exists.";
            } else {
                $error = "Error adding student: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Student - Student Information System</title>

    <link rel="stylesheet" href="css/style.css">
    <script src="js/theme.js"></script>

</head>

<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="sidebar-header">

            <h2>StudentIMS</h2>

            <p>Student Information System</p>

        </div>


        <nav class="sidebar-nav">

            <p class="nav-title">MAIN MENU</p>

            <a href="dashboard.php" class="nav-link">
                <span>⌂</span>
                Dashboard
            </a>

            <a href="students.php" class="nav-link">
                <span>▣</span>
                Students
            </a>

            <a href="add_student.php" class="nav-link active">
                <span>＋</span>
                Add Student
            </a>


            <p class="nav-title">SYSTEM</p>

            <a href="#" class="nav-link">
                <span>▤</span>
                Reports
            </a>

            <a href="#" class="nav-link">
                <span>⚙</span>
                Settings
            </a>

        </nav>


        <div class="sidebar-bottom">

            <a href="logout.php" class="logout-link">
    <span>⇥</span>
    Logout
</a>

        </div>

    </aside>


    <!-- MAIN CONTENT -->

    <main class="main-content">

        <!-- TOP BAR -->

        <header class="topbar">

            <div>

                <h1>Add Student</h1>

                <p>Create a new student record</p>

            </div>

                
           

            <div class="admin-profile">
            
            <!-- THEME TOGGLE -->

                <button
                    type="button"
                    class="theme-toggle"
                    onclick="toggleTheme()"
                >

                    <span id="theme-icon">☾</span>

                    <span id="theme-text">Dark Mode</span>

                </button>
                
                <div>
                
            
                    <strong>Administrator</strong>

                    <small>System Admin</small>

                </div>

                <div class="admin-avatar">
                    A
                </div>

            </div>

        </header>


        <!-- CONTENT -->

        <section class="content">

            <?php if ($error != ""): ?>

                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>


            <div class="form-card">

                <div class="form-header">

                    <h2>Student Information</h2>

                    <p>
                        Enter the student's information below to create a new record.
                    </p>

                </div>


                <form method="POST">


                    <!-- PERSONAL INFORMATION -->

                    <div class="form-section">

                        <h3>Personal Information</h3>

                        <div class="form-grid">


                            <div class="form-group">

                                <label>
                                    Student ID <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="student_id"
                                    placeholder="Enter student ID"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    First Name <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="firstname"
                                    placeholder="Enter first name"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    Middle Name
                                </label>

                                <input
                                    type="text"
                                    name="middlename"
                                    placeholder="Enter middle name"
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    Last Name <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="lastname"
                                    placeholder="Enter last name"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    Birthdate
                                </label>

                                <input
                                    type="date"
                                    name="birthdate"
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    Gender
                                </label>

                                <select name="gender">

                                    <option value="">Select gender</option>

                                    <option value="Male">Male</option>

                                    <option value="Female">Female</option>

                                </select>

                            </div>

                        </div>

                    </div>


                    <!-- ACADEMIC INFORMATION -->

                    <div class="form-section">

                        <h3>Academic Information</h3>

                        <div class="form-grid">


                            <div class="form-group">

                                <label>
                                    College
                                </label>

                                <select name="college">

                                    <option value="">Select college</option>

                                    <option value="College of Computer Studies">
                                        College of Computer Studies
                                    </option>

                                    <option value="College of Education">
                                        College of Education
                                    </option>

                                    <option value="College of Engineering">
                                        College of Engineering
                                    </option>

                                    <option value="College of Arts and Sciences">
                                        College of Arts and Sciences
                                    </option>

                                </select>

                            </div>


                            <div class="form-group">

                                <label>
                                    Course
                                </label>

                                <input
                                    type="text"
                                    name="course"
                                    placeholder="e.g. BSIT"
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    Year Level
                                </label>

                                <select name="year_level">

                                    <option value="">Select year level</option>

                                    <option value="1st Year">1st Year</option>

                                    <option value="2nd Year">2nd Year</option>

                                    <option value="3rd Year">3rd Year</option>

                                    <option value="4th Year">4th Year</option>

                                </select>

                            </div>

                        </div>

                    </div>


                    <!-- CONTACT INFORMATION -->

                    <div class="form-section">

                        <h3>Contact Information</h3>

                        <div class="form-grid">


                            <div class="form-group">

                                <label>
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    placeholder="example@email.com"
                                >

                            </div>


                            <div class="form-group">

                                <label>
                                    Contact Number
                                </label>

                                <input
                                    type="text"
                                    name="contact"
                                    placeholder="Enter contact number"
                                >

                            </div>


                            <div class="form-group full-width">

                                <label>
                                    Address
                                </label>

                                <textarea
                                    name="address"
                                    rows="3"
                                    placeholder="Enter complete address"
                                ></textarea>

                            </div>

                        </div>

                    </div>


                    <!-- BUTTONS -->

                    <div class="form-actions">

                        <a href="students.php" class="cancel-button">
                            Cancel
                        </a>

                        <button type="submit" class="save-button">
                            Save Student
                        </button>

                    </div>

                </form>

            </div>

        </section>

    </main>

</div>

</body>

</html>

