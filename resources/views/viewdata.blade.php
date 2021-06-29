<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{asset('css/app.css')}} "> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h4>Fastest Asteroid</h4>
        <ul class="list-group">
        <li class="list-group-item "> {{"Id : ".$fastestAsteroidId . ", Name : ".$fastestAsteroidName.", Size : ".$fastestAsteroidSize.",  Speed : " . $fastestAsteroidSpeed}} km/hr</li>
        </ul>
    </div>
    <div class="container">
        <h4>Closest Asteroid</h4>
        <ul class="list-group">
          <li class="list-group-item">{{"Id : ".$closestAsteroidId . ",Name : ".$closestAsteroidName.", Size : ".$closestAsteroidSize.",  Distance : " . $closestAsteroidDistance}} km </li>
        </ul>
    </div>
    <div style="width: 1000px;height: 700px;" class="ml-5">
        <canvas id="myChart" width="800" height="400"></canvas>
    </div>


    <script src="{{asset('js/app.js')}} "></script>
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>

    <script>
        var asteriodsNumber = <?php  echo json_encode($finalAsteriodCount); ?>;
        var asteroidsDate = <?php  echo json_encode($givenDates); ?>;
        
        var chrt = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(chrt, {
            type: 'bar',
            data: {
                labels:asteroidsDate,
                //labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [
                    {
                        label: 'Asteroids',
                        // lineTension:1,
                        data: asteriodsNumber,
                        //data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: [
                            'rgba(192, 28, 50, 1)',
                            'rgba(118, 238, 66, 1)',
                            'rgba(68, 106, 167, 1)',
                            'rgba(37, 40, 45, 0.73)',
                            'rgba(168, 29, 100, 0.73)',
                            'rgba(28, 225, 221, 0.73)',
                            'rgba(23, 103, 28, 0.73)',


                        ],
                        // borderColor: [
                        //     'rgba(255, 99, 132, 1)',
                        //     'rgba(54, 162, 235, 1)',
                        //     'rgba(255, 206, 86, 1)',
                        //     'rgba(75, 192, 192, 1)',
                        //     'rgba(153, 102, 255, 1)',
                        //     'rgba(255, 159, 64, 1)'
                        // ],
                        // borderWidth: 3
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>
