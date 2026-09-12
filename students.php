<?php

session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

include "config/database.php";

$search = "";

if (isset($_GET["search"])) {
    $search = trim($_GET["search"]);
}

if ($search != "") {

    $sql = "SELECT * FROM students
            WHERE student_id LIKE ?
            OR firstname LIKE ?
            OR middlename LIKE ?
            OR lastname LIKE ?
            OR college LIKE ?
            OR course LIKE ?
            OR year_level LIKE ?
            ORDER BY id DESC";

    $stmt = $conn->prepare($sql);

    $searchTerm = "%" . $search . "%";

    $stmt->bind_param(
        "sssssss",
        $searchTerm,
        $searchTerm,
        $searchTerm,
        $searchTerm,
        $searchTerm,
        $searchTerm,
        $searchTerm
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $sql = "SELECT * FROM students ORDER BY id DESC";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Students - Student Information System</title>

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

            <p class="nav-title">STUDENTS</p>

            <a href="students.php" class="nav-link active">
                <span>○</span>
                Students
            </a>

            <a href="add_student.php" class="nav-link">
                <span>＋</span>
                Add Student
            </a>

            <p class="nav-title">MANAGEMENT</p>

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

            <<a href="logout.php" class="logout-link">
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
                <h1>Students</h1>
                <p>Manage student information and records</p>
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

            <div class="section-card">

                <!-- SECTION HEADER -->
                <div class="section-header">

                    <div>
                        <h2>Student Records</h2>
                        <p>View and manage all registered students</p>
                    </div>

                    <a href="add_student.php" class="add-button">
                        + Add Student
                    </a>

                </div>


                <!-- SUCCESS MESSAGES -->

                <?php if (isset($_GET["success"])): ?>

                    <div class="success-message">
                        Student added successfully!
                    </div>

                <?php endif; ?>


                <?php if (isset($_GET["updated"])): ?>

                    <div class="success-message">
                        Student updated successfully!
                    </div>

                <?php endif; ?>


                <?php if (isset($_GET["deleted"])): ?>

                    <div class="success-message">
                        Student deleted successfully!
                    </div>

                <?php endif; ?>


                <!-- SEARCH FORM -->

                <form method="GET" class="search-form">

                    <div class="search-box">

                        <span>⌕</span>

                        <input
                            type="text"
                            name="search"
                            placeholder="Search by ID, name, college, course, or year level..."
                            value="<?php echo htmlspecialchars($search); ?>"
                        >

                    </div>

                    <button type="submit" class="search-button">
                        Search
                    </button>

                    <?php if ($search != ""): ?>

                        <a href="students.php" class="clear-button">
                            Clear
                        </a>

                    <?php endif; ?>

                </form>


                <!-- SEARCH RESULT MESSAGE -->

                <?php if ($search != ""): ?>

                    <p class="search-result">

                        Search results for:
                        <strong>
                            "<?php echo htmlspecialchars($search); ?>"
                        </strong>

                        — <?php echo $result->num_rows; ?> result(s)

                    </p>

                <?php endif; ?>


                <!-- STUDENT TABLE -->

                <div class="table-container">

                    <table>

                        <thead>

                            <tr>

                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Birthdate</th>
                                <th>Gender</th>
                                <th>College</th>
                                <th>Course</th>
                                <th>Year Level</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Actions</th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php if ($result->num_rows > 0): ?>

                            <?php while ($student = $result->fetch_assoc()): ?>

                                <tr>

                                    <td>
                                        <strong>
                                            <?php echo htmlspecialchars($student["student_id"]); ?>
                                        </strong>
                                    </td>


                                    <td>

                                        <?php

                                        echo htmlspecialchars(
                                            $student["firstname"] . " " .
                                            $student["middlename"] . " " .
                                            $student["lastname"]
                                        );

                                        ?>

                                    </td>


                                    <td>
                                        <?php echo htmlspecialchars($student["birthdate"]); ?>
                                    </td>


                                    <td>
                                        <?php echo htmlspecialchars($student["gender"]); ?>
                                    </td>


                                    <td>
                                        <?php echo htmlspecialchars($student["college"]); ?>
                                    </td>


                                    <td>
                                        <?php echo htmlspecialchars($student["course"]); ?>
                                    </td>


                                    <td>
                                        <?php echo htmlspecialchars($student["year_level"]); ?>
                                    </td>


                                    <td>
                                        <?php echo htmlspecialchars($student["email"]); ?>
                                    </td>


                                    <td>
                                        <?php echo htmlspecialchars($student["contact"]); ?>
                                    </td>


                                    <td>

                                        <div class="action-buttons">

                                            <a
                                                href="edit_student.php?id=<?php echo $student["id"]; ?>"
                                                class="edit-button"
                                            >
                                                Edit
                                            </a>

                                            <a
                                                href="delete_student.php?id=<?php echo $student["id"]; ?>"
                                                class="delete-button"
                                                onclick="return confirm('Are you sure you want to delete this student?');"
                                            >
                                                Delete
                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            <?php endwhile; ?>


                        <?php else: ?>

                            <tr>

                                <td colspan="10" class="empty-message">

                                    <?php if ($search != ""): ?>

                                        No students found matching
                                        "<?php echo htmlspecialchars($search); ?>".

                                    <?php else: ?>

                                        No students found.

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </section>

    </main>

</div>

</body>
</html>