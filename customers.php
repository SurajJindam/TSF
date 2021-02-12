<?php

include 'connection.php';
$array = [];
$query = "SELECT * FROM customers" ;
$result = mysqli_query($link,$query);
$rows = mysqli_num_rows($result);

for ($x = 1; $x <= $rows; $x++) {

    $query = "SELECT * FROM customers WHERE `Cust.No`='".mysqli_real_escape_string($link,$x)."'";
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
    <link href="style1.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <title>User Accounts</title>

</head>

<body>
    <main>
    <?php include 'menubar.php' ?>
        <div class="heading">
            <h2>Customer List</h2>
        </div>

        <div class="table">
            <table>
            <tr>
                <th>Cust.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Balance</th>
                <th>Transfer</th>
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
            <td> ${js_array[i]['Cust.No']}</td>
            <td> ${js_array[i]['Name']}</td>
            <td> ${js_array[i]['Email']}</td>
            <td> ${js_array[i]['Balance']}</td>
            <td><a href ="transfermoney.php?id=${js_array[i]['Cust.No']}"><button>Transfer</button></a></td>
            </tr>`;
            document.querySelector('table').insertAdjacentHTML('beforeend',s);
        }
        
    </script>
</body>

</html>




