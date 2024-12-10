<!DOCTYPE html>
<html>
<head>
    <title>Statistiques Étudiants</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 45%;
            margin: 10px;
            float: left;
        }
    </style>
</head>
<body>


    <div class="chart-container">
        <canvas id="histogramChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="pieChart"></canvas>
    </div>

    <?php
    // Traitement PHP lors de la soumission du formulaire
  
        // Simulation de données (à remplacer par vos propres données)
        $maleStudentsCount = 30;
        $femaleStudentsCount = 20;

        echo "<script>
            var ctxHistogram = document.getElementById('histogramChart').getContext('2d');
            var histogramChart = new Chart(ctxHistogram, {
                type: 'bar',
                data: {
                    labels: ['Masculin', 'Féminin'],
                    datasets: [{
                        label: 'Nombre d\'étudiants par sexe',
                        data: [$maleStudentsCount, $femaleStudentsCount],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 99, 132, 0.5)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>";

        $totalStudents = $maleStudentsCount + $femaleStudentsCount;
        $malePercentage = ($maleStudentsCount / $totalStudents) * 100;
        $femalePercentage = ($femaleStudentsCount / $totalStudents) * 100;

        echo "<script>
            var ctxPie = document.getElementById('pieChart').getContext('2d');
            var pieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Masculin', 'Féminin'],
                    datasets: [{
                        label: 'Proportion d\'étudiants par sexe',
                        data: [$malePercentage, $femalePercentage],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 99, 132, 0.5)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>";

    ?>
</body>
</html>
