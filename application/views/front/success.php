<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/front/') ?>css/bootstrap.min.css" />

  <!-- CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/front/') ?>css/success.css" />
  <link rel="icon" href="<?= base_url() ?>assets/images/favicon-32x32.png" type="image/png" />


  <title>Success</title>
</head>

<body>
  <section>
    <div class="container">
      <div class="row box-success">
        <div class="col-md-12">
          <h5>BOOKING BERHASIL DENGAN TRANSFER BANK</h5>
          <p>Transfer sebelum tanggal <?= $book->batas_waktu_pembayaran_dp ?></p>
          <div class="row justify-content-center">
            <div class="col-md-10 box-pay">
              <p>Jumlah yang harus di bayar</p>
              <p style="font-size:14pt;font-weight:bold"><?= mata_uang_rp($book->total_dp + $book->nominal_unik) ?></p>
              <div class="row justify-content-center">
                <div class="col-md-6 box-note">
                  <p>
                    Mohon Transfer sesuai jumlah yang tertera <br />
                    (Termasuk 3 digit terakhir)
                  </p>
                </div>
              </div>
            </div>
          </div>
          <p style="margin-top: 50px;"><span>Untuk informasi pembayaran silahkan klik link di bawah ini untuk mengirim pesan melalui WA</span></p>
          <div class="row justify-content-center mb-3 info">
            <div class="col-md-4">
              <a target_="_blank" href="https://wa.me/c/628117444949" style="color:#06d755;text-decoration:none">Kirim Pesan</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
</body>

</html>