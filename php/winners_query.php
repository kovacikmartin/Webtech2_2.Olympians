<?php

$sql = 
"SELECT
     p.id
    ,p.name
    ,p.surname
    ,s.discipline
    ,oh.year
    ,oh.city
    ,oh.country
    ,oh.type
FROM
    t_person p
INNER JOIN t_standings s ON p.id = s.person_id
INNER JOIN t_oh       oh ON s.oh_id = oh.id
WHERE s.placement = 1";

$stmnt = $conn->query($sql);

$winnersResult = $stmnt->fetchAll(PDO::FETCH_ASSOC);

$winnersCols = array_keys($winnersResult[0]);
?>

<table id="winnersTable">
    <thead>
      <tr>
        <?php
          foreach($winnersCols as $colName){
            if($colName !== "id" && $colName !== "surname")
              echo "<th>" . ucfirst($colName) . "</th>";
          }
        ?>
      </tr>
    </thead>

    <tbody>
      <?php
        foreach($winnersResult as $row){
          echo "<tr>";

          echo "<td><a href='php/person_info.php?id=" . $row["id"] . "'>" . $row["name"] . " " . $row["surname"] . "</a></td>";

          foreach($winnersCols as $index => $colName){      // $index is column index
            if($index > 2)
              echo "<td>".$row[$colName] . "</td>";
          }

          echo "</tr>";
        }
      ?>
    </tbody>
  </table>