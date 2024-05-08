<?php

// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // Redireciona para a página inicial ou exibe uma mensagem de erro
    header("Location: index.php");
    exit(); // Certifique-se de sair do script após o redirecionamento
}

// Processamento do upload da logo
if ($_FILES["logo"]["error"] == UPLOAD_ERR_OK) {
    $temp_name = $_FILES["logo"]["tmp_name"];
    $logo = imagecreatefromstring(file_get_contents($temp_name));
    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);

    // Redimensionamento da logo para 50x50 pixels
    $new_logo_width = 220;
    $new_logo_height = 220;
    $resized_logo = imagecreatetruecolor($new_logo_width, $new_logo_height);
    imagecopyresampled($resized_logo, $logo, 0, 0, 0, 0, $new_logo_width, $new_logo_height, $logo_width, $logo_height);


    // Posicionamento da logo no certificado
    $certificado_width = $new_logo_width + 1680; // Ajuste de margem
    $certificado_height = 600; // Altura padrão do certificado
    $logo_position_x = $certificado_width - $new_logo_width + 20; // Ajuste de margem
    $logo_position_y = +1100; // Ajuste de margem
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $nome = $_POST["nome"];
    $data_batismo = $_POST["data_batismo"];
    $igreja = $_POST["igreja"];
    $pastor = $_POST["pastor"];

    // Cria uma imagem a partir do arquivo JPEG
    $image = imagecreatefromjpeg("image/certficado.jpg");

    // Define as cores
    $titleColor = imagecolorallocate($image, 0, 0, 0);

    // Adiciona texto à imagem usando imagettftext
    imagettftext($image, 60, 0, 250, 230, $titleColor, __DIR__ . DIRECTORY_SEPARATOR . "fonts" . DIRECTORY_SEPARATOR . "Bevan" . DIRECTORY_SEPARATOR . "Bevan-Regular.ttf", "CERTIFICADO  DE  BATISMO");
    imagettftext($image, 60, 0, 580, 390, $titleColor, __DIR__ . DIRECTORY_SEPARATOR . "fonts" . DIRECTORY_SEPARATOR . "Playball" . DIRECTORY_SEPARATOR . "Playball-Regular.ttf", $igreja);
    imagettftext($image, 50, 0, 380, 550, $titleColor, __DIR__ . DIRECTORY_SEPARATOR . "fonts" . DIRECTORY_SEPARATOR . "Playball" . DIRECTORY_SEPARATOR . "Playball-Regular.ttf", "Certificamos que");
    imagettftext($image, 50, 0, 840, 550, $titleColor, __DIR__ . DIRECTORY_SEPARATOR . "fonts" . DIRECTORY_SEPARATOR . "Playball" . DIRECTORY_SEPARATOR . "Playball-Regular.ttf", $nome);
    imagettftext($image, 45, 0, 380, 650, $titleColor, __DIR__ . DIRECTORY_SEPARATOR . "fonts" . DIRECTORY_SEPARATOR . "Playball" . DIRECTORY_SEPARATOR . "Playball-Regular.ttf", "Foi batizado(a) em nome do Pai, do Filho e do Espírito Santo 
 conforme o mandamento de Jesus Cristo");
    imagettftext($image, 45, 0, 380, 850, $titleColor, __DIR__ . DIRECTORY_SEPARATOR . "fonts" . DIRECTORY_SEPARATOR . "Playball" . DIRECTORY_SEPARATOR . "Playball-Regular.ttf", "‘’Portanto ide, fazei discípulos de todas as nações, batizando-os
 em nome do Pai, e do Filho, e do Espírito Santo’’.
     Mateus 28:19");

    // Adiciona a logo à imagem
    if (isset($resized_logo)) {
        imagecopy($image, $resized_logo, $logo_position_x, $logo_position_y, 0, 0, $new_logo_width, $new_logo_height);
        // Libera a memória alocada para a logo
        imagedestroy($resized_logo);
    }

    // Adiciona o nome do pastor à imagem usando imagettftext()
    $posicao_x_pastor = 420;
    $posicao_y_pastor = 1200;
    $nome_pastor = utf8_decode($pastor);
    $font_size_pastor = 50;
    $angulo = 0;
    $diretorio_fonte = __DIR__ . DIRECTORY_SEPARATOR . "fonts" . DIRECTORY_SEPARATOR . "Playball" . DIRECTORY_SEPARATOR . "Playball-Regular.ttf";
    imagettftext($image, $font_size_pastor, $angulo, $posicao_x_pastor, $posicao_y_pastor, $titleColor, $diretorio_fonte, $nome_pastor);

    // Obtém as coordenadas do nome do pastor
    $bbox_pastor = imagettfbbox($font_size_pastor, $angulo, $diretorio_fonte, $nome_pastor);
    $largura_pastor = $bbox_pastor[2] - $bbox_pastor[0]; // Largura do texto do pastor
    $altura_pastor = $bbox_pastor[1] - $bbox_pastor[7]; // Altura do texto do pastor

    // Adiciona o texto "Pastor Presidente" abaixo do nome do pastor
    $titulo = "Pastor Presidente";
    $posicao_x_titulo = $posicao_x_pastor;
    $posicao_y_titulo = $posicao_y_pastor + $altura_pastor + 3; // Distância entre o nome do pastor e o título
    $tamanho_fonte = 30; // Tamanho da fonte
    imagettftext($image, $tamanho_fonte, 0, $posicao_x_titulo, $posicao_y_titulo, $titleColor, $diretorio_fonte, utf8_decode($titulo));

    // Desenha uma linha entre o nome do pastor e o texto "Pastor Presidente"
    imageline($image, $posicao_x_pastor, $posicao_y_pastor + $altura_pastor - 40, $posicao_x_pastor + $largura_pastor, $posicao_y_pastor + $altura_pastor - 40, $titleColor);


    
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
    // Adiciona o texto "Data Batismo" com a data formatada "_/_/_
     $data_formatada = strtotime($data_batismo); // Converte a data para um timestamp
     $texto_data_batismo = strftime("No dia %d de %B de %Y", $data_formatada); // Formata a data como "dia de mês de ano"


    $posicao_x_data_batismo = 1300; // Posição x
    $posicao_y_data_batismo = 1200; // Posição y
    $tamanho_fonte_data_batismo = 30; // Tamanho da fonte para a data de batismo
    imagettftext($image, $tamanho_fonte_data_batismo, 0, $posicao_x_data_batismo, $posicao_y_data_batismo, $titleColor, $diretorio_fonte, utf8_decode($texto_data_batismo));

    // Adiciona uma linha diretamente abaixo do texto "Data Batismo"
    $comprimento_linha = 240; // Comprimento da linha
    $posicao_x_inicio_linha = $posicao_x_data_batismo; // Posição x inicial
    $posicao_y_inicio_linha = $posicao_y_data_batismo + 5; // Posição y inicial
    $posicao_x_fim_linha = $posicao_x_inicio_linha + $comprimento_linha; // Posição x final
    $posicao_y_fim_linha = $posicao_y_inicio_linha; // Posição y final
    imageline($image, $posicao_x_inicio_linha, $posicao_y_inicio_linha, $posicao_x_fim_linha, $posicao_y_fim_linha, $titleColor);

     
    // Adiciona o texto "Data" abaixo da linha
    $texto_data = "Data";
    $posicao_x_data = $posicao_x_data_batismo; // Mantém a mesma posição x
    $posicao_y_data = $posicao_y_inicio_linha + 40; // Posição y abaixo da linha
    $tamanho_fonte_data = 30; // Tamanho da fonte para o texto "Data"
    imagettftext($image, $tamanho_fonte_data, 0, $posicao_x_data, $posicao_y_data, $titleColor, $diretorio_fonte, utf8_decode($texto_data));

    // Define o tipo de conteúdo como JPEG
    header("Content-Type: image/jpeg");

    // Exibe a imagem na tela
    imagejpeg($image, null);

    // Libera a memória alocada para a imagem
    imagedestroy($image);
}
?>