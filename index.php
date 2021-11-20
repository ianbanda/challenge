<!DOCTYPE html>
<?php
session_start();
DEFINE("FRAMEWORK_PATH", dirname(__FILE__) . "/");
//DEFINE("BASEURL", "http://localhost/mra");
DEFINE("BASEURL", "https://www.mra.mw/sandbox/programming/challenge/webservice");

require_once 'Controllers/Apicontroller.php';
$api = new Apicontroller();

if (isset($_POST['loginform'])) {
    $url = BASEURL . "/auth/login";
    //$url = BASEURL."/programming/challenge/Taxpayers/getAll";
    //$url = BASEURL."/Auth/login";

    $email = $_POST["email"];
    $password = $_POST["password"];

    $_POST["email"] = $email;

    $loginarray = array("Email" => $email, "Password" => $password);

    //header("Content-Type:application/json");
    //header("Content-Length:");
    //header("Content-Type:application/multipart/form-data");
    /* header("candidateid:banda.ian45@gmail.com");
      header("Password:password000122");
      header("apikey:3fdb48c5-336b-47f9-87e4-ae73b8036a1c");
     * *
     */
    $data = array(
        "Email" => $email,
        "Password" => $password
    );
    $data = json_encode($data);
    /*
      $headers = array(
      "Content-Type:application/json",
      "Content-Length:" . strlen($data)
      ); */

    $result = $api->processRequest($url, $data, 'POST');
    //echo($result);
    if ($result["ResultCode"] === 1) {
        $_SESSION["loggedin"] = "1";
        echo "logged in";
    } else {
        $_SESSION["loggedin"] = "";
        unset($_SESSION["loggedin"]);
        echo 'user not found';
    }
    //echo json_decode($json_data);
    //print_r($json_data);
}

if (isset($_SESSION["loggedin"])) {
    
} else {
    
}
?>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="Views/css/site.css">
        <link rel="stylesheet" href="Views/css/w3.css">
    </head>
    <body>
        <div class="w3-center" style="margin: auto;">
            <div class="w3-border" style="max-width:250px;margin:auto;">
                <?php if (!isset($_SESSION["loggedin"])) { ?>
                    <form action="" method="POST">
                        <input type="hidden" name="loginform" />

                        <div class="w3-padding">
                            <h6>
                                <input class="w3-input" placeholder="email" type="email" name="email" />
                            </h6>
                            <h6>
                                <input class="w3-input" placeholder="password" type="password" name="password" />
                            </h6>
                            <input class="w3-btn w3-green" value="Login" type="submit" style="width:100%" />
                        </div>
                    </form>
                    <?php
                } else {
                    //$url = BASEURL."/Taxpayers/getAll";
                    //$list = $api->processRequest($url, null, "GET");
                    $url = BASEURL . "/Taxpayers/getAll";
                    $result = $api->processRequest($url, null, 'GET');
                    print_r($result);

                    $taxpayers = $result;
                    ?>
                    <table>
                        <tr>
                            <th>TPIN</th>
                            <th>Trading Name</th>
                            <th>Business Certificate Number</th>
                            <th>Mobile Number</th>
                            <th>Physical Location</th>
                            <th>Username</th>
                        </tr>
                        <?php
                        foreach ($taxpayers as $taxpayer) {
                            ?>
                        <tr>
                            <td><?php echo $taxpayer["TPIN"]; ?></td>
                            <td><?php echo $taxpayer["TradingName"]; ?></td>
                            <td><?php echo $taxpayer["BusinessCertificateNumber"]; ?></td>
                            <td><?php echo $taxpayer["MobileNumber"]; ?></td>
                            <td><?php echo $taxpayer["PhysicalLocation"]; ?></td>
                            <td><?php echo $taxpayer["Username"]; ?></td>
                        </tr>
                            <?php } ?>
                        </table>
                        <?php
                    }
                    ?>
            </div>
        </div>

    </body>
</html>
