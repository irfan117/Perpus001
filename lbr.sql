-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jul 2024 pada 17.18
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lbr`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `rack` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('available','borrowed') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `year`, `rack`, `description`, `image`, `status`) VALUES
(5, 'Hidup adalah balas dendam', 'VIncent darwin', 2001, 'A2', '&quot;Hidup adalah Balas Dendam&quot; adalah sebuah novel yang menggambarkan kisah perjalanan hidup penuh liku dari seorang tokoh utama yang mengalami berbagai macam penderitaan dan kegagalan. Di tengah ketidakadilan dan kesulitan yang ia hadapi, ia menemukan cara untuk bangkit dan merencanakan balas dendam terhadap mereka yang telah menyakitinya.\r\n\r\nCerita ini dimulai dengan latar belakang masa kecil yang penuh dengan kekerasan dan penindasan. Tokoh utama tumbuh dalam lingkungan yang keras, di mana ia seringkali menjadi korban ketidakadilan dan kekejaman. Namun, di balik semua penderitaan itu, ia memiliki tekad yang kuat untuk mengubah nasibnya.\r\n\r\nSaat dewasa, ia mulai menyusun rencana balas dendam yang cermat dan terperinci. Setiap langkah dalam hidupnya diarahkan untuk mencapai tujuan ini. Ia belajar, bekerja keras, dan memanfaatkan setiap peluang yang ada untuk mendekati mereka yang telah membuat hidupnya menderita.\r\n\r\nDalam perjalanan balas dendamnya, ia bertemu dengan berbagai macam karakter yang memperkaya cerita. Ada yang membantunya, ada juga yang mencoba menghentikannya. Ia harus menghadapi dilema moral dan emosional, mempertanyakan apakah balas dendam benar-benar akan memberinya kepuasan yang ia cari.\r\n\r\n&quot;Hidup adalah Balas Dendam&quot; adalah sebuah cerita tentang tekad, perjuangan, dan pencarian keadilan. Novel ini menggugah emosi pembaca dengan narasi yang mendalam dan plot yang penuh dengan kejutan. Melalui kisah ini, pembaca diajak untuk merenungkan tentang arti sebenarnya dari keadilan, pengampunan, dan bagaimana seseorang dapat bangkit dari keterpurukan.', 'huuh.jpg', 'available'),
(6, 'Hidup Tidak ada Artinya', 'el makaroni', 2004, '1q', '&quot;Hidup Tidak Ada Artinya&quot; adalah sebuah novel yang menggambarkan pencarian makna hidup dari seorang tokoh utama yang mengalami serangkaian peristiwa yang membuatnya mempertanyakan nilai dan tujuan hidupnya. Cerita ini menggambarkan perjalanan emosional dan spiritual yang dalam, di mana sang tokoh utama menghadapi berbagai tantangan dan introspeksi diri.\r\n\r\nCerita dimulai dengan latar belakang masa kecil yang penuh dengan kegembiraan dan harapan, namun seiring berjalannya waktu, ia menghadapi berbagai rintangan dan kehilangan yang membuatnya merasa terpuruk. Ia merasa hidupnya kehilangan arah dan makna, dan mulai mencari jawaban atas pertanyaan-pertanyaan eksistensial yang menghantuinya.\r\n\r\nDalam usahanya untuk menemukan arti hidup, ia bertemu dengan berbagai karakter yang memberikan perspektif berbeda tentang kehidupan. Beberapa karakter ini menawarkan pandangan yang optimis dan penuh harapan, sementara yang lain menunjukkan sisi gelap dan pahit dari realitas. Setiap pertemuan membawa sang tokoh utama lebih dekat pada pemahaman tentang dirinya sendiri dan dunia di sekitarnya.\r\n\r\nPerjalanan ini membawa sang tokoh utama ke berbagai tempat dan situasi, dari kota-kota besar yang gemerlap hingga desa-desa terpencil yang sunyi. Ia mengalami momen-momen kebahagiaan, kesedihan, cinta, dan kehilangan yang mendalam. Melalui pengalaman-pengalaman ini, ia mulai menyadari bahwa makna hidup tidak selalu ditemukan dalam pencapaian besar atau keberhasilan materi, tetapi dalam hubungan, pengalaman, dan penerimaan diri.\r\n\r\n&quot;Hidup Tidak Ada Artinya&quot; adalah sebuah refleksi mendalam tentang pencarian makna dalam kehidupan yang penuh dengan ketidakpastian dan perubahan. Novel ini mengajak pembaca untuk merenungkan tentang arti kebahagiaan, tujuan, dan bagaimana kita bisa menemukan makna dalam setiap momen yang kita alami. Dengan narasi yang kuat dan karakter yang kompleks, cerita ini menawarkan pandangan yang kaya dan mendalam tentang perjalanan hidup manusia.', 'eqe.jpg', 'available'),
(7, 'Rasa yang Menghilang Ditiap Lembaran', 'Ten Sansam', 2019, '1B', 'Rasa yang Menghilang di Tiap Lembaran adalah sebuah novel yang mengisahkan perjalanan hidup seorang mantan penulis remaja SMA bernama Rafi, yang kini bekerja sebagai seorang karyawan kantoran biasa. Cerita ini menyelami hubungan antara masa lalu, ingatan, dan kenyataan yang kadang sulit dibedakan.\r\n\r\nRafi, seorang penulis muda berbakat di masa SMA, mencurahkan banyak perasaan dan pengalaman pribadinya ke dalam tulisan-tulisannya. Salah satu cerita yang paling berkesan baginya adalah tentang pacarnya saat SMA, yang harus berpisah dengannya karena keadaan. Meskipun begitu, Rafi terus melanjutkan hidupnya dan akhirnya meninggalkan dunia tulis-menulis.\r\n\r\nDelapan tahun kemudian, Rafi telah menjadi seorang pekerja kantoran yang menjalani rutinitas harian tanpa ada yang istimewa. Suatu hari, ia bertemu kembali dengan seorang wanita yang tampak sangat bahagia bertemu dengannya. Wanita tersebut adalah mantan pacarnya semasa SMA, yang begitu gembira bisa bertemu kembali dengan Rafi setelah sekian lama.\r\n\r\nNamun, kebahagiaan wanita itu berubah menjadi keterkejutan saat menyadari bahwa Rafi tidak mengenalinya sama sekali. Bagi Rafi, semua kenangan tentang wanita tersebut dan kisah cinta mereka tampak seperti bagian dari cerita yang pernah ia tulis, bukan pengalaman nyata yang pernah ia jalani. Ia benar-benar tidak ingat bahwa wanita itu pernah menjadi bagian penting dari hidupnya.\r\n\r\nCerita berkembang dengan Rafi yang mencoba menyelidiki dan memahami mengapa ia tidak bisa mengingat masa lalunya dengan jelas. Sementara itu, mantan pacarnya harus menghadapi kenyataan bahwa pria yang pernah sangat ia cintai kini tidak lagi mengenalinya. Mereka berdua harus menemukan cara untuk menjembatani ingatan dan kenyataan, mencari makna dari setiap lembaran hidup yang telah mereka lalui, baik yang tertulis maupun yang nyata.\r\n\r\nRasa yang Menghilang di Tiap Lembaran adalah sebuah cerita tentang pencarian jati diri, cinta yang hilang, dan usaha untuk menghubungkan kembali masa lalu dengan masa kini. Novel ini menggugah emosi pembaca dengan narasi yang mendalam dan penuh dengan kejutan, mengajak pembaca merenungkan tentang arti dari kenangan dan bagaimana kita bisa menemukan kembali diri kita sendiri dalam perjalanan hidup yang kompleks.', 'Default_a_young_male_office_worker_waiting_to_cross_in_front_o_0.jpg', 'borrowed'),
(8, 'Menembus Batas', 'James A', 2010, '4a', 'Menembus Batas adalah sebuah novel yang mengisahkan perjalanan hidup seorang anak bernama Aria, yang tumbuh dalam lingkungan penuh keterbatasan dan kesulitan, namun berhasil mengatasi segala rintangan untuk meraih kesuksesan. Cerita ini penuh inspirasi dan menggambarkan ketekunan, tekad, dan semangat juang seorang anak yang tidak pernah menyerah.\r\n\r\nAria tumbuh di sebuah desa kecil yang terpencil dengan segala keterbatasan fasilitas dan ekonomi. Ayahnya bekerja sebagai buruh tani, sementara ibunya membantu dengan membuka warung kecil di depan rumah. Meskipun hidup dalam kondisi yang serba kekurangan, Aria selalu memiliki mimpi besar untuk meraih pendidikan tinggi dan mengubah nasib keluarganya.\r\n\r\nSejak kecil, Aria menunjukkan kecerdasan dan rasa ingin tahu yang tinggi. Ia seringkali belajar dengan menggunakan buku-buku bekas dan penerangan seadanya. Meskipun sering menghadapi ejekan dari teman-temannya karena kemiskinan, Aria tetap bertekad untuk belajar dan meraih prestasi di sekolah.\r\n\r\nSaat memasuki jenjang SMA, Aria mendapatkan beasiswa untuk bersekolah di kota. Di sana, ia harus beradaptasi dengan lingkungan baru yang jauh lebih kompetitif. Namun, Aria tidak gentar. Ia terus belajar dengan giat, bekerja paruh waktu untuk mencukupi kebutuhan sehari-hari, dan tetap berprestasi di sekolah.\r\n\r\nDengan tekad yang kuat, Aria berhasil lulus dengan nilai terbaik dan diterima di universitas ternama dengan beasiswa penuh. Perjalanan hidupnya di universitas tidaklah mudah, namun Aria selalu ingat tujuan utamanya: untuk mengubah nasib keluarganya dan memberikan kehidupan yang lebih baik bagi orang tuanya.\r\n\r\nSeiring berjalannya waktu, Aria tidak hanya sukses secara akademis, tetapi juga berhasil menciptakan inovasi yang memberikan dampak positif bagi masyarakat. Ia menjadi inspirasi bagi banyak orang, terutama anak-anak dari desa asalnya, bahwa keterbatasan bukanlah halangan untuk meraih mimpi.\r\n\r\nMenembus Batas adalah cerita tentang keberanian, kerja keras, dan ketekunan seorang anak dalam menghadapi segala rintangan. Novel ini mengajak pembaca untuk percaya bahwa dengan tekad dan usaha yang sungguh-sungguh, tidak ada batas yang tidak bisa ditembus.', 'Default_a_young_male_office_worker_waiting_to_cross_0 (1).jpg', 'available'),
(9, 'Faithful Insight', 'Dede Halim', 2009, 'E3', 'Faithful Insight adalah sebuah novel yang mengisahkan perjalanan hidup seorang anak bernama Alex, yang memiliki jiwa bebas dan bersemangat untuk menjelajahi dunia. Dengan tujuan hidup yang jelas untuk menemukan dan merasakan pengalaman baru, Alex berpetualang ke berbagai tempat, bertemu dengan beragam orang, dan belajar tentang kehidupan dari setiap sudut pandang yang berbeda.\r\n\r\nSejak kecil, Alex selalu merasa ada dunia yang luas di luar sana yang menunggu untuk dijelajahi. Tidak seperti kebanyakan anak seusianya, Alex tidak pernah tertarik pada kehidupan yang teratur dan monoton. Ia selalu bermimpi untuk berkeliling dunia, mengunjungi tempat-tempat eksotis, dan mengalami budaya serta tradisi yang berbeda.\r\n\r\nNamun, Alex bukan hanya petualang; ia juga seorang anak yang cerdas dan selalu haus akan pengetahuan. Rasa ingin tahunya yang besar membawanya untuk belajar berbagai hal baru di setiap kesempatan. Dari ilmu pengetahuan hingga seni, dari teknologi hingga filsafat, Alex selalu mencari cara untuk memperkaya dirinya dengan pengetahuan dan keterampilan baru.\r\n\r\nSetelah menyelesaikan pendidikan dasar, Alex memutuskan untuk mewujudkan mimpinya. Dengan hanya membawa ransel dan beberapa barang penting, ia memulai perjalanannya. Dari pegunungan yang megah hingga pantai yang tenang, dari kota-kota modern yang sibuk hingga desa-desa tradisional yang terpencil, Alex menemukan keindahan di setiap tempat yang ia kunjungi.\r\n\r\nSelama perjalanannya, Alex bertemu dengan berbagai macam orang, masing-masing dengan cerita dan kebijaksanaan yang unik. Dari seorang nelayan tua yang mengajarinya tentang ketekunan, hingga seorang seniman jalanan yang menginspirasinya untuk melihat dunia dari perspektif yang berbeda, setiap pertemuan memberikan wawasan berharga bagi Alex.\r\n\r\nNamun, perjalanan Alex bukan hanya tentang tempat-tempat yang ia kunjungi atau orang-orang yang ia temui. Ini juga tentang pencarian dirinya sendiri. Melalui petualangan dan tantangan yang ia hadapi, Alex belajar tentang keberanian, kebebasan, dan arti sejati dari hidup yang penuh makna.\r\n\r\nFaithful Insight adalah cerita tentang kebebasan, eksplorasi, dan pencarian diri. Novel ini menggugah semangat petualangan dalam setiap pembaca, mengingatkan kita bahwa dunia ini penuh dengan keajaiban yang menunggu untuk ditemukan. Dengan narasi yang menyentuh dan penuh inspirasi, cerita Alex mengajak kita untuk berani mengejar impian dan menjalani hidup dengan penuh semangat, rasa ingin tahu, dan keinginan untuk terus belajar.', 'Default_a_smiling_teenager_named_Alex_in_a_suit_sits_on_a_chai_1.jpg', 'available');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Borrowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `book_id`, `borrow_date`, `return_date`, `status`) VALUES
(17, 6, 7, '2024-07-11', '2024-07-18', 'borrowed');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `active` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nim`, `name`, `password`, `role`, `active`) VALUES
(1, 'admin123', 'Admin User', 'adminpassword', 'admin', 0),
(3, '112', 'huuh', '$2y$10$UrC7ok9kfRVQBl0A6OaN3u9zXvdYN.4BskBfYa6X8qTkI8S9.7RuG', 'admin', 0),
(5, '10', 'huuh', '$2y$10$qlV1Hxi/uPteubzIKo5ubuP7KLPvwQQ2hDxwLnKI1ADb8y4rqZMUu', 'user', 1),
(6, '17221007', 'M.Irfan', '$2y$10$X.t6ymlLJuPXjleaz8GvlubYUQt5F1xZiH/IpInFvq4ISyBEmXD9u', 'user', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
