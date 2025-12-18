function deleteProduct(id) {
    if (!confirm('Are you sure you want to delete this product?')) return;

    fetch('includes/delete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            // 1. Remove the row from the table smoothly
            const row = document.getElementById('row-' + id);
            row.remove();

            // 2. Refresh the chart so the category counts update
            refreshChart(); 
            showMessage('Product deleted successfully!', 'success');
        } else {
            showMessage('Error: ' + result.message, 'danger');
        }
    })
    .catch(error => console.error('Error:', error));
}