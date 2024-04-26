<?php

class Pengurus extends DB
{
    function getPengurusJoin()
    {
        $query = "SELECT * FROM pengurus JOIN divisi ON pengurus.divisi_id=divisi.divisi_id JOIN jabatan ON pengurus.jabatan_id=jabatan.jabatan_id ORDER BY pengurus.pengurus_id";

        return $this->execute($query);
    }

    function getPengurus()
    {
        $query = "SELECT * FROM pengurus";
        return $this->execute($query);
    }

    function getPengurusById($id)
    {
        $query = "SELECT * FROM pengurus JOIN divisi ON pengurus.divisi_id=divisi.divisi_id JOIN jabatan ON pengurus.jabatan_id=jabatan.jabatan_id WHERE pengurus_id=$id";
        return $this->execute($query);
    }

    function searchPengurus($keyword)
    {
        $query = "SELECT * FROM pengurus WHERE nama LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function addData($data, $file)
    {
        $nama = $data['nama'];
        $divisi_id = $data['divisi_id'];
        $jabatan_id = $data['jabatan_id'];
        $query = "INSERT INTO pengurus (nama, divisi_id, jabatan_id, foto) VALUES ('$nama', $divisi_id, $jabatan_id, '$file')";
        return $this->executeAffected($query);
    }

    function updateData($id, $data)
    {
        $nama = $data['pengurus_nama'];
        $nim = $data['pengurus_nim'];
        $semester = $data['pengurus_semester'];
        $divisi_id = $data['divisi_id'];
        $jabatan_id = $data['jabatan_id'];
        $query = "UPDATE pengurus SET pengurus_nama='$nama', pengurus_nim='$nim', pengurus_semester='$semester', divisi_id=$divisi_id, jabatan_id=$jabatan_id WHERE pengurus_id=$id";
        return $this->executeAffected($query);
    }

    function deleteData($id)
    {
        $query = "DELETE FROM pengurus WHERE pengurus_id=$id";
        return $this->executeAffected($query);
    }
}
