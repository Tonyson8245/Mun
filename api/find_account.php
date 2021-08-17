<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header("Content-type:application/json");

    include_once $_SERVER["DOCUMENT_ROOT"] . "/util/db.php";

    $type = $_GET['type'];
    $response = array();

    if ($type == "find_id") {
        $user_phonenum = $_GET['user_phonenum'];
        $user_birthday = $newDate = date("Y-m-d", strtotime($_GET['user_birthday']));

        $sql = mysqli_query($con, "SELECT * FROM USER WHERE user_phonenum = '$user_phonenum'");

        if (mysqli_num_rows($sql) > 0) {
            while ($row = mysqli_fetch_assoc($sql)) {
                if($row['user_birthday']==$user_birthday){
                    $response['result'] = "success";
                    $userinfo = array(
                        "user_id" => $row["user_id"]
                    );
                }
                else{
                    $response['result'] = "birthday";
                }
            }
        } else {
            $response['result'] = "failed";
            $response['data'] = "no data";
        }

        $response['data'] = $userinfo;
    }
    else if ($type == "find_pw") {
        $user_id = $_GET['user_id'];
        $user_phonenum = $_GET['user_phonenum'];

        $sql = mysqli_query($con, "SELECT user_id,user_phonenum FROM USER WHERE user_id = '$user_id'");

        if (mysqli_num_rows($sql) > 0) {
            while ($row = mysqli_fetch_assoc($sql)) {
                if($user_phonenum==$row['user_phonenum']){
                    $response['result']="success";
                    $userinfo = array(
                        "user_id" => $row["user_id"]
                    );
                }
                else{
                    $response['result']="user_phonenum_not_match";
                    $userinfo = array(
                        "user_id" => "no data"
                    );
                }
            }
        }
        else {
            $response['result'] = "id_not_find";
            $userinfo = array(
                "user_id" => "no data"
            );
        }
        $response['data'] = $userinfo;
    }
}
echo json_encode($response);