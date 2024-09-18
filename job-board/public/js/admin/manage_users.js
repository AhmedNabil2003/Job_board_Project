$(document).ready(function() {
    $('#searchUser').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();
        $('#usersTable tbody tr').each(function() {
            var row = $(this);
            var id = row.find('td:nth-child(1)').text().toLowerCase(); 
            var name = row.find('td:nth-child(2)').text().toLowerCase(); 
        
            if (id.indexOf(searchTerm) !== -1 || name.indexOf(searchTerm) !== -1 || searchTerm === '') {
                row.show();
            } else {
                row.hide();
            }
        });
    });
});


 document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (form.querySelector('[name="confirm"]') && !confirm('Are you sure?')) {
                event.preventDefault();
            }
        });
    });

    var formModified = false;
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('change', function() {
            formModified = true;
        });
    });

    document.querySelectorAll('.modal').forEach(function(modal) {
        modal.addEventListener('hide.bs.modal', function (event) {
            if (formModified) {
                if (!confirm('You have unsaved changes. Are you sure you want to leave?')) {
                    event.preventDefault();
                }
            }
        });
    });

