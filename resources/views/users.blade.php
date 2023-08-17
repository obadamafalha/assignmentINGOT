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

</head>

<body style="background-color: #eee;">
    <section>
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="/users/{{ $user->id }}">User Profile</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="/userTree/{{ $user->id }}">Show
                                    the Tree</a></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="{{ asset($user->image) }}" alt="avatar" class="rounded-circle img-fluid"
                                style="width: 200px; height: 200px;">
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <p class="mb-2 ">Number of visitors</p>
                                </div>
                                <div class="col">
                                    <p class="text-muted mb-2 text-center">{{ $user->numberOfUserVisited }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p class="mb-2 ">Total Point</p>
                                </div>
                                <div class="col">
                                    <p class="text-muted mb-2 text-center">{{ $user->userPoint->point }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card lg-8">
                        <canvas id="myChart" height="100px"></canvas>

                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->email }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Phone</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->phone }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Birthday</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->birthdate }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">referralLink</p>
                                </div>
                                <div class="col-sm-9">
                                    <a class="text-muted mb-0"
                                        href="{{ $user->referralLink }}">{{ $user->referralLink }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <p class="mb-4">Users list that registered through your referral link</p>
                                    <table class="table table-hover" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone Number</th>
                                                <th scope="col">Total Point</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $data2)
                                                <tr>
                                                    <td>{{ $data2->name }}</td>
                                                    <td>{{ $data2->email }}</td>
                                                    <td>{{ $data2->phone }}</td>
                                                    <td>{{ $data2->userPoint->point }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
    var labels = {{ Js::from($labels) }};
    var users = {{ Js::from($chartData) }};

    const data = {
        labels: labels,
        datasets: [{
            label: 'The Daily Chart Of Number Of Registered Users',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: users,
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {}
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
