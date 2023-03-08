<?php
include_once("blocks/header.phtml");
?>
<main class="admin-home-main">
    <?php
    if(isset($_SESSION['err_msg'])) {
        echo $_SESSION['err_msg'];
        unset($_SESSION['err_msg']);
    }
    ?>
    <div class="admin-home-container">
        <h1>Administratoru lapa</h1>
        <p>Jūsu administratora līmenis: <?php echo $_SESSION['admin'];?></p>
    </div>
    <h2 style="text-align: center">Lietošanas pamācība</h2>
    <div class="faq-container">
        <div class="faq-item">
            <div class="faq-item-header">Administrācijas lapas atvēršana</div>
            <div class="faq-content">
                <p>Lai administrators varētu piekļūt administrācijas lapai, no jebkuras administratoram pieejamas lapas jāspiež uz "Administrācija" pogu, kas ir lapas galvenes labajā pusē. Administrators tiks novirzīts uz administrācijas lapu.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-item-header">Atgriešanās no administrācijas lapas</div>
            <div class="faq-content">
                <p>Lai administrators varētu piekļūt atpakaļ Pro State Bank tīmekļa vietnes galvenajai lapai, no administrācijas lapas jāspiež uz "Atgriezties" pogu, kas ir lapas galvenes labajā pusē. Administrators tiks novirzīts uz Pro State Bank tīmekļa vietnes galveno lapu.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-item-header">Atbildēšana uz lietotāju veidotiem ziņojumiem</div>
            <div class="faq-content">
                <p>Lai administrators varētu atbildēt uz lietotāju veidotiem ziņojumiem, no administrācijas lapas jāspiež uz "Pieprasījumi" pogu, kas ir lapas galvenes pirmā navigācijas poga. Administrators tiks novirzīts uz lietotāju ziņojumu lapu.</p>
                <p>Lietotāju ziņojumu lapā tiks uzrādīti visi neatbildētie lietotāju ziņojumi, kur uz katra tiek norādīts ziņojuma virsraksts, ziņojuma autors, ziņojuma izveides datums un ziņojuma saturs.</p>
                <p>Ja ziņojuma saturs ir lieks, ziņojumu var dzēst, spiežot sarkano pogu "Dzēst" ziņojuma loga apakšā labajā pusē. Pēc poga piespiešanas ziņojums tiks dzēsts.</p>
                <p>Ja nepieciešams sniegt atbildi uz ziņojumu, spiest zaļo pogu "Atbildēt" ziņojuma loga apakšā kreisajā pusē. Administrators tiks novirzīts uz lietotāja ziņojuma atbildēšanas lapu.</p>
                <p>Lietotāja ziņojuma atbildēšanas lapā atrodas 1 ievades lauks, kur nepieciešams ievadīt atbildes tekstu. Pēc atbildes teksta ievades spiest pogu "Sūtīt atbildi" zem ievades lauka, lai sistēma nosūtītu e-pasta ziņojumu uz lietotāja norādīto e-pasta adresi. Administrators tiks novirzīts uz lietotāju ziņojumu lapu un ziņojums, uz kuru tika sniegta atbilde, tiks dzēsts.</p>

            </div>
        </div>
        <div class="faq-item">
            <div class="faq-item-header">Visu veikto maksājumu vēstures apskate</div>
            <div class="faq-content">
                <p>Lai administrators varētu apindent-listatīt visu veikto maksājumu vēsturi, no administrācijas lapas jāspiež uz "Maksājumi" pogu, kas ir lapas galvenes otrā navigācijas poga. Administrators tiks novirzīts uz visu veikto maksājumu vēstures lapu.</p>
                <p>Visu veikto maksājumu vēstures lapā tiks uzrādīti visi veiktie maksājumi. Maksājuma vēsturē katram maksājumam ir redzami konkrētā maksājuma parametri:</p>
                <ul class="indent-list">
                    <li>Sūtītāja konta numurs un nosaukums;</li>
                    <li>Saņēmēja konta numurs un nosaukums;</li>
                    <li>Summa;</li>
                    <li>Detaļas jeb maksājuma mērķis;</li>
                    <li>Laiks, kurā maksājums veikts.</li>
                </ul>
                <p>Uzklikšķinot sūtītāja vai saņēmēja konta numuru, administratoram ir iespēja apindent-listatīt šī konta informāciju un maksājumu vēsturi, bet uzklikšķinot uz sūtītāja vai saņēmēja vārdu un uzvārdu, administratoram ir iespēja apindent-listatīt profila informāciju un profilam visus piederošos kontus.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-item-header">Lietotāju darbību reģistra apskate</div>
            <div class="faq-content">
                <p>Lai administrators varētu apindent-listatīt lietotāju darbības reģistru, no administrācijas lapas jāspiež uz "Lietotāju darbības reģistrs" pogu, kas ir lapas galvenes trešā navigācijas poga. Administrators tiks novirzīts uz lietotāju darbības reģistra lapu.</p>
                <p>Lietotāju darbības reģistra lapā tiek izvadītas visas darbības, ko ir veikuši visi lietotāji.</p>
                <p>Lietotāju darbības reģistrā ir redzami konkrēti parametri:</p>
                <ul class="indent-list">
                    <li>Lietotāja vārds un uzvārds, kurš veicis norādīto darbību;</li>
                    <li>Darbības veids ar attiecīgu nozīmības pakāpes krāsu;</li>
                    <li>Datums un laiks, kurā darbība tika veikta;</li>
                    <li>IP adrese, no kuras tika veikta šī darbība.</li>
                </ul>
                <p>Darbības tiek iedalītas savās nozīmības pakāpēs, kas norāda, cik nozīmīga ir darbība, ko lietotājs ir veicis. Kopumā ir 3 nozīmības pakāpes:</p>
                <ul class="indent-list">
                    <li>Nenozīmīga darbība - attēlota ar melnu krāsu;</li>
                    <li>Nozīmīga darbība - attēlota ar oranžu krāsu;</li>
                    <li>Svarīga darbība - attēlota ar sarkanu krāsu.</li>
                </ul>
                <p>Lietotāju darbības reģistrā tiek reģistrētas šādas darbības:</p>
                <ul class="indent-list">
                    <li>"login" - lietotāja ielogošanās Pro State Bank sistēmā, nenozīmīga darbības pakāpe;</li>
                    <li>"logout" - lietotāja iziešana no Pro State Bank sistēmas, nenozīmīga darbības pakāpe;</li>
                    <li>"update_profile" - lietotāja profila informācijas rediģēšana, svarīga darbības pakāpe;</li>
                    <li>"update_account" - lietotāja konta rediģēšana, nozīmīga darbības pakāpe;</li>
                    <li>"update_password" - lietotāja paroles maiņa, svarīga darbības pakāpe;</li>
                    <li>"transaction" - lietotāja maksājuma veikšana, nenozīmīga darbības pakāpe;</li>
                    <li>"create_account" - jauna konta izveide, nozīmīga darbības pakāpe;</li>
                    <li>"create_request" - jauna ziņojuma izveide administratoriem.</li>
                </ul>
                <p>Uzklikšķinot uz darbības veicēja vārdu un uzvārdu, administratoram ir iespēja apindent-listatīt profila informāciju un profilam visus piederošos kontus.</p>
            </div>
        </div>
    </div>
</main>
<script>
    const questionContainers = document.querySelectorAll('.faq-item-header');
    const answers = document.querySelectorAll('.faq-content');
    let activeAnswer = answers[0];

    questionContainers.forEach((container, index) => {
        container.addEventListener('click', () => {
            const answer = answers[index];

            if (answer.classList.contains('visible')) {
                answer.classList.remove('visible');
                activeAnswer = null;
            } else {
                answers.forEach(a => {
                    a.classList.remove('visible');
                });
                answer.classList.add('visible');
                activeAnswer = answer;
            }
        });
    });
</script>
<?php
include_once("blocks/footer.phtml");