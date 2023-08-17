<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        html,
        body,
        .intro {
            height: 100%;
        }

        .gradient-custom-2 {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to top, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to top, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }

        table td,
        table th {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        thead th,
        tbody th {
            color: #fff;
        }

        tbody td {
            font-weight: 500;
            color: rgba(255, 255, 255, .65);
        }
    </style>
</head>

<body>
    <section class="intro">
        <div class="gradient-custom-2 h-100">
            <div class="mask d-flex align-items-center h-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-dark table-bordered mb-0" id="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Registered date</th>
                                            <th scope="col">Number of referred users</th>
                                            <th scope="col">Total Point</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <th scope="row">{{ $user->name }}</th>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->created_at }}</td>
                                                <td>{{ $user->numberOfUserRegistered }}</td>
                                                <td>{{ $user->userPoint->point }}</td>
                                                <td><a href="/userTree/{{ $user->id }}">Show Detail</a></td>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="card" style="height:200px;width:200px">
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="card" style="height:200px;width:200px">
                            <canvas id="myChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script>
    $(document).ready(function() {
        var table = $('#table').DataTable();
    });
</script>

<script type="text/javascript">

    const data = {
        labels: {{ Js::from($labels) }},
        datasets: [{
            label: 'System overview',
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
            ],
            data: {{ Js::from($chartData) }},
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>

<script type="text/javascript">
    const data2 = {
        labels: {{ Js::from($labels2) }},
        datasets: [{
            label: 'System overview',
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
            ],
            data: {{ Js::from($chartData2) }},
        }]
    };

    const config2 = {
        type: 'doughnut',
        data: data2,
    };

    const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
    );
</script>
