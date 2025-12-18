function saveRow(id) {
    const row = document.getElementById('row-' + id);
    const inputs = row.querySelectorAll('.editable-cell input');
    
    const data = { id: id };
    inputs.forEach(input => data[input.dataset.field] = input.value);

    fetch('includes/update.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if (result.success) {
            // Use helpers to reset the UI
            inputs.forEach(input => {
                const cell = input.parentElement;
                cell.textContent = (input.dataset.field === 'price') ? '$' + input.value : input.value;
            });
            toggleRowMode(id, false);
            refreshChart(); // Trigger chart update
            showMessage('Updated!', 'success');
        } else {
            showMessage(result.message, 'danger');
        }
    });
}