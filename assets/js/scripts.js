document.getElementById('productForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('index.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        updateTable(data);
    })
    .catch(error => {
        console.error('Fetch failed:', error);
        alert('An error occurred.' + error.message);
    });
});

function updateTable(data) {
    const tablebody = document.getElementById('dataTable');
    tablebody.innerHTML = '';

    let totalSum = 0;

    data.forEach(row => {
        totalSum += row.totalValue;
        const rowElement = `<tr>
            <td>${row.productName}</td>
            <td>${row.quantity}</td>
            <td>${row.price}</td>
            <td>${row.datetime}</td>
            <td>${row.totalValue}</td>
        </tr>`;
        tablebody.innerHTML += rowElement;
    });

    const totalRow = `<tr>
        <td colspan="4"><strong>Grand Total</strong></td>
        <td>${totalSum}</td>
    </tr>`;
    tablebody.innerHTML += totalRow;
}