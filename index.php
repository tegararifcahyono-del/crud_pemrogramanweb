<?php 
// 1. Hubungkan ke database menggunakan file config Anda
include_once("config.php"); 

// 2. PROSES SIMPAN DATA
if (isset($_POST['Submit'])) {
    $nama_alat = $_POST['nama_alat'];
    $tahun     = $_POST['tahun'];
    $merek     = $_POST['merek'];
    $lokasi    = $_POST['lokasi'];

    $query = "INSERT INTO alat (nama_alat, tahun, merek, lokasi) VALUES ('$nama_alat', '$tahun', '$merek', '$lokasi')";
    $result = mysqli_query($mysqli, $query);

    if ($result) {
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sim Rs - Data Alat</title> 
    <style> 
        /* Reset & Base Style */
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { margin: 0; padding: 30px; background-color: #f4f6f9; color: #333; }
        
        /* Layout Grid untuk Form & Tabel */
        .container { display: grid; grid-template-columns: 1fr 2fr; gap: 30px; max-width: 1400px; margin: 0 auto; }
        @media (max-width: 992px) { .container { grid-template-columns: 1fr; } }

        /* Card Wrapper Style */
        .card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e3e6f0; }
        
        /* Form Style */
        .form-title { margin-top: 0; margin-bottom: 20px; color: #4e73df; font-size: 1.3rem; border-bottom: 2px solid #eaecf4; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 14px; color: #5a5c69; }
        .form-group input { width: 100%; padding: 10px 12px; border: 1px solid #d1d3e2; border-radius: 5px; font-size: 14px; transition: border-color 0.15s; }
        .form-group input:focus { outline: none; border-color: #4e73df; box-shadow: 0 0 0 0.2rem rgba(78,115,223,0.25); }
        .btn-simpan { width: 100%; padding: 12px; background-color: #1cc88a; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 14px; transition: background 0.2s; }
        .btn-simpan:hover { background-color: #17a673; }

        /* Table Style */
        .table-title { margin-top: 0; margin-bottom: 20px; color: #333; font-size: 1.5rem; }
        .table-responsive { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; }
        
        th { background-color: #f8f9fc; color: #4e73df; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; border-bottom: 2px solid #eaecf4; }
        th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #eaecf4; }
        tr:hover { background-color: #f8f9fc; }
        
        /* Action Buttons Style */
        .btn-action { display: inline-block; padding: 5px 10px; text-decoration: none; font-size: 12px; font-weight: 600; border-radius: 4px; margin-right: 5px; }
        .btn-edit { background-color: #f6c23e; color: #fff; }
        .btn-edit:hover { background-color: #dfa515; }
        .btn-delete { background-color: #e74a3b; color: #fff; }
        .btn-delete:hover { background-color: #be2617; }
    </style> 
</head> 
<body> 

    <div class="container">
        <div class="card">
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

        <div class="card">
            <h2 class="table-title">Daftar Data Alat</h2>
            <div class="table-responsive">
                <table> 
                    <thead>
                        <tr> 
                            <th>Nama Alat</th>
                            <th>Tahun</th>
                            <th>Merek</th>
                            <th>Lokasi</th>
                            <th>Aksi</th> 
                        </tr> 
                    </thead>
                    <tbody>
                        <?php 
                        while($user_data = mysqli_fetch_array($result)) { 
                            echo "<tr>"; 
                            echo "<td><strong>".$user_data['nama_alat']."</strong></td>"; 
                            echo "<td>".$user_data['tahun']."</td>"; 
                            echo "<td>".$user_data['merek']."</td>"; 
                            echo "<td>".$user_data['lokasi']."</td>"; 
                            echo "<td>
                                    <a href='edit.php?id=$user_data[id]' class='btn-action btn-edit'>Edit</a>
                                    <a href='delete.php?id=$user_data[id]' class='btn-action btn-delete' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Delete</a>
                                  </td>";
                            echo "</tr>"; 
                        } 
                        ?>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>

</body> 
</html>