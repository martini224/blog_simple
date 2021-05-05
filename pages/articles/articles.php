<?php require_once($_SERVER['DOCUMENT_ROOT'].'/php_simple/app/session.php'); ?>

<?php
    require($_SERVER['DOCUMENT_ROOT'].'/php_simple/app/db.php');

    $articles = [];

    if(isset($db)) {
        try {
            $sql = "SELECT id, title, excerpt, body, image_extension, users_id, created_at, updated_at FROM article order by updated_at desc";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $articles = $stmt->fetchAll();

            $db = null;
        } catch (Exception $exception) {
            echo $exception;
        }
    }
?>

<!doctype html>
<html lang="fr">
<head>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/php_simple/components/headers.php') ?>

    <script>

    </script>

    <title>Home blog</title>
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/php_simple/components/navigation.php') ?>

<main role="main">
    <?php echo realpath('app/session.php') ?>
    <div class="container">
        <div class="row">
            <div class="col articles">
                <?php

                    foreach ($articles as $article) {
                        echo '<div class="article small card">' .
                            '<img src="' . $article['image_extension'] . '" class="card-img-top ' . (isset($article['image_extension']) ? '' : 'd-none') . ' article-image" alt="article-image">' .
                            '<div class="card-body">' .
                            '    <h5 class="card-title">' .  $article['title'] . '</h5>' .
                            '   <p class="card-text article-excerpt">' . $article['excerpt'] . '</p>' .
                            '    <a href="http://localhost/php_simple/pages/articles/article.php?id=' . $article['id'] . '" class="btn btn-primary">Lire l article</a>' .
                            '</div>' .
                            '<div class="card-footer">' .
                            '    <small class="text-muted">' . $article['updated_at'] . '</small>' .
                            '</div>' .
                            '<div class="d-none article-uuid">' . $article['id'] . '</div>' .
                            '</div>';
                    }

                    if(empty($articles)) {
                        echo "<p>Pas d'articles...</p>";
                    }
                ?>
            </div>
        </div>
    </div>
</main>

<?php require_once($_SERVER['DOCUMENT_ROOT'].'/php_simple/components/footer.php') ?>

</body>
</html>
