<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Makanan</title>
</head>
<body>
    <h2>Form Tambah Makanan</h2>

<form action="{{ route('foods.store') }}" method="POST">
    @csrf
    <label>Nama Makanan:</label>
    <input type="text" name="name" required><br>

    <label>Kategori:</label>
    <select name="category" required>
        <option value="Makanan Pokok">Makanan Pokok</option>
        <option value="Sayuran">Sayuran</option>
        <option value="Lauk Pauk">Lauk Pauk</option>
        <option value="Buah">Buah</option>
    </select><br>

    <label>Energi (kkal):</label>
    <input type="number" step="0.01" name="energy"><br>

    <label>Protein (g):</label>
    <input type="number" step="0.01" name="protein"><br>

    <label>Lemak (g):</label>
    <input type="number" step="0.01" name="fat"><br>

    <label>Karbohidrat (g):</label>
    <input type="number" step="0.01" name="carbohydrate"><br>

    <button type="submit">Simpan</button>
</form>

    <h1>Daftar Makanan</h1>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Energi (kkal)</th>
                <th>Protein (g)</th>
                <th>Lemak (g)</th>
                <th>Karbohidrat (g)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($foods as $food)
                <tr>
                    <td>{{ $food->name }}</td>
                    <td>{{ $food->category }}</td>
                    <td>{{ $food->energy }}</td>
                    <td>{{ $food->protein }}</td>
                    <td>{{ $food->fat }}</td>
                    <td>{{ $food->carbohydrate }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
