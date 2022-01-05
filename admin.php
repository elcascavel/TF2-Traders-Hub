<?php
    include("includes/header.php");
    require 'includes/form_handlers/admin_handler.php';
    
    if($userIsAdmin == 0) {
        header("Location: index.php");
    }

    
?>

<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=9">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TF2 Trader's Hub - Admin</title>
        <link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico">
        <link rel="stylesheet" href="../TH/css/main.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container-xl mt-2">
    <h1>Admin Panel</h1>
    <?php echo "<h5>Welcome, $userLoggedIn</h5>"?>
    <div class="row">
    <?php 
        $table = "";
        $is_adminString = "Make";

        $table.="
        <table class='table table-hover table-bordered align-middle text-center'>
        <thead>
        <tr>
        <th scope='col'>#</th>
        <th scope='col'>Username</th>
        <th scope='col'>Date Created</th>
        <th scope='col'>Role</th>
        <th scope='col'>Action</th>
        </tr>
        </thead>
        ";
 
        while($user = mysqli_fetch_assoc($user_result)) {
            $adminCheck = $user['is_admin'];
            if ($adminCheck) {
                $adminCheck = "Admin";
                $is_adminString = "Remove";
            }
            else {
                $adminCheck = "User";
                $is_adminString = "Make";
            }
            $table.="
            <tr>
            <td>".$user['id_users']."</td>
            <td><img class='adminPanelAvatar' src=".$user['user_pic']."><b>".$user['username']."</b></td>
            <td>".date("jS F, Y", strtotime($user['signup_date']))."</td>
            <td>".$adminCheck."</td>
            <td><a type='button' href='admin.php?id=".$user['id_users']."'class='btn btn-primary btn-sm'>".$is_adminString." admin</a> <button type='button' class='btn btn-danger btn-sm'>Delete user</button></td>
            </tr>
            ";
        }
        echo $table . "</table>";
    ?>
    </div> 
<div class="row">
<h2 class="mt-5">Items</h2>
<?php 
         $table = "";

         $table.="
         <table class='table table-hover table-bordered align-middle text-center'>
         <thead>
         <tr>
         <th scope='col'>#</th>
         <th scope='col'>Item Name</th>
         <th scope='col'>Price</th>
         <th scope='col'>Action</th>
         </tr>
         </thead>
         ";
  
         while($item = mysqli_fetch_assoc($shop_result)) {
            if ($item['rarity'] == "Unusual") {
                $itemRarity = "#8650AC";
            }
            else if ($item['rarity'] == "Unique"){
                $itemRarity = "#FFD700";
            }
            else if ($item['rarity'] == "Genuine"){
                $itemRarity = "#4D7455";
            }
            else {
                $itemRarity = "#B2B2B2";
            }
             $table.="
             <tr>
             <td>".$item['id']."</td>
             <td><img class='adminPanelAvatar' src=".$item['item_image']."><b><p style='color:$itemRarity; display:inline'>".$item['product']."</p></b></td>
             <td>€".$item['price']."</td>
             <td><button type='button' class='btn btn-primary btn-sm'>Edit item</button> <button type='button' class='btn btn-danger btn-sm'>Delete item</button></td>
             </tr>
             ";
         }
         echo $table . "</table>";
         ?>
</div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>