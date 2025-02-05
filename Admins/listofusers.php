<?php
session_start();
require_once "../Backend/Regjistrimi/db_connection.php";

$query_users = "SELECT id, name, email, role FROM users";
$result_users = mysqli_query($connection, $query_users);

if (!$result_users) {
    echo "Gabim: " . mysqli_error($connection);
    exit;
}

$users = array();
while ($row = mysqli_fetch_assoc($result_users)) {
    $users[$row['id']]['id'] = $row['id'];
    $users[$row['id']]['name'] = $row['name'];
    $users[$row['id']]['email'] = $row['email'];
    $users[$row['id']]['role'] = $row['role'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link rel="stylesheet" href="listofusers.css">
    <link rel="stylesheet" href="listofusers_buttons.css">
    <title>MEEA | Admin Dashboard</title>
    <style>
        .add-user-container {
            margin-bottom: 20px;
            text-align: right;
        }
        .add-user-button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-user-button:hover {
            background-color: #45a049;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 10px;
            width: 30%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .modal-submit {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .modal-submit:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <h2 style="text-align: center;">Lista e Përdoruesve</h2>

    <div class="add-user-container">
        <button class="add-user-button" onclick="openModal()">Shto Përdorues</button>
    </div>

    <div class="table-responsive">
        <table id="usersTable" class="display">
            <thead>
                <tr>
                    <th>Emri</th>
                    <th>Email</th>
                    <th>Roli</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($users as $user_id => $user_data) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($user_data['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($user_data['email']) . "</td>";
                        echo "<td>" . ucfirst(htmlspecialchars($user_data['role'])) . "</td>";
                        echo "<td>";
                        echo "<a href='edit_user.php?id=" . $user_id . "' class='edit-btn'>Edit</a>";
                        echo " | ";
                        echo "<button class='delete-btn' data-user-id='" . $user_id . "'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Shto Përdorues</h3>
            <form id="addUserForm" method="POST" action="add_user.php">
                <input type="text" name="name" placeholder="Emri" class="modal-input" required>
                <input type="email" name="email" placeholder="Email" class="modal-input" required>
                <select name="role" class="modal-input" required>
                    <option value="">Zgjidh rolin</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <button type="submit" class="modal-submit">Shto</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "pageLength": 10,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/Albanian.json"
                }
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');

                Swal.fire({
                    title: 'Jeni i sigurt?',
                    text: "Ky veprim nuk mund të rikthehet!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Po, fshije!',
                    cancelButtonText: 'Anulo'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `delete_user.php?id=${userId}`;
                    }
                });
            });
        });

        function openModal() {
            document.getElementById('addUserModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('addUserModal').style.display = 'none';
        }
    </script>
</body>
</html>
