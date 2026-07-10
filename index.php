<?php 
// 1. Hubungkan ke database menggunakan file config Anda
include_once("config.php"); 

// 2. PROSES SIMPAN DATA (Akan berjalan saat tombol "Simpan Data Alat" diklik)
if (isset($_POST['Submit'])) {
    $nama_alat = $_POST['nama_alat'];
    $tahun     = $_POST['tahun'];
    $merek     = $_POST['merek'];
    $lokasi    = $_POST['lokasi'];

    // Query untuk memasukkan data ke tabel alat
    $query = "INSERT INTO alat (nama_alat, tahun, merek, lokasi) VALUES ('$nama_alat', '$tahun', '$merek', '$lokasi')";
    $result = mysqli_query($mysqli, $query);

    if ($result) {
        // Jika sukses, reload halaman agar data baru langsung muncul di tabel bawah
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan data: " . mysqli_error($mysqli) . "');</script>";
    }
}

// 3. AMBIL DATA UTK TABEL
$result = mysqli_query($mysqli, "SELECT * FROM alat ORDER BY id DESC"); 
?> 
 
<!DOCTYPE html> 
<html lang="id"> 
<head> 
    <meta charset="UTF-8">
    <title>Sim Rs - Data Alat</title> 
    <style> 
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #fafafa; }
        
        /* Style Form Input */
        .form-container { 
            background: white; 
            padding: 20px; 
            border: 1px solid #ccc; 
            width: 50%; 
            margin-bottom: 30px; 
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .form-title { margin-top: 0; color: #333; border-bottom: 2px solid orange; padding-bottom: 5px; }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 14px; }
        .form-group input { width: 95%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-simpan { padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-simpan:hover { background-color: #218838; }

        /* Style Tabel Data */
        .header { background-color: orange; color: white; } 
        table { width: 80%; border-collapse: collapse; margin-top: 10px; background: white; } 
        th, td { border: 1px solid black; padding: 8px; text-align: left; } 
        .table-title { color: #333; }
    </style> 
</head> 
<body> 

    <div class="form-container">
        <h3 class="form-title">Tambah Data Alat Baru</h3>
        <form action="" method="post">
            <div class="form-group">
                <label>Nama Alat</label>
                <input type="text" name="nama_alat" required placeholder="Masukkan nama alat...">
            </div>
            <div class="form-group">
                <label>Tahun</label>
                <input type="number" name="tahun" required placeholder="Contoh: 2026">
            </div>
            <div class="form-group">
                <label>Merek</label>
                <input type="text" name="merek" required placeholder="Masukkan merek alat...">
            </div>
            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="lokasi" required placeholder="Masukkan lokasi penempatan...">
            </div>
            <button type="submit" name="Submit" class="btn-simpan">Simpan Data Alat</button>
        </form>
    </div>

    <h2 class="table-title">Daftar Data Alat</h2>
    <table> 
        <tr class="header"> 
            <th>Nama Alat</th>
            <th>Tahun</th>
            <th>Merek</th>
            <th>Lokasi</th>
            <th>Aksi</th> 
        </tr> 
        <?php 
        // Menampilkan data hasil query
        while($user_data = mysqli_fetch_array($result)) { 
            echo "<tr>"; 
            echo "<td>".$user_data['nama_alat']."</td>"; 
            echo "<td>".$user_data['tahun']."</td>"; 
            echo "<td>".$user_data['merek']."</td>"; 
            echo "<td>".$user_data['lokasi']."</td>"; 
            echo "<td>
                    <a href='edit.php?id=$user_data[id]'>Edit</a> | 
                    <a href='delete.php?id=$user_data[id]' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Delete</a>
                  </td>";
            echo "</tr>"; 
        } 
        ?> 
    </table> 

</body> 
</html>