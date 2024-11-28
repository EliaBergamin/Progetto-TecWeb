<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Le mostre</title>
    <meta name="description" content="Pagina dedicata alla sezione mostre del Museo Cartoni Animati">
    <meta name="keywords" content="mostre,carte,animazione,cartoni animati,rarità,giochi di carte collezionabili,prenota,visita,informazioni">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" media="screen">
    <link rel="stylesheet" href="../css/middle.css" media="screen and (max-width: 1024px)">
    <link rel="stylesheet" href="../css/mini.css" media="screen and (max-width: 768px)">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/pokeball.ico" type="image/x-icon"> 
    <script type="text/javascript" src="../js/script.js"></script>
</head>

<body>
    <a class="nascosto" href="#primoContenuto">Vai al contenuto</a>
    <header>
        <h1>Museo Cartoni Animati</h1>
        <button id="hamb" class="hamToggle" data-hambOn="false" type="button" onclick="hambToggle()">Menù</button>
    </header>

    <nav id="breadcrumb">
        Ti trovi in: <a href="../index.html" lang="en">Home</a> &gt; Le mostre
    </nav>

    <nav id="menu" class="hamToggle" data-hambOn="false">
        <ul>
            <li><a href="../index.html" lang="en">Home</a></li>
            <li id="currentLink">Le mostre</li>
            <li><a href="virtual_tour.html" lang="en">Virtual Tour</a></li>
            <li><a href="prenotazione.html">Prenotazione</a></li>
            <li><a href="recensioni.html">Recensioni</a></li>
            <li><a href="registrazione.html">Registrazione</a></li>

        </ul>
    </nav>

    <main id="mostre">
        <h1>Le mostre</h1>
        <dl>
            <?php 
                require_once("../prova.php");
            ?>
            <dt class="tipoMostre">Mostre in corso</dt>
            <!-- Prova --><dd>
            <dl>
                <dt class="nomeMostra"> Mostra Impressionismo</dt>
                <dd class="infoMostra">
                    <img src=../images/mostra.jpg alt=prvoa alt>
                    <p>Descrizione mostra: Una raccolta di opere impressioniste da tutto il mondo.</p>
                    <p class="giorniMostra">Da <time datetime=2024-03-01>01 Marzo 2024</time> a <time datetime=2024-06-30> 30 Giugno 2024 </time></p>
                    <a href="prenotazione.html" class="button">Prenota visita</a>
                </dd>
            </dl>
        </dd>
<dd>
            <dl>
                <dt class="nomeMostra"> Mostra Rinascimento</dt>
                <dd class="infoMostra">
                    <img src=../images/mostra.jpg alt=prvoa alt>
                    <p>Descrizione mostra: Esplora il periodo del Rinascimento con opere di artisti celebri.</p>
                    <p class="giorniMostra">Da <time datetime=2024-07-01>01 Luglio 2024</time> a <time datetime=2024-09-30> 30 Settembre 2024 </time></p>
                    <a href="prenotazione.html" class="button">Prenota visita</a>
                </dd>
            </dl>
        </dd>
<!-- Fine Prova -->

            <dt class="tipoMostre">Mostre in programma</dt>
            <dd>
                <dl>
                    <dt class="nomeMostra">Nome mostra futura 1</dt>
                    <dd class="infoMostra">
                        <img src="../images/mostra.jpg" alt="">
                        <p>Descrizione mostra: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque quam ante, ornare sed urna sed, molestie volutpat turpis. Duis et nunc in purus lacinia euismod. Suspendisse potenti. Duis tempus purus elit. Curabitur scelerisque iaculis orci vitae graw</p>
                        <p class="giorniMostra">Da <time datetime="2025-01-01">01 Gennaio 2025</time> a <time datetime="2025-02-01">01 Febbraio 2025</time></p>
                        <a href="prenotazione.html" class="button">Prenota visita</a>
                    </dd>
                    <dt class="nomeMostra">Nome mostra futura 2</dt>
                    <dd class="infoMostra">
                        <img src="../images/mostra.jpg" alt="">
                        <p>Descrizione mostra: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque quam ante, ornare sed urna sed, molestie volutpat turpis. Duis et nunc in purus lacinia euismod. Suspendisse potenti. Duis tempus purus elit. Curabitur scelerisque iaculis orci vitae grav</p>
                        <p class="giorniMostra">Da <time datetime="2025-04-01">01 Aprile 2025</time> a <time datetime="2025-06-01">01 Giugno 2025</time></p>
                        <a href="prenotazione.html" class="button">Prenota visita</a>
                    </dd>
                </dl>
            </dd>
            <!-- per le mostre passate io farei un accordion -->
            <dt><button class="accordion">Mostre passate</button></dt>
            <dd class="accordion-panel">
                <dl>
                    <dt class="nomeMostra">Nome mostra passata 1</dt>
                    <dd class="infoMostra">
                        <img src="../images/mostra.jpg" alt="">
                        <p>Descrizione mostra: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque quam ante, ornare sed urna sed, molestie volutpat turpis. Duis et nunc in purus lacinia euismod. Suspendisse potenti. Duis tempus purus elit. Curabitur scelerisque iaculis orci vitae grav</p>
                        <p class="giorniMostra">Conclusa <time datetime="2024-06-01">01 Giugno 2024</time></p>
                    </dd>
                    <dt class="nomeMostra">Nome mostra passata 2</dt>
                    <dd class="infoMostra">
                        <img src="../images/mostra.jpg" alt="">
                        <p>Descrizione mostra: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque quam ante, ornare sed urna sed, molestie volutpat turpis. Duis et nunc in purus lacinia euismod. Suspendisse potenti. Duis tempus purus elit. Curabitur scelerisque iaculis orci vitae grav</p>
                        <p class="giorniMostra">Conclusa <time datetime="2024-02-01">01 Febbraio 2024</time></p>
                    </dd>
                </dl>                       
            </dd>
        </dl>   
    </main>
    <a id="torna-su" href="#" aria-label="Torna su">⇪</a>
    <footer>
        <h2>Museo Cartoni Animati</h2>
        <dl>
            <dt> <abbr title="telefono">Tel</abbr>: </dt>
            <dd><a href="tel:+39123456789">123456789</a> </dd>
            <dt> <span lang="en">Email: </span> </dt>
            <dd> <a href="mailto:info@dominioImmaginario.com">info@dominioImmaginario.comm</a> </dd>
            <dt> Indirizzo: </dt>
            <dd>
                <a href="https://maps.app.goo.gl/xqD3pfvXG4ockxUeA">Via Luigi Luzzatti,
                    <abbr title="Numero civico">n.</abbr> 8, 35121 Padova</a>
            </dd>
        </dl>
        <!--         <a href="" lang="en">Privacy Link TODO</a>
 -->
        <p id="tab-descr" class="nascosto">La tabella contiene gli orari di apertura del museo</p>
        <table id="orari-museo" title="Orari del museo" aria-describedby="tab-descr">
            <caption>Orari del Museo</caption>
            <thead>
                <tr>
                    <td></td>
                    <th scope="col">Mattina</th>
                    <th scope="col">Pomeriggio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">Lunedì</th>
                    <td><time datetime="09:00">09:00</time> - <time datetime="12:00">12:00</time></td>
                    <td><time datetime="14:00">14:00</time> - <time datetime="19:00">19:00</time></td>
                </tr>
                <tr>
                    <th scope="row">Martedì</th>
                    <td><time datetime="09:00">09:00</time> - <time datetime="12:00">12:00</time></td>
                    <td><time datetime="14:00">14:00</time> - <time datetime="19:00">19:00</time></td>
                </tr>
                <tr>
                    <th scope="row">Sabato</th>
                    <td><time datetime="08:00">08:00</time> - <time datetime="13:00">13:00</time></td>
                    <td><time datetime="14:00">14:00</time> - <time datetime="20:00">20:00</time></td>
                </tr>
                <tr>
                    <th scope="row">Domenica</th>
                    <td><time datetime="08:00">08:00</time> - <time datetime="13:00">13:00</time></td>
                    <td><time datetime="14:00">14:00</time> - <time datetime="22:00">22:00</time></td>
                </tr>
            </tbody>
        </table>
    </footer>
    <script type="text/javascript" src="../js/accordion.js"></script>
</body>
</html>