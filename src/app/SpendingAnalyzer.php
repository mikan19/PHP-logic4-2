<?php
namespace App;
use PDO;

class SpendingAnalyzer {
  private $pdo;
  
  public function __construct($dbUserName, $dbPassword) {
    $this->pdo = new PDO("mysql:host=mysql; dbname=tq_quest; charset=utf8", $dbUserName, $dbPassword);
  }
  
  public function analyze() {
    $sql = "SELECT * FROM spendings ORDER BY amount DESC";
    $statement = $this->pdo->prepare($sql);
    $statement->execute();
    $spendings = $statement->fetchAll(PDO::FETCH_ASSOC);

    $spendingByMonth = array();
    foreach($spendings as $spending) {
      $date = explode('-', $spending["accrual_date"]);
      $month = abs($date[1]);
      $day = abs($date[2]);

      if(strpos($day, "5") !== false) {
        $spending["amount"] -= 100;
      }

      if(!isset($spendingByMonth[$month])) {
        $spendingByMonth[$month] = 0;
      }
      $spendingByMonth[$month] += $spending["amount"];
    }

    arsort($spendingByMonth);

    foreach($spendingByMonth as $month => $spending) {
      echo $month . "月の支出の合計: " . $spending . "\n";
      echo "<br/>";
    }
  }
}



?>
