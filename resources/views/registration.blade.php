<form method="post" action="">

        <h1>Registreren</h1>
                <div id="registration1" class="ticket-content">
                        <table class="registrationtable">
                            <tr>
                                <td><input type="text" name="email" value="<?php if(isset($_POST['aanmelden'])){ echo $_POST['email']; } ?>" required ></td>
                                <td><input type="text" name="name" value="<?php if(isset($_POST['aanmelden'])){ echo $_POST['name']; } ?>" required ></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="vestiging" maxlength="5" placeholder="Leerlingnummer" ></td>
                                <td><input type="text" name="donatie" placeholder="Bedrag donatie (niet verplicht)" ></td>
                            </tr>
							<tr>
								<td><div id="next" class="nextbutton" name="next">Volgende <div class="icon-large"></div></div></td>
								<td></td>
                        </table>
                </div>
                <div id="registration2" class="ticket-content">
                        <table class="registrationtable">
                            <tr>
                                <td><label><input type="radio" name="ticket" value="regular" required /><div class="ticket"><img src="/images/concert-ticketgold.svg" alt="regular" /><div class="ticketinfo">Regular ticket: <br /> Dit is het normale entree bewijs.<br /><br /><br /><b>Prijs: </b> Gratis</div></div></label></td>
                                <td><label><input type="radio" name="ticket" value="food" required /><div class="ticket"><img src="/images/concert-ticketgold plus.svg" alt="food" /><div class="ticketinfo">Food ticket: <br /><br /> Dit is het entree bewijs inclusief te eten.<br /><br /><b>Prijs: </b> &euro; 2,-</div></div></label></td>
                                <td><label><input type="radio" name="ticket" value="support" required /><div class="ticket"><img src="/images/concert-ticketgold plusplus.svg" alt="support" /><div class="ticketinfo">Support ticket: <br /><br /> Dit is het entree bewijs inclusief te eten en goodies.<br /><br /><b>Prijs: </b> &euro; 5,-</div></div></label></td>
                            </tr>
							<tr>
								<td><p style="color: white; font-size: 24px;">competitie 1:</p>
									<select name="comp1">
										<option value="none">Geen</option>
										<option value="hs">Heartstone</option>
										<option value="lol">League of Ledgends</option>
										<option value="csgo">Counter strike: Global Offence</option>
										<option value="rl">Rocket League</option>
										<option value="rss">Rainbow Six Siege</option>
										<option value="ozu">Ozu</option>
									</select>
								</td>
								<td><p style="color: white; font-size: 24px;">competitie 2:</p>
									<select name="comp2">
										<option value="none">Geen</option>
										<option value="hs">Heartstone</option>
										<option value="lol">League of Ledgends</option>
										<option value="csgo">Counter strike: Global Offence</option>
										<option value="rl">Rocket League</option>
										<option value="rss">Rainbow Six Siege</option>
										<option value="ozu">Ozu</option>
									</select name="comp3">
								</td>
								<td><p style="color: white; font-size: 24px;">competitie 3:</p>
									<select name="comp3">
										<option value="none">Geen</option>
										<option value="hs">Heartstone</option>
										<option value="lol">League of Ledgends</option>
										<option value="csgo">Counter strike: Global Offence</option>
										<option value="rl">Rocket League</option>
										<option value="rss">Rainbow Six Siege</option>
										<option value="ozu">Ozu</option>
									</select>
								</td>
							</tr>
                            <tr style="margin-top: 50px;">
                                <td><div id="back" class="nextbutton" name="next">Vorige <div class="icon-large-left"></div></div></td>
                                <td></td>
                                <td><button class="nextbutton" type="submit" name="aanmeldenDone">Aanmelden</button></td>
                            </tr>
                        </table>
                </div>
    </form>

<div class="clear">

</div>
<script type="text/javascript">
    $('#registration2').hide();

    var cur = 1;
    var max = $(".ticket-content").length;

    $("#next").click(function(){
        $('#registration1').hide();
        $('#registration2').fadeIn();
    });

    $("#back").click(function(){
        $('#registration2').hide();
        $('#registration1').fadeIn();
    });
</script>