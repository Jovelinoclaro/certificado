<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de Certificado</title>
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>
    <div class="container">
        <h1>Preencha os dados para gerar o certificado de Batismo</h1>
        <form action="certificado.php" method="post" enctype="multipart/form-data">
            <label for="nome">Nome completo:</label><br>
            <input type="text" id="nome" name="nome" required><br><br>
            
            <label for="data_batismo">Data de Batismo:</label><br>
            <input type="date" id="data_batismo" name="data_batismo" required><br><br>
            
            <label for="igreja">Nome da Igreja:</label><br>
            <input type="text" id="igreja" name="igreja" required><br><br>
            
            <label for="pastor">Pastor(a):</label><br>
            <input type="text" id="pastor" name="pastor" required><br><br>
            
            <label for="logo">Faça o upload da logo:</label><br>
            <input type="file" id="logo" name="logo" accept="image/*"><br><br>
            
            <button type="submit">Gerar Certificado</button>
        </form>
    </div>
</body>
</html>
