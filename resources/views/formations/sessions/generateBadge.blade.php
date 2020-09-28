<!DOCTYPE html>
<html lang="en" style="box-sizing: border-box">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <link rel="stylesheet" href="vendor/adminlte/dist/css/adminlte.min.css">
    <title>{{ ucwords($data['formationTitle']) . ' - Promotion n°' . $data['promotion'] . ' - Badges' }}</title>
    <script type="text/javascript"> alert('js');
        // const year = (new Date).getFullYear();
        // const yearElement = document.getElementById("year");
        // yearElement.innerHTML = `${year} ${year}`;
    </script>
</head>
<body>
    
    @foreach ($data['students'] as $pages)
        @php 
            $i = 0;
        @endphp
        <div style="position: relative;">
            @foreach ($pages as $student)

                <div style="outline: 0.03cm solid #242424; height: 6cm; width: 10cm; margin: 20px 0px; position: absolute; top: {{ $i }}cm; @if (($loop->index) % 2 === 0) left: -1cm @else right: -1cm @endif">
                    <div style="position: relative;">
                        <img src="images/badges/background-badge.jpg" style="position : absolute; z-index: 0; width: 5cm; height: 6cm">
                        <img src="{{ 'storage/' . $student['photo'] }}" style="border-radius: 1cm; position: absolute; top: 0.75cm; left: 0.5cm; z-index: 10; border: 2px solid #eee; width: 2cm; height: 2cm" >
                        <img src="images/badges/logo-neitic.jpg" style="position: absolute; top: 50px; left: 40%; width: 2cm">
                        <div style="position: relative; z-index: 10; color: white;  top: 4cm; width: 5.5cm;">
                            <h1 style="font-size: 0.2cm; text-transform: uppercase; text-align: left; margin-left: 0.5cm">{{ $student['lname'] }}</h1>
                            <h1 style="font-size: 0.2cm; text-transform: capitalize; text-align: left; margin-left: 0.5cm">{{ $student['fname'] }}</h1>
                        </div>
                        <div style="position: relative; width: 50%; z-index: 10; top: -0.75cm; float: right;">
                            <h1 style="letter-spacing: 10px; font-size: 0.25cm; font-weight: bold">FORMATION</h1>
                            <h2 style="font-size: 0.3cm; letter-spacing: 0.1cm; text-transform: capitalize">{{ $data['formationTitle'] }}</h2>

                            <h3 style="text-align: right; margin-right: 0.5cm; font-size: 0.25cm; color: rgb(99, 98, 98); margin-top: 0.2cm">Promotion</h3>
                            <h4 style="text-align: right; margin-right: 0.5cm; font-size: 0.3cm; margin-bottom: 10px; margin-top: -0.2cm">{{ $data['promotion'] }}{{ $data['promotion'] == 1 ? 'ère' : 'ème' }}</h4>
                            
                            <h3 style="text-align: right; margin-right: 0.5cm; font-size: 0.25cm; color: rgb(99, 98, 98)">Début & Fin</h3>
                            <h4 style="text-align: right; margin-right: 0.5cm; font-size: 0.3cm; margin-bottom: 10px; margin-top: -0.2cm">
                                <span style="text-transform: capitalize">{{ $data['month_debut'] }}</span> - <span style="text-transform: capitalize">{{ $data['month_end'] }}</span>
                            </h4>
                            
                            <h3 style="text-align: right; margin-right: 0.5cm; font-size: 0.25cm; color: rgb(99, 98, 98)">Année</h3>
                            <h4 style="text-align: right; margin-right: 0.5cm; font-size: 0.3cm; margin-bottom: 10px; margin-top: -0.2cm" id="year">{{ $data['year'] }}</h4>

                            <div style="background: transparent; margin-left: auto; margin-right: 50px; width: 105%; margin-top: -0.2cm">
                                <h2 style="text-align: right; margin-right: 0.5cm; font-size: 0.3cm; color: rgb(73, 70, 70); text-align: center; margin-top: 0px 0px 5px 0px">https://www.neitic.com</h2>
                                <h3 style="text-align: right; margin-right: 0.5cm; font-size: 0.3cm; color: rgb(73, 70, 70); text-align: center; margin-top: 0px">Innovation - Qualité - Excellence</h3>
                                <h4 style="text-align: right; margin-right: 0.5cm; font-size: 0.3cm; color: rgb(39, 36, 36); text-align: center; margin-top: 0px">TEL : +261 34 18 768 05</h4>
                                <h4 style="text-align: right; margin-right: 0.5cm; font-size: 0.3cm; color: rgb(73, 70, 70); text-align: center; margin-top: 0px">GALERIE 9, Tsaralalana Analakely</h4>
                            </div>

                        </div>
                    </div>
                </div>
                @php
                    if (($loop->index + 1) % 2 === 0) $i += 7;
                @endphp
                
            @endforeach

        </div>
        @if (!$loop->last)
            <div style="page-break-before: always"></div>
        @endif

    @endforeach

</body>
</html>