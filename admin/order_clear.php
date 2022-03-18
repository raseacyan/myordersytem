<?php
session_start();
include('../inc/connect.php');
include('../inc/functions.php');


clearOrder();
redirectTo('order_create.php');