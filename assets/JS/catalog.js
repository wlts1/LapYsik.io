async function fetchProducts(page = 1) {
    const productType = document.getElementById('productType').value;
    const response = await fetch(`assets/php/fetch_products.php?productType=${productType}&page=${page}`);
    const products = await response.text();
    document.getElementById('products').innerHTML = products;
}

async function addToCart(productId) {
    const response = await fetch('assets/php/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'action': 'add',
            'productId': productId
        })
    });

    const result = await response.text();
    alert(result);
}
