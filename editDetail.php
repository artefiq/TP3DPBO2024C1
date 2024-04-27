<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Divisi.php');
include('classes/Jabatan.php');
include('classes/Pengurus.php');
include('classes/Template.php');

$pengurus = new Pengurus($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$pengurus->open();

$divisi = new Divisi($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$divisi->open();

$jabatan = new Jabatan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$jabatan->open();

$id = isset($_GET['id']) ? $_GET['id'] : null;

$data = null;

if (is_numeric($id)) {
    $pengurus->getPengurusById($id);
    $row = $pengurus->getResult();

    $divisi->getDivisi();
    $dataDivisi = $divisi->getResult();

    $jabatan->getJabatan();
    $dataJabatan = $jabatan->getResult();

    var_dump($dataDivisi);

    if ($row) {
        // Append form HTML to $data
        $data .= '<form action="#" method="POST">
        <div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['pengurus_nama'] . '</h3>
        </div>
        <div class="card-body text-end">
        <div class="row mb-5">
        <div class="col-3">
        <div class="row justify-content-center">
        <img src="assets/images/' . $row['pengurus_foto'] . '" class="img-thumbnail" alt="' . $row['pengurus_foto'] . '" width="60">
        </div>
        </div>
        <div class="col-9">
        <div class="card px-3">
        <table border="0" class="text-start">
        <tr>
        <td>Nama</td>
        <td>:</td>
        <td><input type="text" name="pengurus_nama" value="' . $row['pengurus_nama'] . '"></td>
        </tr>
        <tr>
        <td>NIM</td>
        <td>:</td>
        <td><input type="text" name="pengurus_nim" value="' . $row['pengurus_nim'] . '"></td>
        </tr>
        <tr>
        <td>Semester</td>
        <td>:</td>
        <td><input type="text" name="pengurus_semester" value="' . $row['pengurus_semester'] . '"></td>
        </tr>
        <tr>
        <td>Divisi</td>
        <td>:</td>
        <td>
        <select name="divisi_id">';

        // foreach ($dataDivisi as $value) {
        //     $data .= '<option value="' . $value['divisi_id'] . '"';
        //     if ($value['divisi_id'] == $row['divisi_id']) {
        //         $data .= ' selected';
        //     }
        //     $data .= '>' . $value['divisi_nama'] . '</option>';
        // }

        $data .= '</select>
        </td>
        </tr>
        <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td>
        <select name="jabatan_id">';

        // foreach ($dataJabatan as $value) {
        //     $data .= '<option value="' . $value['jabatan_id'] . '"';
        //     if ($value['jabatan_id'] == $row['jabatan_id']) {
        //         $data .= ' selected';
        //     }
        //     $data .= '>' . $value['jabatan_nama'] . '</option>';
        // }

        $data .= '</select>
        </td>
        </tr>
        </table>
        </div>
        </div>
        </div>
        <div class="card-footer text-end">
        <input type="hidden" name="id" value="' . $id . '">
        <button type="submit" name="accept" class="btn btn-success text-white">Accept</button>
        <a href="#" class="btn btn-danger">Cancel</a>
        </div>
        </div>
        </form>';
    } else {
        $data = '<div class="alert alert-danger" role="alert">Data not found!</div>';
    }
} else {
    $data = '<div class="alert alert-danger" role="alert">Invalid ID!</div>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present
    if (isset($_POST['id'], $_POST['pengurus_nama'], $_POST['pengurus_nim'], $_POST['pengurus_semester'], $_POST['divisi_id'], $_POST['jabatan_id'])) {
        $id = $_POST['id'];
        $nama = $_POST['pengurus_nama'];
        $nim = $_POST['pengurus_nim'];
        $semester = $_POST['pengurus_semester'];
        $divisi_id = $_POST['divisi_id'];
        $jabatan_id = $_POST['jabatan_id'];

        // Update data
        if ($id > 0) {
            if ($pengurus->updateData($id, $nama, $nim, $semester, $divisi_id, $jabatan_id) > 0) {
                echo "<script>
                    alert('Data berhasil diupdate');
                    document.location.href = 'detail.php?id=$id';
                </script>";
            } else {
                echo "<script>
                    alert('Data gagal diupdate!');
                    document.location.href = 'editDetail.php?id=$id'; // Redirect to edit page to fix errors
                </script>";
            }
        }
    } else {
        echo "<script>
            alert('Semua field harus diisi');
            document.location.href = 'editDetail.php?id=$id'; // Redirect to edit page to fix errors
        </script>";
    }
}

$pengurus->close();
$divisi->close();
$jabatan->close();

$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_PENGURUS', $data);
$detail->write();
