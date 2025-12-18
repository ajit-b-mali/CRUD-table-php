// Store original values for cancel functionality, can edit multiple fields
let originalValues = {};

function editRow(id) {
    const row = document.getElementById('row-' + id);
    const cells = row.querySelectorAll('.editable-cell');

    // Store original values
    originalValues[id] = {};

    cells.forEach(cell => {
        const field = cell.dataset.field;
        let value = cell.textContent.trim();

        // Remove $ sign from price
        if (field === 'price') {
            value = value.replace('$', '');
        }

        originalValues[id][field] = value;

        // Replace cell content with input field
        if (field === 'price') {
            cell.innerHTML = `<input type="number" step="0.01" class="form-control form-control-sm" value="${value}" data-field="${field}">`;
        } else {
            cell.innerHTML = `<input type="text" class="form-control form-control-sm" value="${value}" data-field="${field}">`;
        }
    });

    // Toggle buttons
    row.querySelector('.edit-btn').style.display = 'none';
    row.querySelector('.save-btn').style.display = 'inline-block';
    row.querySelector('.cancel-btn').style.display = 'inline-block';
    row.querySelector('.delete-btn').style.display = 'none';
}

function cancelEdit(id) {
    const row = document.getElementById('row-' + id);
    const cells = row.querySelectorAll('.editable-cell');

    // Restore original values
    cells.forEach(cell => {
        const field = cell.dataset.field;
        const value = originalValues[id][field];

        if (field === 'price') {
            cell.textContent = '$' + value;
        } else {
            cell.textContent = value;
        }
    });

    // Toggle buttons back
    row.querySelector('.edit-btn').style.display = 'inline-block';
    row.querySelector('.save-btn').style.display = 'none';
    row.querySelector('.cancel-btn').style.display = 'none';
    row.querySelector('.delete-btn').style.display = 'inline-block';

    delete originalValues[id];
}

function saveRow(id) {
    const row = document.getElementById('row-' + id);
    const inputs = row.querySelectorAll('.editable-cell input');

    // Collect updated values
    const data = { id: id };
    inputs.forEach(input => {
        data[input.dataset.field] = input.value;
    });

    // Send AJAX request
    fetch('includes/update.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Update cells with new values
                inputs.forEach(input => {
                    const cell = input.parentElement;
                    const field = input.dataset.field;
                    const value = input.value;

                    if (field === 'price') {
                        cell.textContent = '$' + value;
                    } else {
                        cell.textContent = value;
                    }
                });

                // Toggle buttons back
                row.querySelector('.edit-btn').style.display = 'inline-block';
                row.querySelector('.save-btn').style.display = 'none';
                row.querySelector('.cancel-btn').style.display = 'none';
                row.querySelector('.delete-btn').style.display = 'inline-block';

                delete originalValues[id];

                // Show success message
                refreshChart();
                showMessage('Product updated successfully!', 'success');
            } else {
                showMessage('Error updating product: ' + result.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error updating product. Please try again.', 'danger');
        });
}