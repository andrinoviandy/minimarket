<?php
include("../config/koneksi_kantin.php");
include("../include/API.php");
session_start();
// error_reporting(0);
if (isset($_GET['kategori']) && $_GET['kategori'] == 'S') {
    $id_siswa = isset($_GET['id_siswa']) ? intval($_GET['id_siswa']) : 0;
    // Siapkan statement
    $stmt = $koneksi_kantin->prepare("SELECT pin FROM siswa WHERE id = ?");
    $stmt->bind_param("i", $id_siswa); // "i" untuk integer
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();
    $siswa = $result->fetch_assoc();
    if ($siswa) {
        $hashed_pin = hash('sha256', $siswa['pin']);
        if ($hashed_pin === $_GET['pin']) {
            die('S');
        } else {
            die('F');
        }
    } else {
        die('F'); // Jika siswa tidak ditemukan
    }
} else {
    $id_guru = isset($_GET['id_siswa']) ? intval($_GET['id_siswa']) : 0;
    // Siapkan prepared statement
    $stmt = $koneksi_kantin->prepare("SELECT pin FROM guru WHERE id = ?");
    $stmt->bind_param("i", $id_guru);
    $stmt->execute();

    // Ambil hasilnya
    $result = $stmt->get_result();
    $guru = $result->fetch_assoc();
    if ($guru) {
        $hashed_pin = hash('sha256', $guru['pin']);

        // Gunakan hash_equals untuk membandingkan secara aman
        if (hash_equals($hashed_pin, $input_pin)) {
            die('S');
        } else {
            die('F');
        }
    } else {
        die('F'); // Guru tidak ditemukan
    }
}
