<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Language" content="pt-br">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <link rel="stylesheet" href="style.css" media="all">
        <title>Professores</title>
    </head>
    <body>
        <header id="header" class="fixed-top d-flex align-items-cente">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">

      <h1 class="logo me-auto me-lg-0"><a>Eduarda Franzen</a></h1>
      <nav id="navbar" class="navbar order-last order-lg-0">
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      <a href="file:///C:/wamp64/www/CRUD2Aluno/CRUD/Tela%20Inicial/index.html">Tela Inicial</a>
      <a href="file:///C:/wamp64/www/CRUD2Aluno/CRUD/turmas.php" class="book-a-table-btn scrollto d-none d-lg-flex">Turmas</a>
            <a href="file:///C:/wamp64/www/CRUD2Aluno/CRUD/alunos.php" class="book-a-table-btn scrollto d-none d-lg-flex">Alunos</a>
    </div>
  </header>
  <br>
</br>
  <br>
</br>
  <br>
</br>
        <h1>Cadastro de Professores</h1>
        <?php
        session_start();
        include "./classes/Professor.php";

        if (isset($_GET['acao'])) {
            if ($_GET['acao'] == "salvar") {
                if ($_POST['enviar-professor']) {
                    $professor = new Professor();

                    $professor->setProfessor(
                        $_POST['codigo_professor'],
                        $_POST['nome-professor']
                    );

                    if ($professor->salvar()) {
                        $msg['msg'] = "Registro Salvo com sucesso!";
                        $msg['class'] = "success";
                    } else {
                        $msg['msg'] = "Falha ao salvar Registro!";
                        $msg['class'] = "success";
                    }
                    $_SESSION['msgs'][] = $msg;
                    unset($professor);
                }
            } else if ($_GET['acao'] == "excluir") {
                if (isset($_GET['codigo'])) {
                    if (Professor::excluir($_GET['codigo'])) {
                        $msg['msg'] = "Registro excluido com sucesso!";
                        $msg['class'] = "success";
                    } else {
                        $msg['msg'] = "Falha ao excluir Registro!";
                        $msg['class'] = "danger";
                    }
                    $_SESSION['msgs'][] = $msg;
                }
                header("location: professores.php");
            } else if ($_GET['acao'] == "editar") {
                if (isset($_GET['codigo'])) {
                    $professor = Professor::getProfessor($_GET['codigo']);
                }
            }
        }

        if (isset($_SESSION['msgs'])) {

            foreach ($_SESSION['msgs'] as $msg)
                echo "<div class=' all-msgs alert alert-{$msg['class']}'>{$msg['msg']}</div>";

            echo "<script defer> 
        setTimeout(
            function(){
                document.querySelector('.all-msgs').style='display:none';
            }
            ,
            5000
        );
    </script>";

            unset($_SESSION['msgs']);
        }

        if (!isset($professor)) {
            $professor = new Professor();
            $professor->setProfessor(null, null);
        }
        ?>
        <div class="container-fluid">
            <form name="form-professor" method="POST" action="?acao=salvar">
                <input type="hidden" name="codigo_professor" value="<?php echo $professor->getCodigo() ?>" />
                <div class="input-group mb-2">
                    <span class="input-group-text">Nome do Professor:</span>
                    <input type="text" class="form-control" id="nome-professor" name="nome-professor" value="<?php echo $professor->getNome() ?>">
                </div>
                <input type="submit" class="btn btn-primary" name="enviar-professor" value="Enviar" />
            </form>
            <hr />
        </div>
        <?php

        ?>
        <div class="container-fluid">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Professor</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $professores = Professor::listar();
                    foreach ($professores as $professor) {
                        echo "<tr>
                        <td>{$professor->getCodigo()}</td>
                        <td>{$professor->getNome()}</td>
                        <td>
                            <span class='badge rounded-pill bg-primary'>
                                <a href='?acao=editar&codigo={$professor->getCodigo()}' style='color:#fff'><i class='bi bi-pencil-square'></i></a>
                            </span>
                            <span class='badge rounded-pill bg-danger'>
                                <a href='?acao=excluir&codigo={$professor->getCodigo()}'style='color:#fff'><i class='bi bi-trash'></i></a>
                            </span>
                        </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>