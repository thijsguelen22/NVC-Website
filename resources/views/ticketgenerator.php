@extends('layouts.main')

@section('title', 'Login')

@section('content')
	<style>
		.header {
			background: url("/images/background3.jpg")!important;
		}
        .header-content{
            width: 1100px!important;
        }
	</style>
                    <div>
                        <table>
                            <tr>
                                <td>
                                    <select>
                                        <option>competitive game 1</option>
                                        <option>competitive game 2</option>
                                        <option>competitive game 3</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <h1>Competitive game 1</h1>
                        <div style="height: 600px!important; overflow: hidden; pointer-events:none;">
						    <iframe src="http://challonge.com/nvcrl/module?theme=3989" width="900" height="20000" frameborder="0" scrolling="none" allowtransparency="true"></iframe>
                         </div>
                    </div>
    <div class="clear">

    </div>
    <script>
        $( document ).ready(function() {
            var $head = $("iframe").contents().find("head");
            console.log($("iframe").contents());
            $head.append($("<link/>",
                    { rel: "stylesheet", href: "http://37.139.12.99/style/iframe.css", type: "text/css" }));
        });
    </script>
@endsection