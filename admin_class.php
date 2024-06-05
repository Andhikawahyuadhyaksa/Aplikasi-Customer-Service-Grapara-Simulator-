<?php
session_start();
ini_set('display_errors', 1);

class Action
{
    private $db;

    public function __construct()
    {
        ob_start();
        include 'db_connect.php';
        $this->db = $conn;
    }

    function __destruct()
    {
        $this->db->close();
        ob_end_flush();
    }

    function login()
    {
        extract($_POST);
        $qry = null;
        if ($type == 1) // Admin
            $qry = $this->db->query("SELECT *, concat(lastname, ', ', firstname, ' ', middlename) as name FROM users WHERE username = '" . $username . "' AND password = '" . md5($password) . "'");
        elseif ($type == 2) // Manager
            $qry = $this->db->query("SELECT *, concat(lastname, ', ', firstname, ' ', middlename) as name FROM staff WHERE email = '" . $username . "' AND password = '" . md5($password) . "'");
        elseif ($type == 3) // Staff
            $qry = $this->db->query("SELECT *, concat(lastname, ', ', firstname, ' ', middlename) as name FROM staff WHERE email = '" . $username . "' AND password = '" . md5($password) . "'");
        elseif ($type == 4) // Customer
            $qry = $this->db->query("SELECT *, concat(lastname, ', ', firstname, ' ', middlename) as name FROM customers WHERE email = '" . $username . "' AND password = '" . md5($password) . "'");

        if ($qry && $qry->num_rows > 0) {
            foreach ($qry->fetch_array() as $key => $value) {
                if ($key != 'password' && !is_numeric($key))
                    $SESSION['login' . $key] = $value;
            }
            $_SESSION['login_type'] = $type;
            // if ($type == 2) {
            //     return 2; // Manager
            // } else {
            return 1; // Other users
            // }
        } else {
            return 5; // Invalid credentials
        }
    }

    function logout()
    {
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location:login.php");
    }

    function save_user()
    {
        extract($_POST);
        $ue = $_SESSION['login_type'] == 1 ? 'username' : 'email';
        $data = " firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', $ue = '$username' ";
        if (!empty($password))
            $data .= ", password = '" . md5($password) . "' ";
        $chk = $this->db->query("SELECT * FROM $table WHERE $ue = '$username' AND id !='$id' ")->num_rows;
        if ($chk > 0) {
            return 2;
        }
        if (empty($id)) {
            $save = $this->db->query("INSERT INTO $table SET " . $data);
        } else {
            $save = $this->db->query("UPDATE $table SET " . $data . " WHERE id = " . $id);
        }
        if ($save) {
            $_SESSION['login_firstname'] = $firstname;
            $_SESSION['login_middlename'] = $middlename;
            $_SESSION['login_lastname'] = $lastname;
            return 1;
        }
    }

    function delete_user()
    {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM users WHERE id = " . $id);
        if ($delete)
            return 1;
    }

    function save_page_img()
    {
        extract($_POST);
        if ($_FILES['img']['tmp_name'] != '') {
            $fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
            $move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
            if ($move) {
                $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';
                $hostName = $_SERVER['HTTP_HOST'];
                $path = explode('/', $_SERVER['PHP_SELF']);
                $currentPath = '/' . $path[1];
                return json_encode(array('link' => $protocol . '://' . $hostName . $currentPath . '/admin/assets/uploads/' . $fname));
            }
        }
    }

    function save_customer()
    {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id', 'cpass')) && !is_numeric($k)) {
                if ($k == 'password')
                    $v = md5($v);
                if (empty($data)) {
                    $data .= " $k='$v' ";
                } else {
                    $data .= ", $k='$v' ";
                }
            }
        }
        $check = $this->db->query("SELECT * FROM customers WHERE email ='$email' " . (!empty($id) ? " AND id != {$id} " : ''))->num_rows;
        if ($check > 0) {
            return 2;
        }
        if (empty($id)) {
            $save = $this->db->query("INSERT INTO customers SET $data");
        } else {
            $save = $this->db->query("UPDATE customers SET $data WHERE id = $id");
        }
        if ($save)
            return 1;
    }

    function delete_customer()
    {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM customers WHERE id = " . $id);
        if ($delete) {
            return 1;
        }
    }

    function save_staff()
    {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id', 'cpass')) && !is_numeric($k)) {
                if ($k == 'password')
                    $v = md5($v);
                if (empty($data)) {
                    $data .= " $k='$v' ";
                } else {
                    $data .= ", $k='$v' ";
                }
            }
        }
        $check = $this->db->query("SELECT * FROM staff WHERE email ='$email' " . (!empty($id) ? " AND id != {$id} " : ''))->num_rows;
        if ($check > 0) {
            return 2;
        }
        if (empty($id)) {
            $save = $this->db->query("INSERT INTO staff SET $data");
        } else {
            $save = $this->db->query("UPDATE staff SET $data WHERE id = $id");
        }
        if ($save)
            return 1;
    }

    function delete_staff()
    {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM staff WHERE id = " . $id);
        if ($delete) {
            return 1;
        }
    }

    function save_tables()
    {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id')) && !is_numeric($k)) {

                if (empty($data)) {
                    $data .= " $k='$v' ";
                } else {
                    $data .= ", $k='$v' ";
                }
            }
        }
        // echo "Data to be saved: $data\n";
        if (empty($id)) {
            $save = $this->db->query("INSERT INTO tables SET $data");
        } else {
            $save = $this->db->query("UPDATE tables SET $data WHERE id = $id");
        }
        if ($save)
            return 1;
    }
    function delete_tables()
    {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM tables WHERE id = " . $id);
        if ($delete) {
            return 1;
        }
    }

    function save_ticket()
    {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id')) && !is_numeric($k)) {
                if ($k == 'description') {
                    $v = htmlentities(str_replace("'", "&#x2019;", $v));
                }
                if (empty($data)) {
                    $data .= " $k='$v' ";
                } else {
                    $data .= ", $k='$v' ";
                }
            }
        }
        if (!isset($customer_id)) {
            $data .= ", customer_id={$_SESSION['login_id']} ";
        }
        if ($_SESSION['login_type'] == 1) {
            $data .= ", admin_id={$_SESSION['login_id']} ";
        }
        if (empty($id)) {
            $save = $this->db->query("INSERT INTO tickets SET $data");
        } else {
            $save = $this->db->query("UPDATE tickets SET $data WHERE id = $id");
        }
        if ($save)
            return 1;
    }

    function update_ticket()
    {
        extract($_POST);
        $data = "status=$status";
        if ($_SESSION['login_type'] == 3) { // Assuming type 3 is for staff
            $data .= ", staff_id={$_SESSION['login_id']}";
        }
        $save = $this->db->query("UPDATE tickets SET $data WHERE id = $id");
        if ($save)
            return 1;
        else
            return $this->db->error;
    }


    function delete_ticket()
    {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM tickets WHERE id = " . $id);
        if ($delete) {
            return 1;
        }
    }

    function save_comment()
{
    extract($_POST);
    $data = "";
    foreach ($_POST as $k => $v) {
        if (!in_array($k, array('id')) && !is_numeric($k)) {
            if ($k == 'solution') {
                $v = htmlentities(str_replace("'", "&#x2019;", $v));
            }
            if (empty($data)) {
                $data .= " $k='$v' ";
            } else {
                $data .= ", $k='$v' ";
            }
        }
    }
    $data .= ", user_type={$_SESSION['login_type']} ";
    $data .= ", user_id={$_SESSION['login_id']} ";

    // Debugging statements
    error_log("Data to be saved: $data");

    if (empty($id)) {
        $save = $this->db->query("INSERT INTO comments SET $data");
    } else {
        $save = $this->db->query("UPDATE comments SET $data WHERE id = $id");
    }

    if ($save) {
        error_log("Save successful");
        return 1;
    } else {
        error_log("Save failed: " . $this->db->error);
        return 0;
    }
}

    function delete_comment()
    {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM comments WHERE id = " . $id);
        if ($delete) {
            return 1;
        }
    }
}
