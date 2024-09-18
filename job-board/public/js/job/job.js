document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchJob');
    const filterType = document.getElementById('filterType');
    const filterLocation = document.getElementById('filterLocation');
    const jobCards = document.querySelectorAll('.job-card');


    function filterJobs() {
        const searchText = searchInput.value.toLowerCase();
        const selectedType = filterType.value;
        const selectedLocation = filterLocation.value;

        jobCards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const location = card.querySelector('.location').textContent.toLowerCase();
            const jobType = card.querySelector('.type').textContent.toLowerCase();

            const matchesSearch = title.includes(searchText);
            const matchesType = selectedType === '' || jobType.includes(selectedType);
            const matchesLocation = selectedLocation === '' || location.includes(selectedLocation);

            if (matchesSearch && matchesType && matchesLocation) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterJobs);
    filterType.addEventListener('change', filterJobs);
    filterLocation.addEventListener('change', filterJobs);
});





