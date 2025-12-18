/**
 * UI Helper Utilities
 * Handles visual feedback and table interactions
 */

// 1. Show Bootstrap Alerts (Toasts)
function showMessage(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container');
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

// 2. Toggle between "Text Mode" and "Edit Mode" for a row
function toggleRowMode(id, isEditMode) {
    const row = document.getElementById('row-' + id);
    
    // Toggle Buttons
    row.querySelector('.edit-btn').style.display = isEditMode ? 'none' : 'inline-block';
    row.querySelector('.delete-btn').style.display = isEditMode ? 'none' : 'inline-block';
    row.querySelector('.save-btn').style.display = isEditMode ? 'inline-block' : 'none';
    row.querySelector('.cancel-btn').style.display = isEditMode ? 'inline-block' : 'none';
}

// 3. Store original values globally for the Cancel function
let originalValues = {};

function editRow(id) {
    const row = document.getElementById('row-' + id);
    const cells = row.querySelectorAll('.editable-cell');
    
    originalValues[id] = {};
    
    cells.forEach(cell => {
        const field = cell.dataset.field;
        let value = cell.textContent.trim();
        
        if (field === 'price') value = value.replace('$', '');
        
        originalValues[id][field] = value;
        
        // Transform cell into an input
        const inputType = field === 'price' ? 'number' : 'text';
        cell.innerHTML = `<input type="${inputType}" step="0.01" class="form-control form-control-sm" value="${value}" data-field="${field}">`;
    });
    
    toggleRowMode(id, true);
}

function cancelEdit(id) {
    const row = document.getElementById('row-' + id);
    const cells = row.querySelectorAll('.editable-cell');
    
    cells.forEach(cell => {
        const field = cell.dataset.field;
        const value = originalValues[id][field];
        cell.textContent = (field === 'price') ? '$' + value : value;
    });
    
    toggleRowMode(id, false);
    delete originalValues[id];
}