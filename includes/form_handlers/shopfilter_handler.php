<?php

function rarity($type)
{
    $output = '';
    require_once 'config/configDb.php';
    $db = connectDB();

    if (is_string($db)) {
        //error connecting to the database
        echo ("Fatal error! Please return later.");
        die();
    }

    $query = "SELECT * FROM shop WHERE rarity='{$type}'";

    $statement = mysqli_prepare($db, $query);

    if (!$statement) {
        //error preparing the statement. This should be regarded as a fatal error.
        echo "Something went wrong. Please try again later.";
        die();
    }

    //execute the prepared statement
    $result = mysqli_stmt_execute($statement);

    if (!$result) {
        //again a fatal error when executing the prepared statement
        echo "Something went very wrong. Please try again later.";
        die();
    }

    //get the result set to further deal with it
    $result = mysqli_stmt_get_result($statement);

    if (!$result) {
        //again a fatal error: if the result cannot be stored there is no going forward
        echo "Something went wrong. Please try again later.";
        die();
    }

    while ($row = mysqli_fetch_assoc($result)) {
        if ($type == "Unusual") {
            $itemRarity = "#8650AC";
        } else if ($type == "Unique") {
            $itemRarity = "#FFD700";
        } else if ($type == "Genuine") {
            $itemRarity = "#4D7455";
        } else {
            $itemRarity = "#B2B2B2";
        }
        $output .= '<div class="col-lg-3 mb-3 d-flex align-items-stretch">
            <div class="card" style="width: 18rem; background-color: #101822; padding-bottom:50px;">

                 <form method="POST" action="buy.php">

                 <img class="card-img-top" style="background-color: #071215" src="' . $row["item_image"] . '">
                <div class="card-body d-flex flex-column">
                <h5 class="card-title" style="color:' . $itemRarity . '">' . $row["product"] . '<span class="badge bg-dark">€' . number_format($row["price"], 2) . '</span></h5>
                <h6 class="card-subtitle text-white">' . $row['item_description'] . '</h6>
                  <input type="hidden" name="product" value="' . $row['product'] . '">
                  <input type="hidden" name="price" value="' . $row['price'] . '">
                  <input type="hidden" name="id" value="' . $row['id'] . '">
                  <input type="hidden" name="item_description" value="' . $row['item_description'] . '">
        <div class="card-footer" style="position:absolute; bottom: 0;">
          <input type="submit" name="add_to_cart" class="btn btn-success" value="Add to Cart">
        </div>
        </div>


                </form>
                </div>
                <br>
                </div>

             ';
    }

    echo $output;

}
