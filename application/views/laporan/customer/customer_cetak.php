<?php
$border = '';
if ($params['tipe'] == 'xls') {
  header("Content-type: application/octet-stream");
  $file_name = $file_pdf . '.xls';
  header("Content-Disposition: attachment; filename=$file_name.xls");
  header("Pragma: no-cache");
  header("Expires: 0");
  $border = "border=1";
}
// send_json($details);
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title><?= $title ?></title>
  <style type="text/css">
    #outtable {
      padding: 20px;
      border: 1px solid #e3e3e3;
      width: 600px;
      border-radius: 5px;
    }

    .short {
      width: 50px;
    }

    .normal {
      width: 150px;
    }

    .table {
      border-collapse: collapse;
      font-family: arial;
      color: #5E5B5C;
      width: 100%
    }

    .table thead th {
      text-align: left;
      padding: 10px;
    }

    .table tbody td {
      border-top: 1px solid #e3e3e3;
      padding: 10px;
    }

    .table tbody tr:nth-child(even) {
      background: #F6F5FA;
    }

    .table tbody tr:hover {
      background: #EAE9F5
    }

    .header td {
      font-weight: 600;
    }
  </style>
</head>

<body>
  <div style='text-align:center; font-size: 22px;margin-bottom:20px'>Laporan Data Customer</div>

  <table class='table' <?= $border ?>>
    <tr class='header'>
      <td width='5%'>No.</td>
      <td>Nama Lengkap</td>
      <td>No. WA</td>
      <td>Plat Nomor</td>
      <td>Merk Mobil</td>
      <td>Jenis Mobil</td>
    </tr>
    <?php $no = 1;
    foreach ($details as $key => $dtl) { ?>
      <tr>
        <td><?= $no ?>.</td>
        <td><?= $dtl->nama_lengkap ?></td>
        <td><?= $dtl->no_wa ?></td>
        <td><?= $dtl->no_polisi ?></td>
        <td><?= $dtl->merk_mobil ?></td>
        <td><?= $dtl->jenis_mobil ?></td>
      </tr>
    <?php $no++;
    } ?>
  </table>

</body>

</html>