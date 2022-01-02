<?php 
    include("includes/header.php");
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
    <div class="container">
    <h2>Users</h2>
    <ul class="list-group">
  <li class="list-group-item">Cascavel <button type="button" class="btn btn-danger btn-sm" style="float: right">Delete user</button> <button type="button" class="btn btn-warning btn-sm" style="float: right; margin-right: 10px">Make admin</button></li>
  <li class="list-group-item">Nuno <button type="button" class="btn btn-danger btn-sm" style="float: right">Delete user</button> <button type="button" class="btn btn-warning btn-sm" style="float: right; margin-right: 10px">Make admin</button></li>
</ul>
<h2>Items</h2>
<ul class="list-group">
  <li class="list-group-item">An active item</li>
  <li class="list-group-item">A second item</li>
  <li class="list-group-item">A third item</li>
  <li class="list-group-item">A fourth item</li>
  <li class="list-group-item">And a fifth one</li>
</ul>
    </div>
    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

