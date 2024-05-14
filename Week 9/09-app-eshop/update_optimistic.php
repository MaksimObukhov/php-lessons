<?php
    //připojení k databázi
    require 'db.php';

    //přístup jen pro admina
    require 'admin_required.php';

    #region načtení zboží k aktualizaci
    $stmt = $db->prepare('SELECT * FROM goods WHERE id=:id');
    $stmt->execute([':id'=>@$_REQUEST['id']]);
    $goods = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$goods){
      die("Unable to find goods!"); // Pokud zboží neexistuje
    }

    $name = $goods['name'];
    $description = $goods['description'];
    $price = $goods['price'];
    #endregion načtení zboží k aktualizaci

    if (!empty($_POST)) {
      $formErrors = '';

      #region kontroly odeslaných dat
      if (empty($_POST['name'])) {
        $formErrors .= 'Name must not be empty. ';
      }

      if (strlen($_POST['description']) > 1000) {
        $formErrors .= 'Description too long. ';
      }

      if (!is_numeric($_POST['price']) || floatval($_POST['price']) < 0) {
        $formErrors .= 'Price must be a positive number. ';
      }
      #endregion kontroly odeslaných dat

      $name = $_POST['name'];
      $description = $_POST['description'];
      $price = floatval($_POST['price']);

      // Získání aktuálních dat z DB pro porovnání
      $stmt = $db->prepare('SELECT * FROM goods WHERE id=:id');
      $stmt->execute([':id'=> $goods['id']]);
      $current_goods = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($_POST['last_updated_at'] != $current_goods['last_updated_at']) {
        $changes = [];
        foreach (['name', 'description', 'price'] as $field) {
          if ($current_goods[$field] != $_POST[$field]) {
            $changes[$field] = ['old' => $current_goods[$field], 'new' => $_POST[$field]];
          }
        }

        $_SESSION['changes'] = $changes;
        exit("The goods were updated by someone else in meantime! Please resolve conflicts.");
      }

      if (empty($formErrors)){
        #region uložení zboží do DB
        $stmt = $db->prepare('UPDATE goods SET name=:name, description=:description, price=:price, last_updated_at=now() WHERE id=:id LIMIT 1;');
        $stmt->execute([
          ':name' => $name,
          ':description' => $description,
          ':price' => $price,
          ':id' => $goods['id']
        ]);
        header('Location: index.php');
        exit();
      }
    }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>PHP Shopping App</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <?php include 'navbar.php' ?>

        <h1>Update goods</h1>

        <?php
        if (!empty($formErrors)){
          echo '<p style="color:red;">'.$formErrors.'</p>';
        }
        if (!empty($_SESSION['changes'])) {
          echo '<div style="color: red;">';
          echo '<p>Some data has been changed by another user. Please review the changes:</p>';
          foreach ($_SESSION['changes'] as $field => $values) {
            echo "<p><strong>$field:</strong> DB value: ".$values['old']." | Your input: ".$values['new']."</p>";
          }
          echo '</div>';
          unset($_SESSION['changes']);
        }
        ?>

        <form method="post">
            <label for="name">Name</label><br/>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars(@$name);?>" required><br/><br/>

            <label for="price">Price</label><br/>
            <input type="number" min="0" name="price" id="price" value="<?php echo htmlspecialchars(@$price)?>" required><br/><br/>

            <label for="description">Description</label><br/>
            <textarea name="description" id="description"><?php echo htmlspecialchars(@$description)?></textarea><br/><br/>

            <input type="hidden" name="id" value="<?php echo $goods['id']; ?>" />
            <input type="hidden" name="last_updated_at" value="<?php echo $goods['last_updated_at']; ?>">

            <input type="submit" value="Save" /> or <a href="index.php">Cancel</a>
        </form>

    </body>
</html>
