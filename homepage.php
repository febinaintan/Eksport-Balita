<?php
session_start();
include("koneksi.php");

if(!isset($_SESSION['email'])){
    header("Location: regist.php"); // Mengarahkan kembali ke halaman login jika belum login
    exit();
}

$email = $_SESSION['email'];
$query = mysqli_query($conn, "SELECT * FROM register WHERE email='$email'");
$row = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksport Balita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 20px;
            background-image: url("img/image.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        h3 {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #e0e0e0;
        }

        .message {
            text-align: center;
            font-weight: bold;
            color: green;
            margin-bottom: 20px;
        }

        .form-container {
            margin-bottom: 20px;
        }

        .form-container input[type="text"], .form-container input[type="submit"] {
            padding: 10px;
            margin: 5px 0;
        }

        .form-container input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .action-buttons a {
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }

        .action-buttons a.delete {
            background-color: red;
        }
    </style>
</head>
<body>

<h3>Eksport Balita</h3>

<div class="form-container">
    <form action="homepage.php" method="post">
        <input type="text" name="kecamatan" placeholder="Kecamatan" required>
        <input type="text" name="puskesmas" placeholder="Puskesmas" required>
        <input type="text" name="desa_kelurahan" placeholder="Desa/Kelurahan" required>
        <input type="text" name="sangat_pendek" placeholder="Sangat Pendek" required>
        <input type="text" name="pendek" placeholder="Pendek" required>
        <input type="text" name="normal" placeholder="Normal" required>
        <input type="text" name="tinggi" placeholder="Tinggi" required>
        <input type="submit" name="submit" value="Tambah Data">
    </form>
</div>

<?php
include "koneksi.php";

// Create: Menambah data baru
if (isset($_POST['submit'])) {
    $kecamatan = $_POST['kecamatan'];
    $puskesmas = $_POST['puskesmas'];
    $desa_kelurahan = $_POST['desa_kelurahan'];
    $sangat_pendek = $_POST['sangat_pendek'];
    $pendek = $_POST['pendek'];
    $normal = $_POST['normal'];
    $tinggi = $_POST['tinggi'];

    $query = "INSERT INTO data (KECAMATAN, PUSKESMAS, `DESA/KELURAHAN`, `Sangat Pendek`, Pendek, Normal, Tinggi) 
              VALUES ('$kecamatan', '$puskesmas', '$desa_kelurahan', '$sangat_pendek', '$pendek', '$normal', '$tinggi')";
    mysqli_query($conn, $query);

    echo "<div class='message'>Data berhasil ditambahkan</div>";
}

// Menghapus data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM data WHERE NO='$id'");
    echo "<div class='message'>Data berhasil dihapus</div>";
    echo "<meta http-equiv='refresh' content='2;URL=homepage.php'>";
}

// Mengedit data (menampilkan form)
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM data WHERE NO='$id'");

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        echo "
        <div class='form-container'>
            <form action='homepage.php' method='post'>
                <input type='hidden' name='id' value='{$data['NO']}'>
                <input type='text' name='kecamatan' value='{$data['KECAMATAN']}' required>
                <input type='text' name='puskesmas' value='{$data['PUSKESMAS']}' required>
                <input type='text' name='desa_kelurahan' value='{$data['DESA/KELURAHAN']}' required>
                <input type='text' name='sangat_pendek' value='{$data['Sangat Pendek']}' required>
                <input type='text' name='pendek' value='{$data['Pendek']}' required>
                <input type='text' name='normal' value='{$data['Normal']}' required>
                <input type='text' name='tinggi' value='{$data['Tinggi']}' required>
                <input type='submit' name='update' value='Update Data'>
            </form>
        </div>";
    } else {
        echo "<div class='message'>Data tidak ditemukan atau terjadi kesalahan pada kueri.</div>";
    }
}

// Memperbarui data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $kecamatan = $_POST['kecamatan'];
    $puskesmas = $_POST['puskesmas'];
    $desa_kelurahan = $_POST['desa_kelurahan'];
    $sangat_pendek = $_POST['sangat_pendek'];
    $pendek = $_POST['pendek'];
    $normal = $_POST['normal'];
    $tinggi = $_POST['tinggi'];

    $query = "UPDATE data SET 
                KECAMATAN='$kecamatan', 
                PUSKESMAS='$puskesmas', 
                `DESA/KELURAHAN`='$desa_kelurahan', 
                `Sangat Pendek`='$sangat_pendek', 
                Pendek='$pendek', 
                Normal='$normal', 
                Tinggi='$tinggi' 
              WHERE NO='$id'";
    mysqli_query($conn, $query);

    echo "<div class='message'>Data berhasil diperbarui</div>";
}
?>

<table>
    <tr>
        <th>NO</th>
        <th>KECAMATAN</th>
        <th>PUSKESMAS</th>
        <th>DESA/KELURAHAN</th>
        <th>Sangat Pendek</th>
        <th>Pendek</th>
        <th>Normal</th>
        <th>Tinggi</th>
        <th>Aksi</th>
    </tr>

<?php
$ambildata = mysqli_query($conn, "SELECT * FROM data ORDER BY KECAMATAN ASC");
$no = 1;

while ($tampil = mysqli_fetch_array($ambildata)) {
    echo "
    <tr>
        <td>{$no}</td>
        <td>{$tampil['KECAMATAN']}</td>
        <td>{$tampil['PUSKESMAS']}</td>
        <td>{$tampil['DESA/KELURAHAN']}</td>
        <td>{$tampil['Sangat Pendek']}</td>
        <td>{$tampil['Pendek']}</td>
        <td>{$tampil['Normal']}</td>
        <td>{$tampil['Tinggi']}</td>
        <td class='action-buttons'>
            <a href='homepage.php?edit={$tampil['NO']}'>Edit</a>
            <a href='homepage.php?delete={$tampil['NO']}' class='delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
        </td>
    </tr>";
    $no++;
}
?>

</table>

</body>
</html>
