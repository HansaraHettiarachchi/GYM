<?php
// include "connection.php";

$rs = Database::search("SELECT * FROM `members`; ");
$rs_num = $rs->num_rows;

for ($i = 0; $i < $rs_num; $i++) {

   $rs_data = $rs->fetch_assoc();
   $rs1 = Database::search("SELECT * FROM `memberpaymenthistory` WHERE `members_id` = '" . $rs_data['id'] . "' ORDER BY `DAT` DESC LIMIT 1;  ");
   $rs_num1 = $rs1->num_rows;

   if ($rs_num1 == 1 && $rs_data['status_id'] == 1) {
      $rs_data1 = $rs1->fetch_assoc();
      $date = $rs_data1['DAT'];

      if ($rs_data['membership_m_id'] === '1' || $rs_data['membership_m_id'] === '4' || $rs_data['membership_m_id'] === "10" || $rs_data['membership_m_id'] === "9") {
         $nPaymentD = date('Y-m-d', strtotime($date . "+1 months +6 days"));
      } elseif ($rs_data['membership_m_id'] === "2" || $rs_data['membership_m_id'] === "5") {
         $nPaymentD = date('Y-m-d', strtotime($date . "+6 months +6 days"));
      } elseif ($rs_data['membership_m_id'] === "3" || $rs_data['membership_m_id'] === "6") {
         $nPaymentD = date('Y-m-d', strtotime($date . "+12 months +6 days"));
      } elseif ($rs_data['membership_m_id'] === "7" || $rs_data['membership_m_id'] === "8") {
         $nPaymentD = date('Y-m-d', strtotime($date . "+4 months +6 days"));
      }

      $d13 = new DateTime();
      $tz13 = new DateTimeZone('Asia/Colombo');
      $d13->setTimezone($tz13);
      $cDate = $d13->format('Y-m-d');
      $cDate1 = $d13->format('Y-m-d H:i:s');

      if ($nPaymentD < $cDate) {

         $q13 = "UPDATE `members` SET `status_id`= '2' WHERE `id` = ? ; ";
         $q13_type = "i";
         Database::iudPrepared($q13, $q13_type, $rs_data['id']);

         $q14 = "INSERT INTO `disabledmrecode` (`dMR_m_id`,`d_date`,`dMR_m_name`) VALUES (?,?,?);";
         $q14_type = "iss";

         Database::iudPrepared($q14 ,$q14_type ,$rs_data['id'],$cDate1,$rs_data['m_name']);
      }
   }
}
