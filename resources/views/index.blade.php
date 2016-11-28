<?php
function generate_title($apendix){



  $page  = ucfirst(str_replace('/','',$_SERVER['REQUEST_URI']));

  $title = $page.'&ensp;|&ensp;'.$apendix;

  return $title;



}
?>
<!DOCTYPE html>
<html lang="">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  <link href="/images/favicon.ico" rel="icon" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

  <title>Home | Nacht van Cuijk</title>
</head>
<script type="text/javascript">
  $(document).ready(function() {
    $(".quickticket").addClass("active");
  });
</script>
<?php
session_start();
$_SESSION['ovErr'] = $_SESSION['naamErr'] = $_SESSION['ticketErr'] = $_SESSION['compErr'] = $_SESSION['donatieErr'] = $_SESSION['Err'] = NULL;
?>
<body>
  <div id="container">
    <div id="wrapper">
      <div class="header">
        <div class="gradient-layer">
          @include('pages/menu')
          <div class="header-content">
            <div class="title-info">
              <h1>Nacht van Cuijk</h1>
              <p>
                Gamen doe je samen, in Cuijk!
                <br /> 7 Juli vanaf 17:00 bent u van harte welkom bij dit evenement,
                <br /> Dus meld u nu aan!
              </p>
            </div>
            <div class="quicklogin animated slideInDown" id="slidediv">
              <h2>Nu aanmelden</h2>
              <div class="loginlist">
                <form method="post" action="/registratie">
                  <table cellspacing="0">
                    <tr>
                      <td>
                        <input type="text" name="name" placeholder="Naam" required />
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <input type="numeric" maxlength="7" name="vestiging" placeholder="Leerlingnummer" required />
                      </td>
                    </tr>
                  </table>
              </div>
              <input type="submit" name="aanmelden" value="Aanmelden" />
              </form>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
      @include('pages/footer')
    </div>
  </div>
</body>
