<?php

require_once __DIR__ .'/../../db.php';

$postId='';
$postCategory=(!empty($_REQUEST['category'])?intval($_REQUEST['category']):'');
$postText='';

if (!empty($_REQUEST['id'])){
    $postQuery=$db->prepare('SELECT * FROM posts WHERE post_id=:id LIMIT 1;');
    $postQuery->execute([':id'=>$_REQUEST['id']]);
    if ($post=$postQuery->fetch(PDO::FETCH_ASSOC)){
        $postId=$post['post_id'];
        $postCategory=$post['category_id'];
        $postText=$post['text'];
    }else{
        exit('Prispěvek neexistuje.');
    }
}

$errors=[];
if (!empty($_POST)){
    if (!empty($_POST['category'])){

        $categoryQuery=$db->prepare('SELECT * FROM categories WHERE category_id=:category LIMIT 1;');
        $categoryQuery->execute([
            ':category'=>$_POST['category']
        ]);
        if ($categoryQuery->rowCount()==0){
            $errors['category']='Zvolena kategorie neexistuje!';
            $postCategory='';
        }else{
            $postCategory=$_POST['category'];
        }

    }else{
        $errors['category']='Musite vybrat kategorii.';
    }
    $postText=trim(@$_POST['text']);
    if (empty($postText)){
        $errors['text']='Musite zadat text prispevku.';
    }

    if (empty($errors)){

        if ($postId){
            $saveQuery=$db->prepare('UPDATE posts SET category_id=:category, text=:text WHERE post_id=:id LIMIT 1;');
            $saveQuery->execute([
                ':category'=>$postCategory,
                ':text'=>$postText,
                ':id'=>$postId
            ]);
        }else{
            $saveQuery=$db->prepare('INSERT INTO posts (user_id, category_id, text) VALUES (:user, :category, :text);');
            $saveQuery->execute([
                ':user'=>1,
                ':category'=>$postCategory,
                ':text'=>$postText
            ]);
        }

        header('Location: index.php?category='.$postCategory);
        exit();
    }
}

if ($postId){
    $pageTitle='Uprava prispevku';
}else{
    $pageTitle='Novy prispevek';
}

include 'header.php';
?>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo $postId;?>" />

        <div class="form-group">
            <label for="category">Kategorie:</label>
            <select name="category" id="category" required class="form-control <?php echo (!empty($errors['category'])?'is-invalid':''); ?>">
                <option value="">--vyberte--</option>
                <?php
                $categoryQuery=$db->prepare('SELECT * FROM categories ORDER BY name;');
                $categoryQuery->execute();
                $categories=$categoryQuery->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($categories)){
                    foreach ($categories as $category){
                        echo '<option value="'.$category['category_id'].'" '.($category['category_id']==$postCategory?'selected="selected"':'').'>'.htmlspecialchars($category['name']).'</option>';
                    }
                }
                ?>
            </select>
            <?php
            if (!empty($errors['category'])){
                echo '<div class="invalid-feedback">'.$errors['category'].'</div>';
            }
            ?>
        </div>

        <div class="form-group">
            <label for="text">Text prispevku:</label>
            <textarea name="text" id="text" required class="form-control <?php echo (!empty($errors['text'])?'is-invalid':''); ?>"><?php echo htmlspecialchars($postText)?></textarea>
            <?php
            if (!empty($errors['text'])){
                echo '<div class="invalid-feedback">'.$errors['text'].'</div>';
            }
            ?>
        </div>

        <button type="submit" class="btn btn-primary">Ulozit</button>
        <a href="index.php?category=<?php echo $postCategory;?>" class="btn btn-light">Zrusit</a>
    </form>

<?php
include 'footer.php';
