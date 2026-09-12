<?php

session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

include "config/database.php";

// Get total number of students
$student_count = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()["total"];

// Get total number of colleges
$college_count = $conn->query("SELECT COUNT(DISTINCT college) AS total FROM students WHERE college != ''")->fetch_assoc()["total"];

// Get total number of courses
$course_count = $conn->query("SELECT COUNT(DISTINCT course) AS total FROM students WHERE course != ''")->fetch_assoc()["total"];

// Get recent students
$recent_students = $conn->query("SELECT * FROM students ORDER BY id DESC LIMIT 5");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Student Information System</title>

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

            <a href="dashboard.php" class="nav-link active">
                <span>▣</span>
                Dashboard
            </a>


            <p class="nav-title">STUDENTS</p>


            <a href="students.php" class="nav-link">
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

            <!-- LOGOUT -->

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

                <h1>Dashboard</h1>

                <p>Welcome back, Admin!</p>

            </div>


            <div class="topbar-actions">

                <!-- THEME TOGGLE -->

                <button
                    type="button"
                    class="theme-toggle"
                    onclick="toggleTheme()"
                >

                    <span id="theme-icon">☾</span>

                    <span id="theme-text">Dark Mode</span>

                </button>


                <!-- ADMIN PROFILE -->

                <div class="admin-profile">

                    <div class="admin-avatar">
                        A
                    </div>


                    <div>

                        <strong>Administrator</strong>

                        <small>System Admin</small>

                    </div>

                </div>

            </div>

        </header>



        <!-- DASHBOARD CONTENT -->

        <section class="content">


            <!-- STAT CARDS -->

            <div class="stats-grid">


                <div class="stat-card">

                    <div class="stat-icon">
                        👨‍🎓
                    </div>


                    <div>

                        <p>Total Students</p>

                        <h2>
                            <?php echo $student_count; ?>
                        </h2>

                    </div>

                </div>



                <div class="stat-card">

                    <div class="stat-icon">
                        🏫
                    </div>


                    <div>

                        <p>Total Colleges</p>

                        <h2>
                            <?php echo $college_count; ?>
                        </h2>

                    </div>

                </div>



                <div class="stat-card">

                    <div class="stat-icon">
                        📚
                    </div>


                    <div>

                        <p>Total Courses</p>

                        <h2>
                            <?php echo $course_count; ?>
                        </h2>

                    </div>

                </div>



                <div class="stat-card">

                    <div class="stat-icon">
                        ➕
                    </div>


                    <div>

                        <p>Quick Action</p>

                        <a href="add_student.php" class="quick-link">
                            Add Student
                        </a>

                    </div>

                </div>

            </div>



            <!-- RECENT STUDENTS -->

            <div class="section-card">


                <div class="section-header">

                    <div>

                        <h2>Recent Students</h2>

                        <p>Recently added student records</p>

                    </div>


                    <a href="students.php" class="view-all">
                        View All
                    </a>

                </div>



                <div class="table-container">


                    <table>


                        <thead>

                            <tr>

                                <th>Student ID</th>

                                <th>Name</th>

                                <th>College</th>

                                <th>Course</th>

                                <th>Year Level</th>

                            </tr>

                        </thead>



                        <tbody>


                        <?php if ($recent_students->num_rows > 0): ?>


                            <?php while ($student = $recent_students->fetch_assoc()): ?>


                                <tr>


                                    <td>

                                        <strong>
                                            <?php
                                            echo htmlspecialchars(
                                                $student["student_id"]
                                            );
                                            ?>
                                        </strong>

                                    </td>



                                    <td>

                                        <?php

                                        echo htmlspecialchars(
                                            trim(
                                                $student["firstname"] . " " .
                                                $student["middlename"] . " " .
                                                $student["lastname"]
                                            )
                                        );

                                        ?>

                                    </td>



                                    <td>

                                        <?php

                                        echo htmlspecialchars(
                                            $student["college"]
                                        );

                                        ?>

                                    </td>



                                    <td>

                                        <?php

                                        echo htmlspecialchars(
                                            $student["course"]
                                        );

                                        ?>

                                    </td>



                                    <td>

                                        <?php

                                        echo htmlspecialchars(
                                            $student["year_level"]
                                        );

                                        ?>

                                    </td>


                                </tr>


                            <?php endwhile; ?>


                        <?php else: ?>


                            <tr>

                                <td colspan="5" class="empty-message">
                                    No students found.
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

