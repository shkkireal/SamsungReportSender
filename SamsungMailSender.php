<?php
require_once ('Mail.php');

class SamsungMailSender extends Mail
{
    protected $emailTo = "YOU EMAIL"; //-replace 
    protected $emailFrom = "report@YOU DOMEN.COM"; //-replace 

public function __construct($report){

    $this->report=$report;
    $this->today = date("Y-m-d");
}


public function send_report(){

    $subject="Отчет по промокодам Самуснг на ".$this->today;
    $message = "<h1>Добрый день !</h1> 

<p> Дата: <b>".$this->today."</b>
<p> Номер текущего пула: <b>".$this->report->pool_nomber."</b>
<p> Текущий остаток промокодов: <b>".$this->report->residue_promokods."</b>
<p> Из пула использовано промокодов: <b>".$this->report->pool_used_promokods."</b>
<p> <b>Использовано:</b>
<p> за прошлый месяц - <b> ".$this->report->last_month_used_promokods."</b>
<p> за текущий месяц - <b>".$this->report->this_month_used_promokods."</b>
<p> Общее колличество использованных промокод за все время: <b> ".$this->report->all_used_promokods."</b>
<p> Прогноз полного израсходования текущего пула промокодов: <b>".$this->report->prognosis->format('d.m.Y')."</b>

";
    $mail = new Mail;
    $mail->from($this->emailFrom);
    $mail->to($this->emailTo);
    $mail->subject = $subject;
    $mail->body =$message."";
    $mail->send();
    return $mail;

}

}