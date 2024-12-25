<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <title>Museo Cartoni Animati</title>
    <meta name="description"
        content="Il sito ufficiale per il Museo di cartoni animati. Informazioni, contatti e prenotazioni per il Museo dei cartoni animati.">
    <meta name="keywords" content="Museo,Mostre,Animazione,Cartoni Animati,cardgame,prenota,visita,informazioni">
    <link rel="stylesheet" href="css/style.css" media="screen">
    <link rel="stylesheet" href="css/middle.css" media="screen and (max-width: 1024px)">
    <link rel="stylesheet" href="css/mini.css" media="screen and (max-width: 768px)">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/pokeball.ico" type="image/x-icon">
    <script type="text/javascript" src="js/script.js"></script>
</head>

<body>

    <a id="top-help" class="help nascosto" href="#primoContenuto">Vai al contenuto</a>
    <header>
        <h1>Museo Cartoni Animati</h1>
        <button id="hamb" class="hamToggle" data-hambOn="true" type="button" onclick="hambToggle()">Menù</button>
    </header>

    <nav id="breadcrumb">
        <p>Ti trovi in: <span lang="en">Home</span></p>
    </nav>

    <nav id="menu" class="hamToggle" data-hambOn="true">
        <ul>
            <li id="currentLink" lang="en">Home</li>
            <li><a href="mostre.php">Le mostre</a></li>
            <li><a href="virtual_tour.php" lang="en">Virtual Tour</a></li>
            <li><a href="prenotazione.php">Prenotazione</a></li>
            <li><a href="recensioni.php">Recensioni</a></li>
            <li><a href="registrazione.php">Registrazione</a></li>

        </ul>
    </nav>

    <main>
        <div id="carosello">
            <ol class="immaginiCarosello">
                <li>
                    <img src="./images/immcarosello1.jpg" alt="Prima Immagine Carosello" class="onCarosello">
                </li>
                <li>
                    <img src="./images/immcarosello2.jpg" alt="Seconda Immagine Carosello" >
                </li>
                <li>
                    <img src="./images/immcarosello3.jpg" alt="Terza Immagine Carosello">
                </li>
            </ol>
            <button id="caroselloIndietro" type="button" aria-label="Immagine precedente"
                onclick="prossimaSlide(-1)">&#10094;</button>
            <button id="caroselloAvanti" type="button" aria-label="Immagine successiva"
                onclick="prossimaSlide(1)">&#10095;</button>
            <ol class="puntiniCarosello">
                <li>
                    <button class="active" type="button" 
                        onclick="currentSlide(1)">Scorri all'immagine numero 1</button>
                </li>
                <li>
                    <button class="" type="button"
                        onclick="currentSlide(2)">Scorri all'immagine numero 2</button>
                </li>
                <li>
                    <button class="" type="button"
                        onclick="currentSlide(3)">Scorri all'immagine numero 3</button>
                </li>
            </ol>
        </div>
        <section class="mainSection">
            <h1>Il museo dei cartoni animati internazionali più famosi</h1>
            <p>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap
                into
                electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the
                release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like
                Aldus PageMaker including versions of Lorem Ipsum
            </p>
            <p>
                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical
                Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at
                Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a
                Lorem
                Ipsum passage, and going through the cites of the word in classical literature, discovered the
                undoubtable
                source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The
                Extremes
                of Good and Evil) by Cicero, written in
            </p>
        </section>
    </main>
    <a class="help" id="torna-su" href="#">Torna su</a>
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
</body>





</html>