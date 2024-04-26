<?php

class Jabatan extends DB
{
    function getJabatan()
    {
        $query = "SELECT * FROM jabatan";
        return $this->execute($query);
    }

    function getJabatanById($id)
    {
        $query = "SELECT * FROM jabatan WHERE jabatan_id=$id";
        return $this->execute($query);
    }

    function addJabatan($data)
    {
        $nama = $data['nama'];
        $deskripsi = $data['deskripsi'];
        $query = "INSERT INTO jabatan (nama, deskripsi) VALUES ('$nama', '$deskripsi')";
        return $this->executeAffected($query);
    }

    function updateJabatan($id, $data)
    {
        $nama = $data['nama'];
        $deskripsi = $data['deskripsi'];
        $query = "UPDATE jabatan SET nama='$nama', deskripsi='$deskripsi' WHERE jabatan_id=$id";
        return $this->executeAffected($query);
    }

    function deleteJabatan($id)
    {
        $query = "DELETE FROM jabatan WHERE jabatan_id=$id";
        return $this->executeAffected($query);
    }
}
