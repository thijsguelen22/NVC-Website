<?php
function generate_title($apendix){



    $page  = ucfirst(str_replace('/','',$_SERVER['REQUEST_URI']));
if(empty($page)){
    $page = 'Home';
}
    $title = $page.'&ensp;|&ensp;'.$apendix;

    echo $title;



}
?>
<!DOCTYPE html>
<html lang="">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="De Nacht van Cuijk is een LAN evenement. Dit is een Game nacht met leerlingen, oud- en nieuw-leerlingen. Ook leerlingen en ouders van zijn welkom bij dit evenement!" />
    <meta name="keywords" content="Nacht, van, Cuijk, ROC, de, Leijgraaf, competitie, aanmelden, inloggen, Kay Smits, Jesse van den Ijssel, Arno van Kessel, Dewin Jansen " />
    <meta name="author" content="Genius Library, Janin Developer">
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index" />
    <meta name="revisit-after" content="1 day" />
    <meta name="title" content="Nacht van Cuijk" />
    <meta charset="UTF-8">


    <meta property="og:url" content="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Nacht van Cuijk" />
    <meta property="og:description" content="De Nacht van Cuijk is een LAN evenement. Dit is een Game nacht met leerlingen, oud- en nieuw-leerlingen. Ook leerlingen en ouders van zijn welkom bij dit evenement!" />
    <meta property="og:image" content="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/images/fbbackground.png'; ?>" />


    <link href="style/style.css" type="text/css" rel="stylesheet" />
    <link href="images/favicon.ico" rel="icon" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <title>{{ ucfirst(Request::segment('1')) }} | Nacht van Cuijk</title>
</head>
<script type="text/javascript">
    $(document).ready(function() {
        $(".quickticket").addClass("active");
    });
</script>

<body>
<div id="container">
    <div id="wrapper">
        <div class="header registration-background">
            <div class="gradient-layer">
                @include('pages/menu')
                <div class="header-content">
                    @yield('content')
                </div>
            </div>
        </div>

        @include('pages/footer')
    </div>
</div>
</body>