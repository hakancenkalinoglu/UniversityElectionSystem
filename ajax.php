<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Istanbul Ticaret Universitesi Tercih Robotu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' type='text/css' href='style.css'>    
</head>

<div class='container-fluid mt-5 table-responsive'>
<table id='myTable' class='table content-table table-sortable table-bordered table-striped'>
    <thead class='w3-blue'>
            <tr>
                <th class='th-sm'>Program Kodu</th>
                <th>Üniversite</th>
                <th>Bölüm</th>
                <th>Puan Türü</th>
                <th>Burs</th>
                <th>Taban Puan 2020</th>
                <th>Taban Puan 2019</th>
                <th>Taban Sıralama 2020</th>
                <th>Taban Sıralama 2019</th>
            </tr>
        </thead>
<tbody id='myTableBody'>
<?php
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require __DIR__.'/PHPMailer/src/Exception.php';
    require __DIR__.'/PHPMailer/src/PHPMailer.php';
    require __DIR__.'/PHPMailer/src/SMTP.php';


    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '112358');
    define('DB_NAME', 'tercihrobotu');
    $html = "";


    try {
        $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }catch (Exception $e){
        echo $e->getMessage() . "<br>";
        while($e = $e->getPrevious()) {
            echo 'Previous exception: '.$e->getMessage() . "<br/>";
        }
    }

    if (isset($_POST['id'])) {
        $ids[] = $_POST['id'];
        $arrLength = count($_POST['id']);;
        
        #print_r($ids);
    }

    if (!empty($ids) OR isset($_POST['action']))
            {
                for($i = 0; $i < $arrLength; $i++) {
                    $id = $ids[0][$i];
                    echo $id;
                    $sql = "SELECT uni_name, department, program_code, point_type, coalesce(scholarship, 'Devlet') ,min_point_2020, min_point_2019, success_order_2020, success_order_2019 FROM sayfa2 WHERE program_code='$id'";
                    echo $sql;       
                    if ($result = mysqli_query($conn, $sql))
                    {
                        if (mysqli_num_rows($result) > 0)
                        {
                            while ($row = mysqli_fetch_array($result))
                            {
                                echo "</tr>".

                                "<td>".$row['program_code']."</td>".
                                "<td>".$row['uni_name']."</td>".
                                "<td>".$row['department']."</td>".
                                "<td>".$row['point_type']."</td>".
                                "<td>".$row["coalesce(scholarship, 'Devlet')"]."</td>".
                                "<td>".$row['min_point_2020']."</td>".
                                "<td>".$row['min_point_2019']."</td>".
                                "<td>".$row['success_order_2020']."</td>".
                                "<td>".$row['success_order_2019']."</td>"

                                ."</tr>";


                                $mail = new PHPMailer();
                                $mail->IsSMTP();
                                $mail->SMTPAuth = true;
                                $mail->Host = 'smtp.gmail.com';
                                $mail->Port = 587;
                                $mail->SMTPSecure = 'tls';
                                $mail->Username = 'totallytestmail@gmail.com';
                                $mail->Password = 'test123test';
                                $mail->SetFrom('totallytestmail@gmail.com');
                                #$mail->AddReplyTo('you@somewhereelse.com');
                                $mail->IsHTML(TRUE);


                                // set the email address
                                $mail->AddAddress($_POST['email'], $_POST['fname']);


                                // html content for smart email clients
                                $html = $html.<<<EOL
                                <h1>Welcome</h1>

                                <p>{$row['program_code']}.</p>
                                <p>{$row['uni_name']}.</p>
                                <p>{$row['department']}.</p>
                                <p>{$row['point_type']}.</p>
                                <p>{$row["coalesce(scholarship, 'Devlet')"]}.</p>
                                <p>{$row['min_point_2020']}.</p>
                                <p>{$row['min_point_2019']}.</p>
                                <p>{$row['success_order_2020']}.</p>
                                <p>{$row['success_order_2019']}.</p>

                                EOL;

                            }
                            
                            // add the content to the mail
                            
                            mysqli_free_result($result);
                        }
                        else
                        {
                            echo "<script type='text/JavaScript'> alert('Something went wrong...); </script>";
                        }
                    }
                    else
                    {
                        echo "ERROR: Could not execute $sql" . mysqli_error($conn);
                    }

                }

                if (isset($_POST['action'])) {
    // btnDelete 
                                echo "saa";
                                $mail->MsgHTML($html);
                                // add alternate content 
                                #$mail->AltBody($text);


                                // send the mail
                                if ($mail->Send()) {
                                   // mail sent correctly
                                } else {
                                   die("Uhoh, could not send to {$mail['email']}:" . $mail->ErrorInfo);
                                }
                                }
            }


?>
</tbody>
</table>
</div>
