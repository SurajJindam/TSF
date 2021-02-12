<?php

include 'connection.php';
$array = [];
$query = "SELECT * FROM transfers" ;
$result = mysqli_query($link,$query);
$rows = mysqli_num_rows($result);

for ($x = 1; $x <= $rows; $x++) {

    $query = "SELECT * FROM transfers WHERE `Transactionid`='".mysqli_real_escape_string($link,$x)."'";
    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_assoc($result);
    
    array_push($array,$row);

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style2.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <title>Transactions</title>
</head>

<body>
    <main>
    <?php include 'menubar.php' ?>
        <div class="heading">
            <h2>Recent Transactions</h2>
        </div>
        <div class="table">
            <table>
                <tr>
                    <th>Transaction-Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Balance</th>
                </tr>
            </table>
        </div>
        <section class ="credits">
            <p> © Feb 2021 Made by : Jindam SaiSuraj</p>
            <p> GRIP The Sparks Foundation </p>
        </section>


    </main>
    <script>
        var js_array = <?php echo json_encode($array); ?>;
        for(let i=0;i<js_array.length;i++){
            let s =`<tr>
            <td> ${js_array[i]['Transactionid']}</td>
            <td> ${js_array[i]['FromAccount']}</td>
            <td> ${js_array[i]['ToAccount']}</td>
            <td> ${js_array[i]['Amount']}</td>
            </tr>`;
            document.querySelector('table').insertAdjacentHTML('beforeend',s);
        }
        
    </script>
</body>

</html>