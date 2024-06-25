<?php
require_once 'classes/pessoa.php';
$pessoa = new Pessoa;
require_once 'classes/endereco.php';
$endereco = new Endereco;
require_once 'classes/conexaoBanco.php';
$conexao = new Conexao("projeto_funag", "localhost", "root", "");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cadastro de pessoas e endereços</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.css">
    <!--    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>-->
    <!--    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>-->
</head>
<style>
    * {
        margin: 0px;
        padding: 8px;
    }

    #b1, #b2 {
        width: 100%;
    }

    table {
        border: solid #e3eaf5 3px;
        background-color: white;
        border-radius: 10px;
    }

    table td {
        border: solid #e3eaf5 2px;
    }

    div.msg-erro-2 {
        width: 800px;
        margin: 10px auto;
        padding: 10px;
        border-radius: 30px;
        background-color: #dc3545;
        text-align: center;
        color: white;
    }

    div.msg-sucesso {
        width: 800px;
        margin: 10px auto;
        padding: 10px;
        border-radius: 30px;
        background-color: #50b733;
        text-align: center;
        color: white;
    }

</style>
<!--<body style="background-color: #e3eaf5">-->
<body>
<center><h3>Informações pessoais</h3></center>
<form method="POST">
    <div class="row">
        <div class="col-md-4">
            <label for="nome">Nome:</label>
            <input class="form-control" type="text" placeholder="Nome completo" name="nome" id="nome" maxlength="50">
        </div>
        <div class="col-md-4">
            <label for="rg">RG:</label>
            <input class="form-control" type="text" placeholder="RG" name="rg" id="rg" maxlength="10">
        </div>
        <div class="col-md-4">
            <label for="dataN">Data Nascimento:</label>
            <input class="form-control" type="text" placeholder="Data de Nascimento" name="dataN" id="dataN"
                   maxlength="10">
        </div>
    </div>
    <center><h3>Endereço</h3></center>
    <div class="row">
        <div class="col-md-3">
            <label for="rua">Rua:</label>
            <input class="form-control" type="text" placeholder="Rua" name="rua" id="rua" maxlength="50">
        </div>
        <div class="col-md-3">
            <label for="cep">CEP:</label>
            <input class="form-control" type="text" placeholder="CEP" name="cep" id="cep" maxlength="10">
        </div>
        <div class="col-md-3">
            <label for="cidade">Cidade:</label>
            <input class="form-control" type="text" placeholder="Cidade" name="cidade" id="cidade" maxlength="30">
        </div>
        <div class="col-md-3">
            <label for="uf">UF:</label>
            <input class="form-control" type="text" placeholder="UF" name="uf" id="uf" maxlength="2"><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input class="btn btn-info" type="submit" value="Cadastrar">
        </div>
    </div>
</form>
<?php
if (isset($_POST['nome'])) {
    $pessoa->setNomeCompleto(addslashes($_POST['nome']));
    $pessoa->setIdentidade(addslashes($_POST['rg']));
    $pessoa->setDataDeNascimento(addslashes($_POST['dataN']));
    $endereco->setRua(addslashes($_POST['rua']));
    $endereco->setCep(addslashes($_POST['cep']));
    $endereco->setCidade(addslashes($_POST['cidade']));
    $endereco->setUf(addslashes($_POST['uf']));

    if (!empty($pessoa->getNomeCompleto()) && !empty($pessoa->getIdentidade()) && !empty($pessoa->getDataDeNascimento())
        && !empty($endereco->getRua()) && !empty($endereco->getCep()) && !empty($endereco->getCidade()) && !empty($endereco->getUf())) {
        $conexao->conectar();
        if ($conexao->getMsgErro() == "") {
            if ($pessoa->cadastrarPessoa($pessoa->getNomeCompleto(), $pessoa->getIdentidade(), $pessoa->getDataDeNascimento(), $conexao->getPdo())) {
                $endereco->cadastrarEndereco($endereco->getRua(), $endereco->getCidade(), $endereco->getCep(), $endereco->getUf(), $pessoa->getIdentidade(), $conexao->getPdo());
                ?>
                    <div class="msg-sucesso">Cadastro realizado com sucesso!</div>
                <?php
            } else { ?>
           <div class="msg-erro-2">Pessoa já possui cadastro no banco de dados!</div>
            <?php }
        } else { ?>
                <div class="msg-erro-2">Erro: <?= $conexao->getMsgErro() ?></div>
       <?php }

    } else { ?>
            <div class="msg-erro-2">Preencha todos os campos!</div>
   <?php }
}
?>
<form method="GET">
    <div class="row">
        <div class="col-md-2">
            <h5>Buscar pessoas:</h5>
        </div>
        <div class="col-md-8">
            <input class="form-control" type="text" name="busca" size="50"
                   placeholder="Insira: Jefe... ou Jeferson para pesquisar ou não preencha nada para buscar todas as pessoas">
        </div>
        <div class="col-md-1">
            <button id="b1" class="btn btn-info">Buscar</button>
        </div>
        <div class="col-md-1">
            <a id="b2" class="btn btn-danger" href="telaDeCadastro.php">Voltar</a>
        </div>
    </div>
</form>


<?php
if (isset($_GET['busca'])) {
    if (!isset($_GET['busca'])) {
        header("Location: cadastroDePessoas.php");
        exit;
    } else {
        $busca = "%" . trim($_GET['busca']) . "%";

        if (strcmp($busca, "%%") > 0) {
            $conexao->conectar();
            $pdo = $conexao->getPdo();
            $sql = $pdo->prepare("SELECT * FROM pessoa WHERE nome LIKE :busca");
            $sql->bindParam(":busca", $busca, PDO::PARAM_STR);
            $sql->execute();
            $resultado = $sql->fetchall(PDO::FETCH_ASSOC);
        } else {

            $conexao->conectar();
            $pdo = $conexao->getPdo();
            $sql = $pdo->prepare("SELECT * FROM pessoa");
            $sql->execute();
            $resultado = $sql->fetchall(PDO::FETCH_ASSOC);
        }
    }
    if (count($resultado)) { ?>
        <table class="table-responsive">
            <tr>
                <th style="width: 50%">Nome</th>
                <th style="width: 20%">RG</th>
                <th style="width: 20%">Data de nascimento</th>
                <th style="width: 10%">Acão</th>
            </tr>
            <?php
            foreach ($resultado as $_resultado) {
                ?>

                <tr>
                    <td><?= $_resultado["nome"] ?></td>
                    <td><?= $_resultado["identidade"] ?></td>
                    <td><?= $_resultado["data_nascimento"] ?></td>
                    <td>
                        <button class="btn btn-info" data-toggle="modal" data-target=".novoend" name="button">Novo
                            endereço
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <div class="msg-erro-2">Não foram encontrados resultados com os parâmetros informados!</div>
    <?php } ?>
<?php } ?>

<div class="modal fade novoend" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Cadastrar novo endereço</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input required class="form-control" type="text" placeholder="Rua" name="n_rua" maxlength="50">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input required class="form-control" type="text" placeholder="CEP" name="n_cep" maxlength="10">
                        </div>
                        <div class="col-md-4">
                            <input required class="form-control" type="text" placeholder="Cidade" name="n_cidade" maxlength="30">
                        </div>
                        <div class="col-md-4">
                            <input required class="form-control" type="text" placeholder="UF" name="n_uf" maxlength="2"><br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (isset($_POST['n_rua'])) {
    $novoEndereco = new Endereco;
    $novoEndereco->setRua(addslashes($_POST['n_rua']));
    $novoEndereco->setCep(addslashes($_POST['n_cep']));
    $novoEndereco->setCidade(addslashes($_POST['n_cidade']));
    $novoEndereco->setUf(addslashes($_POST['n_uf']));

    if (!empty($novoEndereco->getRua()) && !empty($novoEndereco->getCep()) && !empty($novoEndereco->getCidade()) && !empty($novoEndereco->getUf())) {
        $conexao->conectar();
        if ($conexao->getMsgErro() == "") {
            $novoEndereco->cadastrarNovoEndereco($novoEndereco->getRua(), $novoEndereco->getCidade(), $novoEndereco->getCep(), $novoEndereco->getUf(), $_resultado["id_pessoa"], $conexao->getPdo());
            ?>
            <div class="msg-sucesso">Cadastro realizado com sucesso!</div>
            <?php
        } else {?>
            <div class="msg-erro-2">Erro: <?= $conexao->getMsgErro() ?></div>
            <?php
        }
    } else { ?>
        <div class="msg-erro-2">Preencha todos os campos!</div>
        <?php
    }
}
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>

</body>
</html>