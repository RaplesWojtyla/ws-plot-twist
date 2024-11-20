<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Dosen</title>
</head>
<body>
    <?php include 'func.php' ?>

    <?php
    $query= '
      SELECT ?nama_dosen ?nip ?nama_matkul WHERE{
        ?dosen rdf:type university:Dosen.
        ?dosen university:nama_dosen ?nama_dosen.
        ?dosen university:nip ?nip.
        ?dosen university:Mengampu ?nama_matkul.
        ?matkul rdf:type university:Matkul_Wajib.
        ?matkul university:nama_matkul ?nama_matkul.
      } ORDER BY ?nama_dosen 
       ';
       try{
        $result = $sparql_jena->query($query);
  
        if(count(value: $result) == 0){
          echo "Tidak ada data dosen yang ditemukan.";
        }
        else{
          echo "<table class= 'table'";
          echo "<thead>
                <tr>
                  <th scope ='col' >Nama Dosen </th>
                  <th scope = 'col'>NIP</th>
                  <th scope = 'col'>Nama Matkul</th>
                </tr>
               </thead>";
          echo "<tbody>";
        }
        foreach ($result as $row) {
          echo "<tr>";
          echo "<td>" . $row->nama_dosen . "</td>";
          echo "<td>" . $row->nip . "</td>";
          echo "<td>" . $row->nama_matkul . "</td>";
          echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
      } catch (Exception $e){
        echo "Terjadi Kesalahan saat menjalankan query: " .$e->getMessage();
      }
    ?>  
  
    
 
</body>
</html>