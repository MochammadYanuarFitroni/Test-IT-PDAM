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
    <h2 class="mb-4">Daftar Nama Pegawai</h2>

    <!-- Tabel Pegawai -->
    <table class="table table-bordered" id="pegawaiTable">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Tanggal Lahir</th>
                <th>Nama Ruangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data pegawai akan diisi di sini -->
        </tbody>
    </table>

    <a href="/ruangan" class="btn btn-primary mt-3">Master Ruangan</a>
    <!-- Form Input dan Edit Pegawai -->
    <h4>Input dan Edit Nama Pegawai</h4>
    <form id="pegawaiForm">
        <input type="hidden" id="nip" name="nip">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
        </div>
        <div class="form-group">
            <label for="tgl_lahir">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
        </div>
        <div class="form-group">
            <label for="id_ruangan">Nama Ruangan</label>
            <select class="form-control" id="id_ruangan" name="id_ruangan" required>
                <option value="">- Pilih data -</option>
                <!-- Data ruangan akan diisi di sini -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
    const baseURL = 'http://localhost:8000/api/pegawai' //base API

    // Load data pegawai dan ruangan saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        fetchPegawais()
        fetchRuangans()
    })

    // Get all data pegawai
    function fetchPegawais() {
        fetch(baseURL)
        .then(response => response.json())
        .then(result => {
            const tableBody = document.querySelector('#pegawaiTable tbody')
            tableBody.innerHTML = '' // Kosongkan tabel
            result.forEach(pegawai => {
                const row = document.createElement('tr')
                row.innerHTML = `
                    <td>${pegawai.nip}</td>
                    <td>${pegawai.nama}</td>
                    <td>${pegawai.alamat}</td>
                    <td>${pegawai.tgl_lahir}</td>
                    <td>${pegawai.ruangan.keterangan}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editPegawai(${pegawai.nip})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deletePegawai(${pegawai.nip})">Hapus</button>
                    </td>
                `
                tableBody.appendChild(row)
            })
        })
        .catch(error => console.error(error))
    }

    // Mengambil data ruangan
    function fetchRuangans() {
        fetch('http://localhost:8000/api/ruangan') // Ganti dengan URL API Ruangan Anda
        .then(response => response.json())
        .then(result => {
            const select = document.getElementById('id_ruangan')
            result.forEach(ruangan => {
                const option = document.createElement('option')
                option.value = ruangan.id_ruangan
                option.textContent = ruangan.keterangan
                select.appendChild(option)
            })
        })
        .catch(error => console.error(error))
    }

    // Tambah/edit data pegawai
    document.getElementById('pegawaiForm').addEventListener('submit', function(event) {
        event.preventDefault()
        const formData = new FormData(this)
        const nip = formData.get('nip')

        const data = {
            nama: formData.get('nama'),
            alamat: formData.get('alamat'),
            tgl_lahir: formData.get('tgl_lahir'),
            id_ruangan: formData.get('id_ruangan'),
        }

        if (nip) {
            //edit data pegawai
            fetch(`${baseURL}/${nip}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => {
                if (response.ok) {
                    alert('Pegawai berhasil diperbarui')
                    fetchPegawais()
                    this.reset() 
                } else {
                    alert('Gagal memperbarui pegawai')
                }
            })
            .catch(error => console.error(error))
        } else {
            // Tambah data pegawai
            fetch(baseURL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => {
                if (response.ok) {
                    alert('Pegawai berhasil ditambahkan')
                    fetchPegawais()
                    this.reset()
                } else {
                    alert('Gagal menambahkan pegawai')
                }
            })
            .catch(error => console.error(error))
        }
    })

    // Menampilkan data pegawai yang akan diedit
    function editPegawai(nip) {
        fetch(`${baseURL}/${nip}`)
        .then(response => response.json())
        .then(result => {
            document.getElementById('nip').value = result.nip
            document.getElementById('nama').value = result.nama
            document.getElementById('alamat').value = result.alamat
            document.getElementById('tgl_lahir').value = new Date(result.tgl_lahir).toISOString().split('T')[0]
            document.getElementById('id_ruangan').value = result.id_ruangan
        })
        .catch(error => console.error(error))
    }

    // Menghapus data pegawai
    function deletePegawai(nip) {
        if (confirm('Apakah Anda yakin ingin menghapus pegawai ini?')) {
            fetch(`${baseURL}/${nip}`, {
                method: 'DELETE',
            })
            .then(response => {
                if (response.ok) {
                    alert('Pegawai berhasil dihapus')
                    fetchPegawais()
                } else {
                    alert('Gagal menghapus pegawai')
                }
            })
            .catch(error => console.error(error))
        }
    }
</script>
</body>
</html>
