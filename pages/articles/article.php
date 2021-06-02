<?php require_once($_SERVER['DOCUMENT_ROOT'].'/blog_simple/app/session.php'); ?>

<?php
require($_SERVER['DOCUMENT_ROOT'].'/blog_simple/app/db.php');

$id = null;

if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

$article = null;

if(isset($db) && isset($id)) {
    try {
        $sql = "SELECT id, title, excerpt, body, image_extension, users_id, created_at, updated_at FROM article where id = :id LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $article = $stmt->fetch();

        if(!$article) {
            $article = null;
        }

        $db = null;
    } catch (Exception $exception) {
        echo $exception;
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
                <?php
                    if(is_null($article)) {
                        require($_SERVER['DOCUMENT_ROOT'] . '/blog_simple/components/errors/not_found.php');
                    } else {
                        require($_SERVER['DOCUMENT_ROOT'] . '/blog_simple/components/articles/article_component.php');
                    }
                ?>
            </div>
        </div>
    </div>
</main>

<?php require_once($_SERVER['DOCUMENT_ROOT'].'/blog_simple/components/footer.php') ?>

</body>
</html>
