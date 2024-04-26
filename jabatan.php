<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Jabatan.php');
include('classes/Template.php');

$jabatan = new Jabatan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$jabatan->open();
$jabatan->getJabatan();

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($jabatan->addJabatan($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'jabatan.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'jabatan.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Jabatan';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Jabatan</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'jabatan';

while ($div = $jabatan->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['jabatan_nama'] . '</td>
    <td style="font-size: 22px;">
        <a href="jabatan.php?id=' . $div['jabatan_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="jabatan.php?hapus=' . $div['jabatan_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($jabatan->updateJabatan($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'jabatan.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'jabatan.php';
            </script>";
            }
        }

        $jabatan->getJabatanById($id);
        $row = $jabatan->getResult();

        $dataUpdate = $row['jabatan_nama'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($jabatan->deleteJabatan($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'jabatan.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'jabatan.php';
            </script>";
        }
    }
}

$jabatan->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
