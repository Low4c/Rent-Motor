<?php
if (isset($_POST['sewa'])) {
    // Mengambil data yang dikirim melalui form
    $nama = $_POST['nama'];
    $waktu = $_POST['waktu'];
    $motor = $_POST['motor'];
    $member = $_POST['member']; 

    // Kelas utama untuk menghitung harga sewa
    class Shell
    {
        public $waktu;
        public $motor;
        // Harga per jam untuk setiap motor
        protected $zx25r = 250000;
        protected $r1 = 500000;
        protected $bmws1000r = 750000;
        protected $ducativ4 = 1000000;

        // Konstruktor untuk menginisialisasi motor dan waktu
        function __construct($motor, $waktu)
        {
            $this->motor = $motor;
            $this->waktu = intval($waktu);
        }

        // Method untuk menghitung harga total
        function harga()
        {
            switch ($this->motor) {
                case "zx25r":
                    $hasil = $this->waktu * $this->zx25r;
                    break;
                case "r1":
                    $hasil = $this->waktu * $this->r1;
                    break;
                case "bmws1000r":
                    $hasil = $this->waktu * $this->bmws1000r;
                    break;
                case "ducativ4":
                    $hasil = $this->waktu * $this->ducativ4;
                    break;
                default:
                    $hasil = 0;
            }
            return $hasil;
        }
    }

    // Objek baru untuk menghitung transaksi sewa
    $transaction = new Shell($motor, $waktu);

    // Kelas untuk melakukan proses sewa
    class sewa extends Shell
    {
        private $nama;
        private $member;
        // Konstruktor untuk menginisialisasi data pelanggan dan status keanggotaan
        function __construct($motor, $waktu, $nama, $member)
        {
            parent::__construct($motor, $waktu);
            $this->nama = $nama;
            $this->member = $member;
        }
        // Method untuk melakukan proses pembelian
        function beli()
        {
            // Menghitung diskon berdasarkan status keanggotaan
            $discount = ($this->member == 'member') ? 5 / 100 : 0;
            // Menghitung total harga setelah diskon
            $total = $this->harga() - ($this->harga() * $discount);
            // Mengubah format total harga menjadi rupiah
            $total_formatted = number_format($total, 0, ',', '.');
            // Menampilkan hasil transaksi
            echo "================================================================<br>";
            echo "Pelanggan: " . $this->nama . "<br>";
            echo "Anda menyewa motor " . $this->motor . " dengan waktu " . $this->waktu . " jam<br> 
                 Harga total yang harus dibayarkan adalah Rp. " . $total_formatted . "<br>";
            echo "================================================================<br>";
        }
    }

    // Membuat objek untuk proses sewa
    $buy = new sewa($motor, $waktu, $nama, $member);
    // Melakukan proses pembelian
    $buy->beli();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penyewaan Motor</title>
</head>

<body style="display: flex; flex-direction: column; align-items: center; text-align: center;">
    <!-- Form untuk memasukkan data pelanggan dan motor yang disewa -->
    <form action="" method="post">
        <label for="nama">Masukkan nama</label><br>
        <input type="text" name="nama" id="nama"><br>
        <label for="waktu">Masukkan waktu penyewaan</label><br>
        <input type="number" name="waktu" id="waktu"><br>
        <select name="motor" id="motor" placeholder="pilih motor">
            <option value="zx25r">zx25r</option>
            <option value="r1">R1</option>
            <option value="bmws1000r">BMWS1000r</option>
            <option value="ducativ4">Ducati v4</option>
        </select><br>
        <select name="member" id="member"> 
            <option value="member">Member</option>
            <option value="nonmember">Non Member</option>
        </select><br>
        <!-- Tombol untuk melakukan proses penyewaan -->
        <input type="submit" name="sewa" value="Sewa">
    </form>
</body>

</html>