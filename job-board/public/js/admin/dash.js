document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('userChart').getContext('2d');
    var userChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Users', 'Admin', 'Candidate', 'Employer', 'Jobs'],  // إضافة 'Jobs' إلى الـ labels
            datasets: [{
                label: 'Users & Jobs',
                data: [newUsers, adminCount, candidateCount, employerCount, jobCount],  // إضافة jobCount إلى البيانات
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Users & Jobs' 
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Roles & Jobs' 
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Role/Job: ' + context.label + ' - Number: ' + context.raw;
                        }
                    }
                }
            }
        }
    });
});
