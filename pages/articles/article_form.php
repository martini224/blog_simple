<?php require_once($_SERVER['DOCUMENT_ROOT'].'/blog_simple/app/session.php'); ?>

<?php
require($_SERVER['DOCUMENT_ROOT'].'/blog_simple/app/db.php');

$id = null;

if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

$article = null;
$errors = [];

if(isset($user)) {
    if (isset($db) && isset($id)) {
        try {
            $sql = "SELECT id, title, excerpt, body, image_extension, users_id, created_at, updated_at FROM article ";

            $stmt = $db->prepare("$sql where id = :id LIMIT 1");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $article = $stmt->fetch();

            if (!$article) {
                $article = null;
            }

            $db = null;
        } catch (Exception $exception) {
            echo $exception;
        }
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . '/blog_simple/app/form_utils.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = test_input($_POST["title"]);
        $excerpt = test_input($_POST["excerpt"]);
        $body = test_input($_POST["body"]);
        $uuid = "";
        $image = null;

        $errors = [];

        if (is_null($title) || $title == '') {
            $errors['title'] = 'Le titre est requis.';
        }

        if (is_null($body) || $body == '') {
            $errors['body'] = 'Le contenu est requis.';
        }

        if (isset($_FILES["image"])) {
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/blog_simple/resources/images/articles/";
            $image = $target_dir . $_FILES["image"]["name"];
            $imageExtension = strtolower(pathinfo($image,PATHINFO_EXTENSION));

            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) {
                $errors['image'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
            } else {
                // Si le fichier existe, on le supprime
                if(file_exists($image)) {
                    unlink($image);
                }

                if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
                    $errors['body'] = 'Erreur inatendue.';
                }
            }
        }

        if (empty($errors)) {
            try {
                $stmt = $db->prepare('INSERT INTO article(uuid, title, excerpt, body, image_extension, users_id) VALUES (:uuid, :title, :excerpt, :body, :image_extension, :users_id)');

                $stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR);
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                $stmt->bindParam(':excerpt', $excerpt, PDO::PARAM_STR);
                $stmt->bindParam(':body', $body, PDO::PARAM_STR);
                $stmt->bindParam(':image', $image, PDO::PARAM_STR);
                $stmt->bindParam(':users_id', $user['id'], PDO::PARAM_INT);
                $stmt->execute();

                //header('Location: http://localhost/blog_simple/pages/articles/articles.php');
            } catch (Exception $exception) {
                echo $exception;
            }
        }
    }
}

?>

<!doctype html>
<html lang="fr">
<head>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/blog_simple/components/headers.php') ?>

    <script>

    </script>

    <title>Home blog</title>
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/blog_simple/components/navigation.php') ?>

<main role="main">
    <?php echo realpath('app/session.php') ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <form role="form" method="POST" accept-charset="UTF-8" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="multipart/form-data" novalidate>
                    <input type="text" name="id" value="{{uuid}}" class="d-none" />
                    <input type="text" name="version" value="{{version_iso}}" class="d-none" />
                    <input type="text" name="image_extension" value="{{image_extension}}" class="d-none" />
                    <div class="form-group">
                        <label for="title">Titre*</label>
                        <input type="text" name="title" minlength="3" maxlength="100" value="" class="form-control <?php echo (isset($errors['title']) ? 'is-invalid' : '') ?>" id="title" placeholder="Titre" aria-describedby="validation-title"  required>
                        <div id="validation-title" class="invalid-feedback">
                            <?php echo (isset($errors['title']) ? $errors['title'] : '') ?>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="excerpt">Résumé de l'article</label>
                        <input type="text" name="excerpt" value="" class="form-control" id="excerpt" placeholder="Résumé" aria-describedby="validation-excerpt">
                        <div id="validation-excerpt" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="excerpt">Image de l'article</label>
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <input type="file" id="image" name="image" class="form-control <?php echo (isset($errors['image']) ? 'is-invalid' : '') ?>" accept="image/png, image/jpeg, image/jpg, image/gif" aria-describedby="validation-image">
                                <div id="validation-image" class="invalid-feedback">
                                    <?php echo (isset($errors['image']) ? $errors['image'] : '') ?>
                                </div>
                            </div>
                            <div class="mt-1 pr-1 flex-grow-1 d-flex justify-content-end">
                                <div>
                                    <img src="" class="card-img-top d-none article-image preview" alt="article-image">
                                    <div><i>Image actuelle</i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="body">Contenu*</label>
                        <textarea class="form-control" id="body" name="body" rows="3" aria-describedby="validation-body" required></textarea>
                        <div id="validation-body" class="invalid-feedback"></div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Publier</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php require_once($_SERVER['DOCUMENT_ROOT'].'/blog_simple/components/footer.php') ?>

</body>
</html>
