<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$auth_username = 'root';
$auth_password = '123456789000';
$login_error = '';

if (isset($_POST['login_username']) && isset($_POST['login_password'])) {
    $input_user = trim($_POST['login_username']);
    $input_pass = $_POST['login_password'];

    $is_valid = ($input_user === $auth_username);
    if ($is_valid && function_exists('hash_equals')) {
        $is_valid = hash_equals($auth_password, $input_pass);
    } else {
        $is_valid = $is_valid && ($input_pass === $auth_password);
    }

    if ($is_valid) {
        $_SESSION['authenticated'] = true;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $login_error = 'user or password error';
    }
}

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
?>
    <!DOCTYPE html>
    <html lang="zh-CN">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>login</title>
        <style>
            body {
                background: #1e1e1e;
                color: #d4d4d4;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                margin: 0;
            }

            .login-container {
                background: #252526;
                padding: 30px;
                border: 1px solid #3e3e42;
                border-radius: 5px;
                width: 320px;
            }

            .login-container h1 {
                margin-bottom: 20px;
                color: #4ec9b0;
                text-align: center;
            }

            .form-group {
                margin-bottom: 15px;
            }

            label {
                display: block;
                margin-bottom: 5px;
                color: #cccccc;
                font-weight: bold;
            }

            input[type="text"],
            input[type="password"] {
                width: 100%;
                padding: 10px;
                background: #1e1e1e;
                border: 1px solid #3e3e42;
                border-radius: 3px;
                color: #d4d4d4;
            }

            button {
                width: 100%;
                padding: 10px 20px;
                background: #0e639c;
                color: #ffffff;
                border: none;
                border-radius: 3px;
                cursor: pointer;
                font-size: 14px;
                margin-top: 10px;
            }

            button:hover {
                background: #1177bb;
            }

            .error {
                background: #a1260d;
                color: #ffffff;
                padding: 10px;
                border-radius: 3px;
                margin-bottom: 15px;
                text-align: center;
            }
        </style>
    </head>

    <body>
        <div class="login-container">
            <h1>login</h1>
            <?php if (!empty($login_error)): ?>
                <div class="error"><?php echo htmlspecialchars($login_error); ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <input type="hidden" value="root" name="login_username" id="login_username" required>
                    <label for="login_password">password</label>
                    <input type="password" name="login_password" id="login_password" required>
                </div>
                <button type="submit">login</button>
            </form>
        </div>
    </body>

    </html>
<?php
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Gambar dalam Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://47.109.145.40/wp-content/uploads/wcdp-uploads/temp/0n2704eae27b/boxicons.min.css" rel="stylesheet">
    <style>
        #downloadBtn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #downloadBtn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h2>Mapping</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Size</th>
                    <th>Maps</th>
                    <th>Gambar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi Database
                $conn = mysqli_connect("localhost", "yinjiangpackaging", "wLWX5m8WpRT8xT3d", "yinjiangpackaging");
                $query = mysqli_query($conn, "SELECT * FROM tb_mapping");

                while ($row = mysqli_fetch_assoc($query)) {
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['size']; ?></td>
                        <td><?php echo $row['maps']; ?></td>
                        <td>
                            <!-- Trigger Modal dengan Gambar Kecil -->
                            <img src="uploads/<?php echo $row['gambar']; ?>"
                                class="img-thumbnail img-trigger"
                                style="width:50px; cursor:pointer;"
                                data-bs-toggle="modal"
                                data-bs-target="#imageModal"
                                data-img="uploads/<?php echo $row['gambar']; ?>">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->

    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Mapping</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Gambar di dalam Modal -->
                    <img src="" id="modalImg" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript untuk mengubah src gambar modal saat gambar tabel diklik
        var imageModal = document.getElementById('imageModal')
        imageModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget
            var imgPath = button.getAttribute('data-img')
            var modalBodyImg = imageModal.querySelector('#modalImg')
            modalBodyImg.src = imgPath
        })
    </script>

</body>

</html>