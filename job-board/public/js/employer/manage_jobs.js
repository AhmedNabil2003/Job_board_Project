document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchJob');
    const filterType = document.getElementById('filterType');
    const filterStatus = document.getElementById('filterStatus');
    const tableRows = document.querySelectorAll('#jobsTable tbody tr');

    const filterTable = () => {
        const searchQuery = searchInput.value.toLowerCase();
        const selectedType = filterType.value.toLowerCase();
        const selectedStatus = filterStatus.value.toLowerCase();

        tableRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const id = cells[0].textContent.toLowerCase().trim();  
            const title = cells[1].textContent.toLowerCase().trim(); 
            const location = cells[2].textContent.toLowerCase().trim();  
            const jobType = cells[3].textContent.toLowerCase().trim();  
            const jobStatus = cells[4].querySelector('.badge')
                ? cells[4].querySelector('.badge').textContent.toLowerCase().trim()  
                : cells[4].textContent.toLowerCase().trim();  

          
            const matchesSearch = id.includes(searchQuery) || 
                                  title.includes(searchQuery) || 
                                  location.includes(searchQuery);

         
            const matchesType = !selectedType || jobType === selectedType;
            const matchesStatus = !selectedStatus || jobStatus === selectedStatus;

         
            row.style.display = (matchesSearch && matchesType && matchesStatus) ? '' : 'none';
        });
    };

  
    searchInput.addEventListener('input', filterTable);
    filterType.addEventListener('change', filterTable);
    filterStatus.addEventListener('change', filterTable);
});

