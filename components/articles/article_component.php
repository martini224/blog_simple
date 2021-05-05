<div class="article normal">
    <h1><?php echo $article['title'] ?></h1>
    <div class="d-flex mb-1">
        <div class="flex-grow-1">
            <img src="<?php echo $article['image_extension'] ?>" class="<?php echo (is_null($article['image_extension']) ? 'd-none' : '') ?> article-user-image rounded-circle user-avatar small" alt="user-image"> {{user_pseudo}}
        </div>
        <div class="me-3">
            <?php echo $article['created_at'] ?>
        </div>
        <div>
            <a class="btn btn-primary edit-article d-none" href="/article/edit?uuid={{uuid}}" role="button"><i class="fas fa-edit"></i></a>
            <button class="btn btn-primary delete-article d-none" role="button"><i class="fas fa-trash"></i></button>
        </div>
    </div>
    <div>
        <img src="<?php echo "http://localhost/php_simple/resources/images/articles/" . $article['id'] . '.' . $article['image_extension'] ?>" class="card-img-top article-image" alt="article-image">
    </div>
    <div class="mt-3">
        <div>
            <?php echo $article['body'] ?>
        </div>
    </div>
    <div class="d-none article-uuid"><?php echo $article['id'] ?></div>
</div>
