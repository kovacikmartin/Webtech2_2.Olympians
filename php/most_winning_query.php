<?php

$sql = 
"SELECT
     p.id
    ,p.name
    ,p.surname
    ,COUNT(s.placement) AS 'Gold medals'
FROM
    t_person p
INNER JOIN t_standings s ON p.id = s.person_id
WHERE s.placement = 1
GROUP BY p.id, p.name, p.surname
ORDER BY COUNT(s.placement) DESC
LIMIT 10";

$stmnt = $conn->query($sql);

$mostWinningResult = $stmnt->fetchAll(PDO::FETCH_ASSOC);

$mostWinningCols = array_keys($mostWinningResult[0]);
?>

<table id="mostWinningTable">
    <thead>
      <tr>
        <?php
          foreach($mostWinningCols as $colName){
            if($colName !== "id" && $colName !== "surname")
              echo "<th>" . ucfirst($colName) . "</th>";
          }
          echo "<th>Options</th>";
        ?>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach($mostWinningResult as $row){
          echo "<tr>";
          
          echo "<td><a href='php/person_info.php?id=" . $row["id"] . "'>" . $row["name"] . " " . $row["surname"] . "</a></td>";

          foreach($mostWinningCols as $index => $colName){      // $index is column index
            if($index > 2)
              echo "<td>".$row[$colName] . "</td>";
          }
          echo "<td><a href='php/edit_person.php?id=" . $row["id"] . "'>Edit </a>/
                    <a href='php/delete_person.php?id=" . $row["id"] . "'>Delete</a>
                </td>";
          echo "</tr>";
        }
      ?>
    </tbody>
</table>