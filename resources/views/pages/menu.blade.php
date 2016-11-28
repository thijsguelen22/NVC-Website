<div class="nav-bar">
    <a href="/"><img src="images/logo2.svg" alt="Nacht van Cuijk" width="150px" /></a>
    <ul>
        <a href="/">          <li {{( Request::segment('1') == ''           ? 'class=nav-bar-active' : '' )}} >Home</li></a>
        <a href="/competitie"><li {{( Request::segment('1') == 'competitie' ? 'class=nav-bar-active' : '' )}} >Competities</li></a>
        <a href="/contact">   <li {{( Request::segment('1') == 'contact'    ? 'class=nav-bar-active contact' : 'class=contact' )}} >Contact</li></a>
        <a href="/login">     <li {{( Request::segment('1') == 'login'      ? 'class=nav-bar-active login' : 'class=login' )}} >Inloggen</li></a>
    </ul>
</div>
