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
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan data: " . mysqli_error($mysqli) . "');</script>";
    }
}

// 3. LOGIKA PENCARIAN & AMBIL DATA UTK TABEL
if (isset($_GET['cari']) && $_GET['cari'] != '') {
    $keyword = mysqli_real_escape_string($mysqli, $_GET['cari']);
    $query_tampil = "SELECT * FROM alat WHERE nama_alat LIKE '%$keyword%' OR merek LIKE '%$keyword%' OR lokasi LIKE '%$keyword%' ORDER BY id DESC";
} else {
    $query_tampil = "SELECT * FROM alat ORDER BY id DESC";
}

$result = mysqli_query($mysqli, $query_tampil);
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
        body { margin: 0; padding: 30px; background-color: #f2f7f4; color: #2d3748; }
        
        /* Layout Grid untuk Form & Tabel */
        .container { display: grid; grid-template-columns: 1fr 2fr; gap: 30px; max-width: 1400px; margin: 0 auto; }
        @media (max-width: 992px) { .container { grid-template-columns: 1fr; } }

        /* Card Wrapper Style */
        .card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 10px rgba(46, 117, 89, 0.05); border: 1px solid #e1ebe6; }
        
        /* Form Style */
        .form-title { margin-top: 0; margin-bottom: 20px; color: #2e7d32; font-size: 1.3rem; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 14px; color: #4a5568; }
        .form-group input { width: 100%; padding: 10px 12px; border: 1px solid #c8d6cf; border-radius: 5px; font-size: 14px; transition: border-color 0.15s; }
        .form-group input:focus { outline: none; border-color: #2e7d32; box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.15); }
        .btn-simpan { width: 100%; padding: 12px; background-color: #10b981; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 14px; transition: background 0.2s; }
        .btn-simpan:hover { background-color: #059669; }

        /* Style untuk Search Bar */
        .search-container { display: flex; gap: 10px; margin-bottom: 20px; align-items: center; }
        .search-input { flex: 1; padding: 10px 12px; border: 1px solid #c8d6cf; border-radius: 5px; font-size: 14px; }
        .search-input:focus { outline: none; border-color: #2e7d32; }
        .btn-cari { padding: 10px 20px; background-color: #2e7d32; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 14px; }
        .btn-cari:hover { background-color: #1b5e20; }
        .btn-reset { padding: 10px 15px; background-color: #718096; color: white; text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: bold; text-align: center; }
        .btn-reset:hover { background-color: #4a5568; }

        /* Table Style */
        .table-title { margin-top: 0; margin-bottom: 20px; color: #1b5e20; font-size: 1.5rem; }
        .table-responsive { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; }
        
        /* BARIS NAMA ALAT, TAHUN, DLL SUDAH BERWARNA HIJAU MEDIS DI SINI */
        th { background-color: #2e7d32; color: #ffffff; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; border-bottom: 2px solid #1b5e20; }
        th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #edf2f0; }
        tr:hover { background-color: #f7faf8; }
        
        /* Action Buttons Style */
        .btn-action { display: inline-block; padding: 5px 10px; text-decoration: none; font-size: 12px; font-weight: 600; border-radius: 4px; margin-right: 5px; }
        .btn-edit { background-color: #e0a914; color: #fff; }
        .btn-edit:hover { background-color: #c4920b; }
        .btn-delete { background-color: #e53e3e; color: #fff; }
        .btn-delete:hover { background-color: #c53030; }
        
        .text-empty { text-align: center; color: #718096; font-style: italic; }
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
            
            <form action="" method="get">
                <div class="search-container">
                    <input type="text" name="cari" class="search-input" placeholder="Cari berdasarkan nama alat, merek, atau lokasi..." value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
                    <button type="submit" class="btn-cari">Cari</button>
                    <?php if (isset($_GET['cari']) && $_GET['cari'] != ''): ?>
                        <a href="index.php" class="btn-reset">Reset</a>
                    <?php endif; ?>
                </div>
            </form>

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
                        if (mysqli_num_rows($result) > 0) {
                            while($user_data = mysqli_fetch_array($result)) { 
                                echo "<tr>"; 
                                echo "<td><strong style='color: #2e7d32;'>".$user_data['nama_alat']."</strong></td>"; 
                                echo "<td>".$user_data['tahun']."</td>"; 
                                echo "<td>".$user_data['merek']."</td>"; 
                                echo "<td>".$user_data['lokasi']."</td>"; 
                                echo "<td>
                                        <a href='edit.php?id=$user_data[id]' class='btn-action btn-edit'>Edit</a>
                                        <a href='delete.php?id=$user_data[id]' class='btn-action btn-delete' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Delete</a>
                                      </td>";
                                echo "</tr>"; 
                            } 
                        } else {
                            echo "<tr><td colspan='5' class='text-empty'>Data tidak ditemukan atau inventaris masih kosong.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>

    <footer style="text-align: center; margin-top: 40px; padding: 20px 0; color: #718096; font-size: 14px; border-top: 1px solid #e1ebe6; width: 100%;">
        Aplikasi dikembangkan oleh: <strong>Tegar Arif Cahyono 2202505072</strong>
    </footer>

</body> 
</html>