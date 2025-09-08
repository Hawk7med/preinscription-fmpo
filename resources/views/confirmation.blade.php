@extends('layout')
@section('style')
    <style>
        #label_moyenne, #moyennes{
            display: flex;
        }
        #division{
            display: flex;
            flex-direction: column;
            text-align: center;
            margin-top: -7px;
        }
        #division hr{
            margin: 1px;
        }
        #formConfirmation{
            width: 50%;
            margin: 100px auto;
            background: #fff3cd;
            color: #664d03;
            padding: 30px;
            border-radius: 9px;
            box-shadow: 0px 0px 5px lightgrey;
            border: 1px solid #664d033b;
        }
        #formConfirmation button{
            float: right;
        }
        #formConfirmation strong{
            font-size: 20px!important;
            margin-bottom: 10px!important;
            display: block;
        }
        #formConfirmation p{
            text-align: justify;
            margin-bottom: 50px;
        }
    </style>
@endsection
@section('content')
    <form id="formConfirmation" action="{{ route('confirmed_preregistration') }}" method="POST">
        @csrf
        <div class="alert-warning">
            <strong><span class="fa fa-warning"></span> Important:</strong>
            <p>Conformément à la loi 09-08 relative à la protection des données personnelles et à la réglementation de la CNDP, nous vous informons que vos données pourront être collectées, traitées et conservées dans le respect des finalités déclarées.
En cliquant sur « Continuer », vous reconnaissez avoir pris connaissance de cette information et acceptez que vos données soient utilisées conformément à la loi 09-08.</p>
            <input type="hidden" name="confirmed" value="true">
            <button type="submit" class="btn btn-primary">
                <span class="fa fa-save"></span> Continuer
            </button>
        </div>
    </form>
@endsection