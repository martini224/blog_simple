<?php
    require($_SERVER['DOCUMENT_ROOT'].'/blog_simple/app/db.php');

    $errors = [];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/blog_simple/app/form_utils.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = test_input($_POST["email"]);
        $password = test_input($_POST["password"]);

        if (is_null($email) || $email == '') {
            $errors['email'] = 'email requis.';
        }

        if (is_null($password) || $password == '') {
            $errors['password'] = 'password requis';
        }

        if (empty($errors) && isset($db)) {
            try {
                $sql = "select id, email, name, password, image_extension, role_id, created_at, updated_at from users where email = :email LIMIT 1";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch();

                if (!$user) {
                    $user = null;
                } else {

                    if(password_verify($password, $user['password'])) {
                        $_SESSION['user'] = $user;
                        header('Location: http://localhost/blog_simple/index.php');
                    } else {
                        $user = null;
                    }
                }

                $db = null;
            } catch (Exception $exception) {
                echo $exception;
            }
        }
    }
?>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Se connecter
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarScrollingDropdown">
        <li>
            <div class="user-login-container">
                <div>
                    <form class="form user-login-form" role="form" method="POST" accept-charset="UTF-8" action="<?php echo $_SERVER["PHP_SELF"];?>">
                        <div class="form-group">
                            <label class="sr-only" for="email">Email address</label>
                            <input type="email" class="form-control <?php echo (isset($errors['email']) ? 'is-invalid' : '') ?>" id="email" placeholder="Email" name="email" aria-labelledby="validation-user-email" required>
                            <div id="validation-user-email" class="invalid-feedback">
                                <?php echo (isset($errors['email']) ? $errors['email'] : '') ?>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label class="sr-only" for="password">Password</label>
                            <input type="password" class="form-control <?php echo (isset($errors['password']) ? 'is-invalid' : '') ?>" id="password" name="password" placeholder="Mot de passe" aria-labelledby="validation-user-password" required>
                            <div id="validation-user-password" class="invalid-feedback">
                                <?php echo (isset($errors['password']) ? $errors['password'] : '') ?>
                            </div>
                            <div class="help-block text-right"><a href="">Mot de passe oublié ?</a></div>
                        </div>
                        <!--                        <div class="form-group mt-2">-->
                        <!--                            <label>-->
                        <!--                                <input type="checkbox"> keep me logged-in-->
                        <!--                            </label>-->
                        <!--                        </div>-->
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                        </div>
                    </form>
                </div>
                <div class="bottom mt-2">
                    Pas encore inscrit ? <a href=""><b>Nous rejoindre</b></a>
                </div>
            </div>
        </li>
    </ul>
</li>
