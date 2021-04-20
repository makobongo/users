<!doctype html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chit Form</title>
</head><body>

    <style>
        label{
            display: inline-block;
            margin-right: 5px;
        }
        .bordered {
            border-bottom: 1px solid #ddd;
        }
        body {
            width: 100%;
            margin-right:20px;
        }
        .row {
            width: 100%;
            display: block;
        }
        .row:after {
            clear: both;
        }
        .row p {
            display: inline-block;
            font-size: 14px;
            line-height: 1.2;
            margin-top: 0;
            margin-bottom: 0;
            margin-right: 5px;
        }
        .content .row p {
            line-height: 2;
        }
        .sub-total {
            text-align: right;
            font-size: 12px;
            font-weight: 500;
            padding-right: 10%;
        }
        .total {
            text-align: right;
            font-size: 14px;
        }
        .grand-total {
            text-align: right;
            font-size: 17px;
            font-weight: 700;
            padding: 7px 5px;
            border-top: 1px solid #aaa;
            border-bottom: 1px solid #aaa;
        }
        .grand-total strong {
            padding-left: 50%;
        }
        .dotted {
            padding-bottom: 5px;
            border-bottom: 1px dotted #333;
        }
    </style>

    <header>
        <center>
            <h2 class="bordered">{{ config('practice.name') }}</h2>
            <h4>{{ ucwords($chit->category) }} Chit</h4>
        </center>
    </header>

    <div class="row">
        <label for="" style="width: 10%">Name:</label>
        <p class="dotted" style="width: 25%">{{ $chit->employee->profile->full_name }}&nbsp;</p>
        <label for="" style="width: 10%">ID No:</label>
        <p class="dotted" style="width: 15%">{{ $chit->employee->profile->id_number }} &nbsp;</p>
        <label for="" style="width: 10%">Date:</label>
        <p class="dotted" style="width: 20%">{{ date('d/m/Y') }}&nbsp;</p>
    </div>
    <br/>

    <div class="row">
        <label for="" style="width: 10%">Age:</label>
        <p class="dotted" style="width: 25%">{{ $chit->employee->profile->age }}&nbsp;</p>
        <label for="" style="width: 15%">CheckRoll No:</label>
        <p class="dotted" style="width: 15%">{{ $chit->employee->profile->roll_no }}&nbsp;</p>
    </div>
    <br/>

    <div class="content">
        The above named was attended at our clinic and diagnosed to have a medical condition.
        Please allow <strong>{{ ucwords($chit->category) }} for {{ ucwords($chit->duration_friendly) }}</strong>
        <br/>
        <br/>
        Review on <strong>{{ $chit->created_at }}</strong>
        <br/>
        <br/>
        <div class="row">
            <label for="" style="width: 30%">Name of User:</label>
            <p class="dotted" style="width: 30%">{{ $chit->user->profile->full_name }}</p>
        </div>
        <div class="row">
            <label for="" style="width: 30%">Signature:</label>
            <p class="dotted" style="width: 30%">&nbsp;</p>
        </div>

    </div>
    <!-- ./content -->
</body></html>