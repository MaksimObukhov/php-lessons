<?php
//načteme připojení k databázi
require_once __DIR__ .'/../../db.php';

//vložíme do stránek hlavičku
include 'header.php';

if (!empty($_GET['category'])){
    $query = $db->prepare('SELECT
                           posts.*, users.name AS user_name, users.email, categories.name AS category_name
                           FROM posts JOIN users USING (user_id) JOIN categories USING (category_id) WHERE posts.category_id=:category ORDER BY updated DESC;');
    $query->execute([
        ':category'=>$_GET['category']
    ]);
}else{
    $query = $db->prepare('SELECT
                           posts.*, users.name AS user_name, users.email, categories.name AS category_name
                           FROM posts JOIN users USING (user_id) JOIN categories USING (category_id) ORDER BY updated DESC;');
    $query->execute();
}

echo '<form method="get" id="categoryFilterForm">
          <label for="category">Kategorie:</label>
          <select name="category" id="category" onchange="document.getElementById(\'categoryFilterForm\').submit();">
            <option value="">--nerozhoduje--</option>';

$categories=$db->query('SELECT * FROM categories ORDER BY name;')->fetchAll(PDO::FETCH_ASSOC);
if (!empty($categories)){
    foreach ($categories as $category){
        echo '<option value="'.$category['category_id'].'"';
        if ($category['category_id']==@$_GET['category']){
            echo ' selected="selected" ';
        }
        echo '>'.htmlspecialchars($category['name']).'</option>';
    }
}

echo '  </select>
          <input type="submit" value="OK" class="d-none" />
        </form>';

$posts = $query->fetchAll(PDO::FETCH_ASSOC);
if (!empty($posts)){
    echo '<div class="row">';
    foreach ($posts as $post){
        echo '<article class="col-12 col-md-6 col-lg-4 col-xxl-3 border border-dark mx-1 my-1 px-2 py-1">';
        echo '  <div><span class="badge badge-secondary">'.htmlspecialchars($post['category_name']).'</span></div>';
        echo '  <div>'.nl2br(htmlspecialchars($post['text'])).'</div>';
        echo '  <div class="small text-muted mt-1">';
        echo htmlspecialchars($post['user_name']);
        echo ' ';
        echo date('d.m.Y H:i:s',strtotime($post['updated']));
        echo ' - <a href="edit.php?id='.$post['post_id'].'" class="text-danger">upravit</a>';
        echo '  </div>';
        echo '</article>';
    }
    echo '</div>';
}else{
    echo '<div class="alert alert-info">Nebyly nalezeny zadne prispevky.</div>';
}

echo '<div class="row my-3">
          <a href="edit.php?category='.@$_GET['category'].'" class="btn btn-primary">Pridat prispevek</a>
        </div>';

include 'footer.php';
