<?php
// Daftar buku dan statusnya (true jika tersedia, false jika sudah dipinjam)
$books = [
    ['title' => 'I think I Love You', 'author' => 'Cha Mirae', 'year' => 2022, 'available' => true, 'image' => 'img/Love.jpg.jpg'],
    ['title' => 'Oh My Savior', 'author' => 'Washashira', 'year' => 2022, 'available' => true, 'image' => 'img/Oh My.jpeg'],
    ['title' => 'Haru Nu Sora', 'author' => 'Laili Mutaminah', 'year' => 2020, 'available' => true, 'image' => 'img/SORA.jpg'],
    ['title' => 'Mariposa', 'author' => 'Luluk HF', 'year' => 2018, 'available' => true, 'image' => 'img/mariposa.jpeg'],
    ['title' => 'Melangkah', 'author' => 'J.S Khairen', 'year' => 2022, 'available' => true, 'image' => 'img/Melangkah.jpg'],
    ['title' => 'Laut bercerita', 'author' => 'Leila S.Chudori', 'year' => 2018, 'available' => true, 'image' => 'img/laut bercerita.jpg'],
    ['title' => 'Dikta dan Hukum', 'author' => 'Dhia an farah', 'year' => 2018, 'available' => true, 'image' => 'img/dikta.jpg'],
];

// Fungsi untuk meminjam buku
function borrowBook($bookIndex) {
    global $books;
    if ($books[$bookIndex]['available']) {
        $books[$bookIndex]['available'] = false;
        return true;
    }
    return false;
}

// Fungsi untuk mengembalikan buku
function returnBook($bookIndex) {
    global $books;
    if (!$books[$bookIndex]['available']) {
        $books[$bookIndex]['available'] = true;
        return true;
    }
    return false;
}

// Fungsi untuk mencari buku berdasarkan penulis
function searchBooks($keyword) {
    global $books;
    $filteredBooks = [];
    foreach ($books as $book) {
        if (stripos($book['author'], $keyword) !== false) {
            $filteredBooks[] = $book;
        }
    }
    return $filteredBooks;
}


// Memeriksa apakah ada kata kunci pencarian yang dikirimkan
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $books = searchBooks($keyword);
}

// Memeriksa apakah permintaan adalah POST dan menangani permintaan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['borrow'])) {
        $bookIndex = $_POST['book'];
        borrowBook($bookIndex);
    } elseif (isset($_POST['return'])) {
        $bookIndex = $_POST['book'];
        returnBook($bookIndex);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Bandung</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-top: 20px;
            text-align: center;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .book-image {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>

<h2>Library Bandung</h2>

<form method="get">
    <label for="keyword">Search:</label>
    <input type="text" id="keyword" name="keyword">
    <button type="submit">Search</button>
</form>

<table>
    <tr>
        <th>Cover</th>
        <th>Title</th>
        <th>Author</th>
        <th>Year</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php foreach ($books as $index => $book): ?>
    <tr>
        <td><img src="<?php echo $book['image']; ?>" alt="<?php echo $book['title']; ?>" class="book-image"></td>
        <td><?php echo $book['title']; ?></td>
        <td><?php echo $book['author']; ?></td>
        <td><?php echo $book['year']; ?></td>
        <td><?php echo $book['available'] ? 'Available' : 'Not Available'; ?></td>
        <td>
            <form method="post">
                <input type="hidden" name="book" value="<?php echo $index; ?>">
                <?php if ($book['available']): ?>
                    <button type="submit" name="borrow">borrow</button>
                <?php else: ?>
                    <button type="submit" name="return">return</button>
                <?php endif; ?>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>