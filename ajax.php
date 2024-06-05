<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if ($action == 'login') {
    $login = $crud->login();
    if ($login)
        echo $login;
}
if ($action == 'logout') {
    $logout = $crud->logout();
    if ($logout)
        echo $logout;
}
if ($action == 'save_user') {
    $save = $crud->save_user();
    if ($save)
        echo $save;
}
if ($action == 'save_page_img') {
    $save = $crud->save_page_img();
    if ($save)
        echo $save;
}
if ($action == 'delete_user') {
    $save = $crud->delete_user();
    if ($save)
        echo $save;
}
if ($action == "save_customer") {
    $save = $crud->save_customer();
    if ($save)
        echo $save;
}
if ($action == "delete_customer") {
    $delete = $crud->delete_customer();
    if ($delete)
        echo $delete;
}
if ($action == "save_staff") {
    $save = $crud->save_staff();
    if ($save)
        echo $save;
}
if ($action == "delete_staff") {
    $delete = $crud->delete_staff();
    if ($delete)
        echo $delete;
}
if ($action == "save_tables") {
    $save = $crud->save_tables();
    if ($save)
        echo $save;
}
if ($action == "delete_tables") {
    $delete = $crud->delete_tables();
    if ($delete)
        echo $delete;
}
if ($action == "update_ticket") {
    $save = $crud->update_ticket();
    if ($save)
        echo $save;
}
if ($action == "save_ticket") {
    $save = $crud->save_ticket();
    if ($save)
        echo $save;
}
if ($action == "delete_ticket") {
    $delete = $crud->delete_ticket();
    if ($delete)
        echo $delete;
}
if ($action == "save_comment") {
    $save = $crud->save_comment();
    if ($save)
        echo $save;
}
if ($action == "delete_comment") {
    $delete = $crud->delete_comment();
    if ($delete)
        echo $delete;
}

ob_end_flush();
