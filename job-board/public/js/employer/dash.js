document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('categoryChart').getContext('2d');
    var categoryChart = new Chart(ctx, {
        type: 'line', 
        data: {
            labels: categoryLabels,  
            datasets: [{
                label: 'Number of Jobs',
                data: categoryData, 
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
