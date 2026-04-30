<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="style.css?v=3">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header class="navbar">
        <div class="nav-brand">
            <img src="images/shaina_logo.png" id="logo" alt="Shaina Logo" onclick="showSection('home')">
        </div>
        <nav class="nav-links">
            <button class="navbarbuttons" onclick="showSection('create')">Create</button>
            <button class="navbarbuttons" onclick="showSection('read')">Read</button>
            <button class="navbarbuttons" onclick="showSection('update')">Update</button>
            <button class="navbarbuttons" onclick="showSection('delete')">Delete</button>
        </nav>
    </header>

    <main>
        <!-- HOME SECTION -->
        <section id="home" class="homecontent" style="display: block;">
            <h1 class="splash">Student Management System</h1>
            <h2 class="splash">Integrative Programming Technologies Project</h2>
        </section>

        <!-- CREATE SECTION -->
        <section id="create" class="content">
            <h1 class="contenttitle">Register New Student</h1>

            <form action="includes/insert.php" method="POST">
                <div class="form-group">
                    <label for="surname" class="label">Surname</label>
                    <input type="text" name="surname" id="surname" class="field" placeholder="e.g. Deel" required>
                </div>

                <div class="form-group">
                    <label for="name" class="label">Given Name</label>
                    <input type="text" name="name" id="name" class="field" placeholder="e.g. Doe" required>
                </div>

                <div class="form-group">
                    <label for="middlename" class="label">Middle Name</label>
                    <input type="text" name="middlename" id="middlename" class="field" placeholder="Optional">
                </div>

                <div class="form-group">
                    <label for="address" class="label">Home Address</label>
                    <input type="text" name="address" id="address" class="field" placeholder="Street, City, Province">
                </div>

                <div class="form-group">
                    <label for="contact" class="label">Contact Number</label>
                    <input type="number" name="contact" id="contact" class="field" placeholder="09XXXXXXXXX">
                </div>

                <div id="btncontainer">
                    <button type="submit" id="savebtn" class="btns">Save Record</button>
                    <button type="button" id="clrbtn" class="btns" onclick="clearFields()">Clear</button>
                </div>

            </form>
        </section>

        <!-- READ SECTION -->
        <section id="read" class="content">
            <h1 class="contenttitle">Student Directory</h1>
            <div class="studenttable-container">
                <table class="studenttable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Address</th>
                            <th>Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'includes/db.php';

                        if ($db_error) {
                            echo "<tr><td colspan='4' style='color: #ef4444; font-weight: bold; padding: 40px; text-align: center;'>
                                        <div style='font-size: 1.5rem; margin-bottom: 10px;'>⚠️ Database Connection Error</div>
                                        <div style='color: #64748b; font-weight: normal;'>" . htmlspecialchars($db_error) . "</div>
                                        <div style='margin-top: 20px; font-weight: normal; font-size: 0.9rem; background: #fee2e2; padding: 15px; border-radius: 8px; display: inline-block;'>
                                            Please ensure the <strong>MySQL</strong> service is started in your <strong>XAMPP Control Panel</strong>.
                                        </div>
                                      </td></tr>";
                        } else {
                            $sql = "SELECT * FROM students";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $fullname = htmlspecialchars($row['surname'] . ", " . $row['name'] . " " . $row['middlename']);
                                    echo "<tr>";
                                    echo "<td style='font-weight: 700; color: var(--primary);'>#" . htmlspecialchars($row['id']) . "</td>";
                                    echo "<td style='font-weight: 500;'>" . $fullname . "</td>";
                                    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['contact_number']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; padding: 40px; color: var(--text-muted);'>No student records found in the database.</td></tr>";
                            }
                            $conn->close();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- UPDATE SECTION -->
        <section id="update" class="content">
            <h1 class="contenttitle">Update Records</h1>

            <div id="update-search">
                <div class="form-group">
                    <label for="update_id" class="label">Enter Student ID</label>
                    <input type="number" name="update_id" id="update_id" class="field" placeholder="ID Number" onkeypress="if(event.key === 'Enter') fetchStudent();">
                </div>
                <button type="button" class="btns" id="updatebtn" onclick="fetchStudent()">Search</button>
            </div>

            <form action="includes/update.php" method="POST" id="updateForm" style="display:none;">
                <input type="hidden" name="id" id="edit_id">

                <div class="form-group">
                    <label for="edit_surname" class="label">Surname</label>
                    <input type="text" name="surname" id="edit_surname" class="field" required>
                </div>

                <div class="form-group">
                    <label for="edit_name" class="label">Given Name</label>
                    <input type="text" name="name" id="edit_name" class="field" required>
                </div>

                <div class="form-group">
                    <label for="edit_middlename" class="label">Middle Name</label>
                    <input type="text" name="middlename" id="edit_middlename" class="field">
                </div>

                <div class="form-group">
                    <label for="edit_address" class="label">Address</label>
                    <input type="text" name="address" id="edit_address" class="field">
                </div>

                <div class="form-group">
                    <label for="edit_contact" class="label">Contact Number</label>
                    <input type="number" name="contact" id="edit_contact" class="field" placeholder="09XXXXXXXXX">
                </div>

                <div id="btncontainer">
                    <button type="submit" class="btns" id="updatebtn">Update Information</button>
                    <button type="button" class="btns" id="clrbtn" onclick="clearUpdateFields()">Cancel</button>
                </div>
            </form>
        </section>

        <!-- DELETE SECTION -->
        <section id="delete" class="content">
            <h1 class="contenttitle">Remove Records</h1>

            <form action="includes/delete.php" method="POST" id="deleteForm" onsubmit="event.preventDefault(); openDeleteModal();">
                <div class="form-group">
                    <label for="delete_id" class="label">Student ID to Remove</label>
                    <input type="number" name="id" id="delete_id" class="field" placeholder="ID Number" required>
                </div>

                <div id="btncontainer">
                    <button type="button" class="btns" id="delete-trigger" style="background: #ef4444;" onclick="openDeleteModal()">Delete Record</button>
                    <button type="button" class="btns" id="clrbtn" onclick="clearDeleteFields()">Clear</button>
                </div>
            </form>
        </section>
    </main>

    <!-- Toasts -->
    <div id="success-toast" class="toast-hidden"><span>Registration Successful!</span></div>
    <div id="update-toast" class="toast-hidden"><span>Record Updated Successfully!</span></div>
    <div id="delete-toast" class="toast-hidden"><span>Record Deleted Successfully!</span></div>

    <!-- Modal -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-content">
            <h3>Confirm Deletion</h3>
            <p>Are you sure you want to permanently remove this student record? This action cannot be undone.</p>
            <div class="modal-btn-group">
                <button class="modal-btn modal-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button class="modal-btn modal-btn-delete" id="confirmDeleteBtn" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>

    <!-- Custom Alert Modal -->
    <script src="script.js?v=5"></script>
</body>

</html>
