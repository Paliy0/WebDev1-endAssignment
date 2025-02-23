<?php if (isset($_SESSION['error'])): ?>
    <div class="error">
        <?php
        echo $_SESSION['error'];
        unset($_SESSION['error']); // Clear the error after displaying
        ?>
    </div>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* Custom styles */
        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 350px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card border-0 shadow rounded-3">
            <div class="card-body p-4 p-sm-5">
                <h4 class="card-title text-center mb-5 fw-light fs-5">User Registration</h4>
                <form action="/login/register" method="post">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <label for="password">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                        <label for="confirm_password">Confirm Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select id="role" name="role" class="form-select" required>
                            <option value="customer">Customer</option>
                            <option value="business">Business</option>
                        </select>
                        <label for="role">Register as</label>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary btn-register text-uppercase fw-bold" type="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>