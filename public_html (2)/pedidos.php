<?php
// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados enviados no corpo da requisição
    $data = json_decode(file_get_contents("php://input"), true);

    // Verifica se os dados foram recebidos corretamente
    if (isset($data['nome']) && isset($data['cpf'])) {
        // Conecta ao banco de dados MySQL
        $servername = "srv1436.hstgr.io"; // Substitua pelo nome do seu servidor MySQL
        $username = "u350717544_RzppV"; // Substitua pelo seu nome de usuário MySQL
        $password = "Parcelai2024@"; // Substitua pela sua senha do MySQL
        $dbname = "u350717544_LRPBN"; // Substitua pelo nome do seu banco de dados MySQL

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica a conexão com o banco de dados
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Prepara a declaração SQL para inserção dos dados
        $sql = "INSERT INTO tabela_pedidos (nome, cpf) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $data['nome'], $data['cpf']);

        // Executa a declaração SQL
        if ($stmt->execute()) {
            // Se a inserção for bem-sucedida, retorna um código de status 200
            http_response_code(200);
        } else {
            // Se houver algum erro na inserção, retorna um código de status 500 e uma mensagem de erro
            http_response_code(500);
            echo "Erro ao inserir os dados: " . $conn->error;
        }

        // Fecha a conexão com o banco de dados
        $stmt->close();
        $conn->close();
    } else {
        // Se os dados não forem recebidos corretamente, retorna um código de status 400 e uma mensagem de erro
        http_response_code(400);
        echo "Dados inválidos";
    }
} else {
    // Se a requisição não for do tipo POST, retorna um código de status 405 e uma mensagem de erro
    http_response_code(405);
    echo "Método não permitido";
}
?>
