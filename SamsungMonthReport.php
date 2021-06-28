<?php


class SamsungMonthReport
{

    protected $DATABASE_HOST = ""; //-replace 
    protected $DATABASE_NAME = ""; //-replace 
    protected $DATABASE_USER = ""; //-replace 
    protected $DATABASE_PASSWORD = ""; //-replace 


    public function __construct()
    {


        $this->mysqli = new mysqli($this->DATABASE_HOST, $this->DATABASE_USER, $this->DATABASE_PASSWORD, $this->DATABASE_NAME);
        $this->today = date("Y-m-d H:i:s");

    }


    public function pool_nomber()
    {

        $sql = "SELECT MAX( pool_nomber ) FROM modx_samsung_promokods ";
        $result = $this->mysqli->query($sql);
        $pool_nomber = $result->fetch_assoc();

         return $this->pool_nomber = $pool_nomber['MAX( pool_nomber )'];

    }

    public function residue_promokods($pool)
    {

        $sql = "SELECT COUNT(
STATUS ) AS un_used_promokods
FROM `modx_samsung_promokods`
WHERE `pool_nomber` = $pool
AND `status` =0 ";
        $result = $this->mysqli->query($sql);
       $residue_promokods = $result->fetch_assoc();
        return  $this->residue_promokods = $residue_promokods['un_used_promokods'];

    }

    public function pool_used_promokods($pool)
    {

        $sql = "SELECT COUNT(
STATUS ) AS used_promokods
FROM `modx_samsung_promokods`
WHERE `pool_nomber` = $pool
AND `status` =1 ";
        $result = $this->mysqli->query($sql);
        $pool_used_promokods = $result->fetch_assoc();
        return  $this->pool_used_promokods = $pool_used_promokods['used_promokods'];

    }

    public function last_month_used_promokods($pool)
    {

        $startlastmonth = mktime(0, 0, 0, date("m")-2, date("d"),   date("Y"));
        $lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));

    $sql = "SELECT COUNT(
time_activate ) AS used_promokods
FROM `modx_samsung_promokods`
WHERE `pool_nomber` = $pool
AND `status` = 1 AND time_activate Between $startlastmonth AND $lastmonth";
        $result = $this->mysqli->query($sql);
        $last_month_used_promokods = $result->fetch_assoc();
        return $this->last_month_used_promokods = $last_month_used_promokods['used_promokods'];

    }

    public function this_month_used_promokods($pool, $date_now)
    {

        $datenow = strtotime($date_now);
        $lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));

        $sql = "SELECT COUNT(
time_activate ) AS used_promokods
FROM `modx_samsung_promokods`
WHERE `pool_nomber` = $pool
AND `status` = 1 AND time_activate Between $lastmonth AND $datenow";
        $result = $this->mysqli->query($sql);
        $this_month_used_promokods = $result->fetch_assoc();
        return $this->this_month_used_promokods = $this_month_used_promokods['used_promokods'];

    }

    public function all_used_promokods()
    {

        $sql = "SELECT COUNT(
STATUS ) AS used_promokods
FROM `modx_samsung_promokods`
WHERE `status` =1 ";
        $result = $this->mysqli->query($sql);
        $all_used_promokods = $result->fetch_assoc();

        return $this->all_used_promokods = $all_used_promokods['used_promokods'];

    }



    public function create(){

        $today = date("Y-m-d H:i:s");


        $this->pool_nomber();
        $this->residue_promokods($this->pool_nomber);
     $this->pool_used_promokods($this->pool_nomber, $today);
     $this->last_month_used_promokods($this->pool_nomber);
       $this->this_month_used_promokods($this->pool_nomber, $today);
       $this->all_used_promokods();
       $this->prognosis = new DateTime(now);
       $outlay = $this->residue_promokods/$this->pool_used_promokods;
       $dpm = "+".round($outlay)." day";
       $this->prognosis->modify("$dpm");
       $this->prognosis->format('d.m.Y');

       return $this;

    }

    public function send(){

       $this->create();
     return $this;

    }

}