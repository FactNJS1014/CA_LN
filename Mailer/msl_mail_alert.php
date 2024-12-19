<?php
define("_USER", "sa");
define("_PASSWORD", "");
class CSQL {

	private $connection; // ประกาศตัวแปรสำหรับไว้เก็บค่าการ Connection
	private $Result; // ประกาศตัวแปรสำหรับไว้เก็บค่า Query result
	private $DataArray = array(); // ประกาศตัวแปรสำหรับไว้เก็บค่าข้อมูลที่ได้จากการ Query โดยเก็บข้อมูลเป็น Array

	// ประกาศ Function การทำงานในส่วนของ Class Constructure
	// จะทำการสร้าง Connection ไปยัง Database หลังจากมีการประกาศ Object
	public function connect($ip , $db) {
        $connectioninfo = array("Database" => $db, "UID" => _USER, "PWD" => _PASSWORD, "CharacterSet" => "UTF-8");
		$this->connection = sqlsrv_connect($ip, $connectioninfo) or die(sqlsrv_errors());


		return($this);
		// $connectioninfo = array("Database" => _DATABASE, "UID" => _USER, "PWD" => _PASSWORD, "CharacterSet" => "UTF-8");
		// $this->connection = sqlsrv_connect(_SERVER, $connectioninfo) or die(sqlsrv_errors());
	}

	// ทำหน้าที่ Query ข้อมูลและคืนค่า Result เป็นในตัวแปร $Result
	public function Query($SQLCommand) {
		$this->Result = sqlsrv_query($this->connection, $SQLCommand) or die(sqlsrv_errors());
	}

	// ทำหน้าที่ Fetch ข้อมูลที่ได้จากการ Query ($Result) เก็บในตัวแปร $DataArray
	public function FetchData() {
		unset($this->DataArray);	// Cleard Array

		if( $this->Result === false)
			{
     			echo "Error in query preparation/execution.\n";
     			die( print_r( sqlsrv_errors(), true));
		} else {
			while ($Data = sqlsrv_fetch_Array($this->Result)) {
				$this->DataArray[] = $Data;
			}
		}

		// Return ข้อมูลที่ได้จากการ fetch data
		return (isset($this->DataArray)?$this->DataArray:NULL);
	}

	// ทำหน้าที่ Return จำนวนแถวทั้งหมดที่ได้จากการ Fetch ข้อมูลแล้ว
	public function RowCount() {
		return count($this->DataArray);
	}

	//* fn ที่สั่งทำ transaction sql
	public function transaction(){
		if ( sqlsrv_begin_transaction( $this->connection ) === false )
		{
		    echo "Could not begin transaction.\n";
		    die( print_r( sqlsrv_errors(), true ));
		}
	}

	//* fn : ยืนยันคำสั่งของ sql หลังจากที่ทำ transaction
	public function commit(){
		sqlsrv_commit( $this->connection );
		return "Transaction was committed.";
	}

	//* fn : ยกเลิกคำสั่งของ sql เมื่อ transaction เกิด error
	public function rollback(){
		sqlsrv_rollback( $this->connection );
		return "Transaction was rolled back.";
	}
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// * Require library PHPMailer
require 'PHPMailer/6.2.0/Exception.php';
require 'PHPMailer/6.2.0/PHPMailer.php';
require 'PHPMailer/6.2.0/SMTP.php';
$mDBConn = new CSQL;
$server = '172.22.64.14';
$database = 'CAPROD';
$mDBConn->connect($server , $database);
date_default_timezone_set("Asia/Bangkok");

$mail = new PHPMailer(true);
$mail->CharSet = "utf-8";
// * ตั้งค่าการส่งอีเมล์ โดยใช้ SMTP ของ โฮสต์
$mail->IsSMTP();
$mail->IsHTML(true);
$mail->Mailer = "smtp";
// * To address and name
// * SMTP Mail Server
$mail->Host = '10.10.10.3';
// * หมายเลข Port สำหรับส่งอีเมล์
$mail->Port = '25';
$mail->setFrom("CA_Linecall@aoth.in.th",'Line Call CA');
$mail->addAddress('j-natdanai@alpine-asia.com');
$mail->addAddress('p-arjari@alpine-asia.com');
$mail->addAddress('s-mongkol@alpine-asia.com');
$mail->addAddress('k-boonruang@alpine-asia.com');
$mail->addAddress('s-ratchaporn@alpine-asia.com');
$mail->addAddress('p-chaiwat@alpine-asia.com');
$mail->addAddress('l-morrakod@alpine-asia.com');
$mail->addCC('s-panisa@alpine-asia.com');
$mail->addCC('k-supawadee@alpine-asia.com');
$mail->addCC('s-suchittra@alpine-asia.com');
$mail->addCC('n-apichat@alpine-asia.com');
$mail->addCC('v-sutthanon@alpine-asia.com');
$mail->addCC('p-pitchakorn@alpine-asia.com');
$mail->addCC('h-rattapol@alpine-asia.com');
$mail->addCC('j-chanakarn@alpine-asia.com');
$mail->addCC('c-pornthip@alpine-asia.com');
$mail->addCC('k-uraiwan@alpine-asia.com');

// $mail->addAddress('fareeda@aoth.in.th');
// $mail->addAddress('somjeen@aoth.in.th');


$data_alert = "SELECT
                TSKH_MCLN,
                TSKH_WONO,
                TWON_MDLCD,
                TWON_WONQT,
                TLSLOG_TTLMIN,
                TLSLOG_DETAIL,
                TLSLOG_TSKNO,
                TLSLOG_LSNO,
                TLSLOG_FTIME,
                TLSLOG_TTIME,
                TLSLOG_TSKLN,
                TLSLOG_ISSDT,
                TLSLOG_SNDM FROM TSKH_TBL
    INNER JOIN TLSLOG_TBL ON TSKH_TBL.TSKH_TSKNO = TLSLOG_TBL.TLSLOG_TSKNO
    INNER JOIN TWON_TBL ON TSKH_TBL.TSKH_WONO = TWON_TBL.TWON_WONO
    WHERE TLSLOG_TBL.TLSLOG_LSNO = 'NG001'
    AND TLSLOG_TBL.TLSLOG_TTLMIN > 10
    AND TLSLOG_TBL.TLSLOG_ISSDT > '2024-11-14'
    AND TLSLOG_TBL.TLSLOG_SNDM IS NULL";
$mDBConn->Query($data_alert);
$data_mail = $mDBConn->FetchData();
print($data_mail[0]['TLSLOG_SNDM']);
print('<br>');
print($data_mail[0]['TSKH_WONO']);
$stringDate = $data_mail[0]['TLSLOG_ISSDT']->format('d/m/Y');
//print('<br>');



if(!empty($data_mail)){
    for($i=0;$i<count($data_mail);$i++){
        $body = '';
        $body.= '<p style="font-size: 24px; font-weight: bold; color: #c1121f;">Notification of Line Call to CA - ラインコール通知 (CA宛)</p>';
        $body.= '<p style="font-size: 18px; font-weight: bold;">Date: '.$stringDate.'</p>';
        $body.= '<p style="font-size: 18px; font-weight: bold;">Details: <span style="color: red;">'.$data_mail[$i]['TLSLOG_DETAIL'].'</span></p>';
        $body.= '<table style="border-collapse: collapse; width: 100%;">';
        $body.= '<tr>';
        $body.= '<th style="border: 1px solid black; padding: 8px; background-color: #f5cac3;">Line PROD.</th>';
        $body.= '<th style="border: 1px solid black; padding: 8px; background-color: #f5cac3;">Work Order No.</th>';
        $body.= '<th style="border: 1px solid black; padding: 8px; background-color: #f5cac3;">Model Code</th>';
        $body.= '<th style="border: 1px solid black; padding: 8px; background-color: #f5cac3;">Times to Line Call</th>';
        $body.= '<th style="border: 1px solid black; padding: 8px; background-color: #f5cac3;">Times alert (Minutes)</th>';
        $body.= '</tr>';
        $body.= '<tr>';
        $body.= '<td style="border: 1px solid black; text-align: center; padding: 8px;">'.$data_mail[$i]['TSKH_MCLN'].'</td>';
        $body.= '<td style="border: 1px solid black; text-align: center; padding: 8px;">'.$data_mail[$i]['TSKH_WONO'].'</td>';
        $body.= '<td style="border: 1px solid black; text-align: center; padding: 8px;">'.$data_mail[$i]['TWON_MDLCD'].'</td>';
        $body.= '<td style="border: 1px solid black; text-align: center; padding: 8px;">'.$data_mail[$i]['TLSLOG_FTIME'].'</td>';
        $body.= '<td style="border: 1px solid black; text-align: center; padding: 8px;">'.$data_mail[$i]['TLSLOG_TTLMIN'].'</td>';
        $body.= '</tr>';
        $body.= '</table>';
        $body.= '<p style="margin-top: 10px: font-size: 16px; color: #003049;">Link:&nbsp;</p><a href="http://web-server/menu.php" style="margin-top: 10px: font-size: 16px;">http://web-server/menu.php</a>';
        //print($body);
        $mail->Subject = 'Alert Line Call of CA';
        $mail->Body = $body;
        $mail->send();

        $update_std_mail = "UPDATE TLSLOG_TBL SET TLSLOG_SNDM = 1
        WHERE  TLSLOG_TBL.TLSLOG_TSKNO = '".$data_mail[$i]['TLSLOG_TSKNO']."'
        AND TLSLOG_TBL.TLSLOG_TSKLN = '".$data_mail[$i]['TLSLOG_TSKLN']."'";
        $mDBConn->Query($update_std_mail);
    }
}

// if($data_mail[0]['TLSLOG_SNDM'] == null){
//     $body = '';
//     $body.= '<p style="font-size: 24px; font-weight: bold; color: #c1121f;">Notification of Line Call to CA - ラインコール通知 (CA宛)</p>';
//     $body.= '<p style="font-size: 18px; font-weight: bold;">Date: '.$stringDate.'</p>';
//     $body.= '<p style="font-size: 18px; font-weight: bold;">Details: <span style="color: red;">'.$data_mail[0]['TLSLOG_DETAIL'].'</span></p>';
//     $body.= '<table style="border-collapse: collapse; width: 100%;">';
//     $body.= '<tr>';
//     $body.= '<th style="border: 1px solid black; padding: 8px; background-color: #f5cac3;">Line PROD.</th>';
//     $body.= '<th style="border: 1px solid black; padding: 8px; background-color: #f5cac3;">Work Order No.</th>';
//     $body.= '<th style="border: 1px solid black; padding: 8px; background-color: #f5cac3;">Model Code</th>';
//     $body.= '<th style="border: 1px solid black; padding: 8px; background-color: #f5cac3;">Times to Line Call</th>';
//     $body.= '<th style="border: 1px solid black; padding: 8px; background-color: #f5cac3;">Times alert (Minutes)</th>';
//     $body.= '</tr>';
//     $body.= '<tr>';
//     $body.= '<td style="border: 1px solid black; text-align: center; padding: 8px;">'.$data_mail[0]['TSKH_MCLN'].'</td>';
//     $body.= '<td style="border: 1px solid black; text-align: center; padding: 8px;">'.$data_mail[0]['TSKH_WONO'].'</td>';
//     $body.= '<td style="border: 1px solid black; text-align: center; padding: 8px;">'.$data_mail[0]['TWON_MDLCD'].'</td>';
//     $body.= '<td style="border: 1px solid black; text-align: center; padding: 8px;">'.$data_mail[0]['TLSLOG_FTIME'].'</td>';
//     $body.= '<td style="border: 1px solid black; text-align: center; padding: 8px;">'.$data_mail[0]['TLSLOG_TTLMIN'].'</td>';
//     $body.= '</tr>';
//     $body.= '</table>';
//     //print($body);
//     $mail->Subject = 'Alert Line Call of CA';
//     $mail->Body = $body;
//     $mail->send();

//     $update_std_mail = "UPDATE TLSLOG_TBL SET TLSLOG_SNDM = 1  WHERE TLSLOG_TBL.TLSLOG_LSNO = 'NG001'
//     AND TLSLOG_TBL.TLSLOG_TTLMIN > 10 ";
//     $mDBConn->Query($update_std_mail);
// }

// if($data_mail[0]['TLSLOG_SNDM'] == null){
//     $mail->send();
// }



?>
