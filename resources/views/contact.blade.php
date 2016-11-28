@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <style>
        .header{
            background: url("/images/background3.jpg")!important;
            height: 900px!important;
        }
    </style>
                    <div class="ticket-content">
                        <h1>Contact</h1>
                        <form>
                            <table>
                                <tr>
                                    <td><input type="text" placeholder="Naam"></td>
                                </tr>
                                <tr>
                                    <td><input type="email" placeholder="Emailadres"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" placeholder="Onderwerp"</td>
                                </tr>
                                <tr>
                                    <td><textarea rows="5" cols="50" placeholder="Bericht"></textarea></td>
                                </tr>
                                <tr>
                                    <td><input type="submit" class="submitregistration" value="Verzenden" name="verzenden"</td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="clear"></div>
@endsection
