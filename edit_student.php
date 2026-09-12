<?php

session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

include "config/database.php";

if (!isset($_GET["id"])) {
    die("Student ID is missing.");
}

$id = $_GET["id"];

/* Get student information */
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Student not found.");
}

$student = $result->fetch_assoc();

$stmt->close();


/* Update student */
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

    $sql = "UPDATE students SET
            student_id = ?,
            firstname = ?,
            middlename = ?,
            lastname = ?,
            birthdate = ?,
            gender = ?,
            college = ?,
            course = ?,
            year_level = ?,
            email = ?,
            contact = ?,
            address = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssssssssssi",
        $student_id,
        $firstname,
        $middlename,
        $lastname,
        $birthdate,
        $gender,
        $college,
        $course,
        $year_level,
        $email,
        $contact,
        $address,
        $id
    );

    if ($stmt->execute()) {

        header("Location: students.php?updated=1");
        exit();

    } else {

        $error = "Error updating student: " . $stmt->error;

    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Student - Student Information System</title>

    <link rel="stylesheet" href="css/style.css">
    <script src="js/theme.js"></script>

</head>

<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="sidebar-header">

            <h2>SIS</h2>

            <p>Student Information System</p>

        </div>


        <nav class="sidebar-nav">

            <a href="dashboard.php" class="nav-link">

                <span>▣</span>

                Dashboard

            </a>


            <p class="nav-title">
                STUDENTS
            </p>


            <a href="students.php" class="nav-link active">

                <span>○</span>

                Students

            </a>


            <a href="add_student.php" class="nav-link">

                <span>＋</span>

                Add Student

            </a>


            <p class="nav-title">
                MANAGEMENT
            </p>


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

                <h1>Edit Student</h1>

                <p>Update student information and records</p>

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


                <div class="admin-avatar">
                    A
                </div>

                <div>

                    <strong>Administrator</strong>

                    <small>System Admin</small>

                </div>

            </div>

        </header>


        <!-- CONTENT -->

        <section class="content">


            <div class="form-card">


                <div class="form-header">

                    <div>

                        <h2>Edit Student Information</h2>

                        <p>
                            Update the student's information below.
                        </p>

                    </div>

                </div>


                <?php if (isset($error)): ?>

                    <div class="error-message">

                        <?php echo htmlspecialchars($error); ?>

                    </div>

                <?php endif; ?>


                <form method="POST">


                    <!-- PERSONAL INFORMATION -->

                    <div class="form-section">

                        <h3>Personal Information</h3>


                        <div class="form-grid">


                            <div class="form-group">

                                <label>Student ID</label>

                                <input
                                    type="text"
                                    name="student_id"
                                    value="<?php echo htmlspecialchars($student["student_id"]); ?>"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label>First Name</label>

                                <input
                                    type="text"
                                    name="firstname"
                                    value="<?php echo htmlspecialchars($student["firstname"]); ?>"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label>Middle Name</label>

                                <input
                                    type="text"
                                    name="middlename"
                                    value="<?php echo htmlspecialchars($student["middlename"]); ?>"
                                >

                            </div>


                            <div class="form-group">

                                <label>Last Name</label>

                                <input
                                    type="text"
                                    name="lastname"
                                    value="<?php echo htmlspecialchars($student["lastname"]); ?>"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label>Birthdate</label>

                                <input
                                    type="date"
                                    name="birthdate"
                                    value="<?php echo htmlspecialchars($student["birthdate"]); ?>"
                                >

                            </div>


                            <div class="form-group">

                                <label>Gender</label>

                                <select name="gender">

                                    <option value="">
                                        Select Gender
                                    </option>

                                    <option
                                        value="Male"
                                        <?php if ($student["gender"] == "Male") echo "selected"; ?>
                                    >
                                        Male
                                    </option>

                                    <option
                                        value="Female"
                                        <?php if ($student["gender"] == "Female") echo "selected"; ?>
                                    >
                                        Female
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>


                    <!-- ACADEMIC INFORMATION -->

                    <div class="form-section">

                        <h3>Academic Information</h3>


                        <div class="form-grid">


                            <div class="form-group">

                                <label>College</label>

                                <select name="college">

                                    <option value="">
                                        Select College
                                    </option>

                                    <option
                                        value="College of Computer Studies"
                                        <?php if ($student["college"] == "College of Computer Studies") echo "selected"; ?>
                                    >
                                        College of Computer Studies
                                    </option>

                                    <option
                                        value="College of Education"
                                        <?php if ($student["college"] == "College of Education") echo "selected"; ?>
                                    >
                                        College of Education
                                    </option>

                                    <option
                                        value="College of Engineering"
                                        <?php if ($student["college"] == "College of Engineering") echo "selected"; ?>
                                    >
                                        College of Engineering
                                    </option>

                                    <option
                                        value="College of Arts and Sciences"
                                        <?php if ($student["college"] == "College of Arts and Sciences") echo "selected"; ?>
                                    >
                                        College of Arts and Sciences
                                    </option>

                                </select>

                            </div>


                            <div class="form-group">

                                <label>Course</label>

                                <input
                                    type="text"
                                    name="course"
                                    value="<?php echo htmlspecialchars($student["course"]); ?>"
                                >

                            </div>


                            <div class="form-group">

                                <label>Year Level</label>

                                <select name="year_level">

                                    <option value="">
                                        Select Year Level
                                    </option>

                                    <option
                                        value="1st Year"
                                        <?php if ($student["year_level"] == "1st Year") echo "selected"; ?>
                                    >
                                        1st Year
                                    </option>

                                    <option
                                        value="2nd Year"
                                        <?php if ($student["year_level"] == "2nd Year") echo "selected"; ?>
                                    >
                                        2nd Year
                                    </option>

                                    <option
                                        value="3rd Year"
                                        <?php if ($student["year_level"] == "3rd Year") echo "selected"; ?>
                                    >
                                        3rd Year
                                    </option>

                                    <option
                                        value="4th Year"
                                        <?php if ($student["year_level"] == "4th Year") echo "selected"; ?>
                                    >
                                        4th Year
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>


                    <!-- CONTACT INFORMATION -->

                    <div class="form-section">

                        <h3>Contact Information</h3>


                        <div class="form-grid">


                            <div class="form-group">

                                <label>Email</label>

                                <input
                                    type="email"
                                    name="email"
                                    value="<?php echo htmlspecialchars($student["email"]); ?>"
                                >

                            </div>


                            <div class="form-group">

                                <label>Contact Number</label>

                                <input
                                    type="text"
                                    name="contact"
                                    value="<?php echo htmlspecialchars($student["contact"]); ?>"
                                >

                            </div>


                            <div class="form-group full-width">

                                <label>Address</label>

                                <textarea
                                    name="address"
                                ><?php echo htmlspecialchars($student["address"]); ?></textarea>

                            </div>

                        </div>

                    </div>


                    <!-- BUTTONS -->

                    <div class="form-actions">

                        <a
                            href="students.php"
                            class="cancel-button"
                        >
                            Cancel
                        </a>


                        <button
                            type="submit"
                            class="save-button"
                        >
                            Update Student
                        </button>

                    </div>

                </form>

            </div>

        </section>

    </main>

</div>

</body>
</html>