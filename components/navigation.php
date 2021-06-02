<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/blog/resources/images/bootstrap-logo.svg" alt="" width="30" height="24" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/blog_simple/pages/articles/articles.php">Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/blog_simple/pages/articles/article_form.php">Créer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/blog_simple/pages/users/users.php">Utilisateurs</a>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                    <div class="container-fluid">
                        <form class="d-flex" method="GET" action="http://localhost/blog_simple/pages/articles/articles.php">
                            <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                    <?php
                        require($_SERVER['DOCUMENT_ROOT'] . '/blog_simple/components/users/' . (isset($user) ? 'user_actions' : 'login') . '.php');
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
