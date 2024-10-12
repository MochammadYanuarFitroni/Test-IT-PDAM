<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <a href="/" class="btn btn-primary">Kembali ke pegawai</a>

    <h2 class="mb-4">Daftar Nama Pegawai</h2>

    <!-- Tabel Pegawai -->
    <table class="table table-bordered" id="ruanganTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama / Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data pegawai akan diisi di sini -->
        </tbody>
    </table>

    <!-- Form Input dan Edit Pegawai -->
    <h4 class="mt-5">Input dan Edit Nama Pegawai</h4>
    <form id="ruanganForm">
        <input type="hidden" id="id_ruangan" name="id_ruangan">
        <div class="form-group">
            <label for="keterangan">Nama</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="masukkan nama/keterangan dari ruangan" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
</body>

<script>
    const apiUrl = 'http://localhost:8000/api/ruangan' //base API

    // Load data pegawai dan ruangan saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        fetchRuangans()
    })

    // tambah/edit data ruangan
    document.getElementById('ruanganForm').addEventListener('submit', function(e) {
        e.preventDefault()
        const idRuangan = document.getElementById('id_ruangan').value
        const keterangan = document.getElementById('keterangan').value

        //deteksi apakah melakukan tambah data/edit data
        let method
        let url
        if (idRuangan) {
            method = 'PUT'
            url = `${apiUrl}/${idRuangan}`
        } else {
            method = 'POST'
            url = apiUrl
        }


        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ keterangan: keterangan })
        })
        .then(response => response.json())
        .then(data => {
            if(method === 'POST'){
                alert('Data ruangan berhasil ditambahkan')
            }
            else{
                alert('Data ruangan berhasil diperbarui')
            }
            document.getElementById('ruanganForm').reset()
            document.getElementById('id_ruangan').value = ''
            fetchRuangans()
        })
        .catch(error => console.error('Error saving data:', error))
    })

    //Get all data ruangan
    function fetchRuangans() {
        fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            if(data){
                // alert('Data ruangan ditemukan')
                const ruanganTableBody = document.querySelector('#ruanganTable tbody')
                ruanganTableBody.innerHTML = ''
                data.forEach((ruangan, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${ruangan.keterangan}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editRuangan(${ruangan.id_ruangan})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteRuangan(${ruangan.id_ruangan})">Hapus</button>
                            </td>
                        </tr>
                    `
                    ruanganTableBody.innerHTML += row
                })
            }
            // else{
            //     alert('data ruangan tidak ditemukan')
            // }
        })
        .catch(error => console.error('Error fetching data:', error))
    }

    // Edit data ruangan
    function editRuangan(id) {
        fetch(`${apiUrl}/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('id_ruangan').value = data.id_ruangan
            document.getElementById('keterangan').value = data.keterangan
        })
        .catch(error => console.error('Error fetching ruangan:', error))
    }

    // Delete data ruangan
    function deleteRuangan(id) {
        if (confirm('Apakah Anda yakin ingin menghapus ruangan ini?')) {
            fetch(`${apiUrl}/${id}`, {
                method: 'DELETE',
            })
            .then(response => {
                if (response.ok) {
                    alert('Data ruangan berhasil dihapus')
                    fetchRuangans()
                } else {
                    alert('Gagal menghapus data ruangan')
                }
            })
            .catch(error => console.error('Error deleting ruangan:', error))
        }
    }
</script>
</html>