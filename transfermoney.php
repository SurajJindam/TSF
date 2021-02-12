<?php
$error = "";
$success ="";
$temp = $_GET['id'];
include 'connection.php';

if(array_key_exists("submit",$_POST)){
    $from = $temp;
    $to = $_POST['name'];
    $balance = $_POST['balance'];

    if($to == ""){
        $error.= "Enter Receiver Name.<br>";
    }
    if($balance == ""){
        $error.= "Enter the Balance to be transferred.<br>";
    }
    if($error == ""){
        $query1 = "SELECT * FROM customers WHERE `Cust.No` ='".mysqli_real_escape_string($link,$from)."'";
        $result1 = mysqli_query($link,$query1);
        $row1 = mysqli_fetch_assoc($result1);

        $query2 = "SELECT * FROM customers WHERE `Name` ='".mysqli_real_escape_string($link,$to)."'";
        $result2 = mysqli_query($link,$query2);
        if(mysqli_num_rows($result2)>0){
            $row2 = mysqli_fetch_assoc($result2);
        }
        else{
            $error.= "Enter Valid Name of the Receiver.<br>";
        }
        

        if($balance > $row1['Balance']){
            $error.="InSufficient Funds to transfer.<br>";
        }
        if($balance <= 0){
            $error.="Zero(Negative) Value cannot be transferred.<br>";
        }
        if($error == ""){
            $newBalance1 = $row1['Balance'] - $balance;
            $newBalance2 = $row2['Balance'] + $balance;

            $query3 = "UPDATE customers set `Balance`='".mysqli_real_escape_string($link,$newBalance1)."' WHERE `Cust.No` =  '".mysqli_real_escape_string($link,$row1['Cust.No'])."'";
            $result3 = mysqli_query($link,$query3);

            $query4 = "UPDATE customers set `Balance`='".mysqli_real_escape_string($link,$newBalance2)."' WHERE `Cust.No` =  '".mysqli_real_escape_string($link,$row2['Cust.No'])."'";
            $result4 = mysqli_query($link,$query4);

            $query5 = "INSERT INTO `transfers` (Transactionid,FromAccount,ToAccount,Amount) VALUES(NULL,'".mysqli_real_escape_string($link,$row1['Name'])."','".mysqli_real_escape_string($link,$row2['Name'])."','".mysqli_real_escape_string($link,$balance)."') ";
            $result5 = mysqli_query($link,$query5);

            echo "<script>  alert('Transaction Successfull');
                            window.location='transactions.php'; 
                </script>";

        }
    }

}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style3.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <title>Transactions</title>
</head>

<body>
    <main>
    <?php include 'menubar.php' ?>
    <section class ="error" >
        <p><?php echo $error; ?>
    </section>
    <section class ="success" >
        <p><?php echo $success; ?>
    </section>
        <?php

        include 'connection.php';
        $id =$temp;
        $query = "SELECT * FROM customers WHERE `Cust.No` ='".mysqli_real_escape_string($link,$id)."' ";
        $result = mysqli_query($link,$query);
        $row = mysqli_fetch_assoc($result);
        ?>

        <div class="table">
            <table>
                <tr>
                    <th>Cust.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Balance</th>
                </tr>
                <tr>
                    <th><?php echo $row['Cust.No'] ?></th>
                    <th><?php echo $row['Name'] ?></th>
                    <th><?php echo $row['Email'] ?></th>
                    <th><?php echo $row['Balance'] ?></th>
                </tr>
            </table>
        </div>
        <form method = "post" class="transaction-input">
            <label>Name</label>
            <!-- <input type="text" name="name" value ="Sai Suraj"/><br> -->
            <select name="name" class="customers">
                <option value="Cust">Select Reciever</option>
            </select>
            <br>
            <label>Balance</label>
            <input type="text" name="balance" /><br>
            <button type = "submit" name ="submit">Transfer</button>
        </form>
        <section class ="credits">
            <p> © Feb 2021 Made by : Jindam SaiSuraj</p>
            <p> GRIP The Sparks Foundation </p>
        </section>
    </main>
    <script>
        <?php 
            $array = [];
            $query = "SELECT * FROM customers" ;
            $result = mysqli_query($link,$query);
            $rows = mysqli_num_rows($result);
            for ($x = 1; $x <= $rows; $x++) {

                $query = "SELECT `Name` FROM customers WHERE `Cust.No`='".mysqli_real_escape_string($link,$x)."'";
                $result = mysqli_query($link,$query);
                
                $row = mysqli_fetch_assoc($result);
                
                array_push($array,$row);
            
            }
        
        ?>
        var js_array = <?php echo json_encode($array); ?>;
        for(let i=0;i<js_array.length;i++){
            if(js_array[i]['Name'] != `<?php
                 $id = $temp;
                 $query = "SELECT `Name` FROM customers WHERE `Cust.No`='".mysqli_real_escape_string($link,$id)."'"; 
                 $result = mysqli_query($link,$query);
                 $row = mysqli_fetch_assoc($result);
                 echo $row['Name'];
                 ?>` )
                 {
                    let s =`<option name = "name" value="${js_array[i]['Name']}">${js_array[i]['Name']}</option>`;
                    document.querySelector('.customers').insertAdjacentHTML('beforeend',s);
                 }
            
        }   
    </script>
</body>

</html>