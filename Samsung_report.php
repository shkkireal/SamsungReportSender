<?php
require_once ('SamsungMonthReport.php');
require_once ('SamsungMailSender.php');


$report = new SamsungMonthReport();
$report->create();

$reqest = new SamsungMailSender($report);
$reqest->send_report();
echo "ok";
