<?php

include "config.php";

$count = 0;
$tot = 0;
$totincassare = 0;
$incassato = 0;

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <h1>Hello, world!</h1>


    <div class="container">
        <div class="row">
            <div class="col-9">

                <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='GET'>
                    <input name="query" value="fatture" class=" visually-hidden"></input>

                    <legend>Gestore fatture</legend>
                    <div class="mb-3">
                        <label for="ditta" class="form-label">Seleziona una ditta</label>
                        <select id="ditta" class="form-select" name="ditta">
                            <option disabled selected>Seleziona una ditta...</option>
                            <?php



                            $sql = "SELECT * FROM ditte ORDER BY id_ditta ASC;";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    if (isset($_GET['ditta']) && $_GET['ditta'] == $row['id_ditta']) {
                                        echo '<option selected  value="' . $row['id_ditta'] . '">' . $row['nditta'] . ' - ' . $row['address'] . '  (PIVA: ' . $row['piva'] . ' | CF: ' . $row['cf'] . ')  </option>';
                                    } else {
                                        echo '<option  value="' . $row['id_ditta'] . '">' . $row['nditta'] . ' - ' . $row['address'] . '  (PIVA: ' . $row['piva'] . ' | CF: ' . $row['cf'] . ')  </option>';
                                    }
                                }
                            } else {
                                echo '<option value="NULL"> C\'è un errore con il db</option>';
                            }



                            ?>

                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Vedi fatture</button>

                </form>





                <table class="table mt-5">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Importo</th>
                            <th scope="col">Data emissione</th>
                            <th scope="col">Data incasso</th>
                            <th scope="col">Modifica</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['query']) && isset($_GET['ditta'])) {
                            if ($_GET['query'] == 'fatture') {

                                $sql = 'SELECT * FROM fatture JOIN clienti ON fatture.id_cliente=clienti.id_cliente WHERE fatture.id_ditta=' . $_GET['ditta'];

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {

                                    while ($row = $result->fetch_assoc()) {

                                        $count++;
                                        $tot = $tot + $row['importo'];



                                        if (empty($row['dataincasso'])) {
                                            echo '<tr>
                                        <th scope="row" >' . $count . '</th>
                                        <td>' . $row['ncliente'] . ' </td>
                                        <td>' . $row['importo'] . ' </td>
                                        <td>' . $row['data'] . ' </td>
                                        <td class="table-danger" >NON ANCORA PAGATA </td>
                                        <td> <a data-table=\'' . json_encode($row) . '\' href="#" data-bs-toggle="modal" data-bs-target="#modificaModal"> modifica </a></td>
                                        
                                        
                                        ';
                                        } else {
                                            echo '<tr>
                                            <th scope="row" value="' . $row['id_fattura'] . '">' . $count . '</th>
                                            <td>' . $row['ncliente'] . ' </td>
                                            <td>' . $row['importo'] . ' </td>
                                            <td>' . $row['data'] . ' </td>
                                            <td >' . $row['dataincasso'] . ' </td>
                                            <td> <a data-table=\'' . json_encode($row) . '\' href="#" data-bs-toggle="modal" data-bs-target="#modificaModal"> modifica </a></td>
                                            
                                            
                                            ';
                                            $incassato = $incassato + $row['importo'];
                                        }
                                    }
                                    $totincassare = $tot - $incassato;
                                }
                            }
                        }


                        ?>

                    </tbody>
                </table>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#aggiungifatturaModal">
                    Aggiungi fattura
                </button>




            </div>
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Totale fatture: <?php echo $count ?></h5>
                        <h5 class="card-title">Totale importo: <?php echo $tot ?> €</h5>
                        <h5 class="card-title">Totale da incassare: <?php echo ($totincassare == 0 ? "<span class='text-success'>Tutto incassato</span>" : "<span class='text-danger'>" . $totincassare . " €</span>")  ?> </h5>

                        <p class="card-text mt-5">Questo è un esempio evidenziando solamente una parte di un grande sistema.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal modifica fattura -->
    <div class="modal fade" id="modificaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifica Fattura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
                        <input type="hidden" name="query" value="modifica">

                        <input type="hidden" id="id_fattura" name="id_fattura">
                        <div class="mb-3">
                            <label for="importo" class="form-label">importo</label>
                            <input type="text" class="form-control" id="importo" name="importo">
                        </div>
                        <div class="mb-3">
                            <label for="dataemissione" class="form-label">data emissione</label>
                            <input type="date" class="form-control" id="dataemissione" name="dataemissione">
                        </div>
                        <div class="mb-3">
                            <label for="dataincasso" class="form-label">data incasso</label>
                            <input type="date" class="form-control" id="dataincasso" name="dataincasso">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-success">Salva i cambiamenti</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal aggiunta fattura-->
    <div class="modal fade" id="aggiungifatturaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Aggiungi Fattura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
                        <input type="hidden" name="query" value="aggiunta">

                        <input type="hidden" name="id_ditta" id="id_ditta">

                        <div class="mb-3">
                            <label for="nditta" class="form-label">Ditta</label>
                            <input type="text" class="form-control" disabled id="nditta" name="nditta">
                        </div>

                        <div class="mb-3">
                            <label for="id_cliente" class="form-label">Seleziona un cliente</label>
                            <select name="id_cliente" class="form-select">
                                <option selected disabled>Seleziona...</option>
                                <?php

                                if (isset($_GET['ditta'])) {


                                    //questa query viene eseguita ogni volta che la pagina viene caricata
                                    $sql = "SELECT * FROM clienti WHERE id_ditta=" . $_GET['ditta'] . ";";
                                    $result = $conn->query($sql);

                                    //Mostra tutti i clienti di una specifica ditta
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id_cliente'] . "'>" . $row['ncliente'] . "</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="importo" class="form-label">importo</label>
                            <input type="text" class="form-control" id="importo" name="importo">
                        </div>
                        <div class="mb-3">
                            <label for="dataemissione" class="form-label">data emissione</label>
                            <input type="date" class="form-control" id="dataemissione" name="dataemissione">
                        </div>
                        <div class="mb-3">
                            <label for="dataincasso" class="form-label">data incasso</label>
                            <input type="date" class="form-control" id="dataincasso" name="dataincasso">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-success">Aggiungi la fattura</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <?php
    // Gestisce la modifica della fattura
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['query']) && $_POST['query'] == "modifica") {

        $stmt = $conn->prepare('UPDATE fatture SET importo=?, data=?, dataincasso=? WHERE id_fattura=?');
        $stmt->bind_param("dssi", $importo, $data, $dataincasso, $id_fattura);
        $id_fattura = $_POST['id_fattura'];
        $importo = $_POST['importo'];
        $data = $_POST['dataemissione'];
        $dataincasso = (empty($_POST['dataincasso']) ? NULL : $_POST['dataincasso']);
        $stmt->execute();
    }

    // Gestisce l'aggiunta della fattura
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['query']) && $_POST['query'] == "aggiunta") {

        $stmt = $conn->prepare("INSERT INTO fatture (id_ditta, id_cliente, importo, data, dataincasso) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("iidss", $id_ditta, $id_cliente, $importo, $data, $dataincasso);

        $id_ditta = $_POST['id_ditta'];
        $id_cliente = $_POST['id_cliente'];
        $importo = $_POST['importo'];
        $data = $_POST['dataemissione'];
        $dataincasso = (empty($_POST['dataincasso']) ? NULL : $_POST['dataincasso']);

        $stmt->execute();
    }
    ?>

    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <script>
        // Passa i dati al modal per la modifica della fattura
        $('#modificaModal').on('show.bs.modal', function(e) {
            var data = $(e.relatedTarget).data('table');
            console.log(data);
            $(e.currentTarget).find('#id_fattura').val(data['id_fattura']);
            $(e.currentTarget).find('#importo').val(data['importo']);
            $(e.currentTarget).find('#dataemissione').val(data['data']);
            $(e.currentTarget).find('#dataincasso').val(data['dataincasso']);
        })

        // Passa i dati al modal per aggiunta della fattura
        $('#aggiungifatturaModal').on('show.bs.modal', function(e) {
            console.log($('#ditta option:selected').text());
            $(e.currentTarget).find('#nditta').val($('#ditta option:selected').text());
            $(e.currentTarget).find('#id_ditta').val($('#ditta option:selected').val());
        })
    </script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
</body>

</html>