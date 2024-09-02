import './bootstrap';
import '../css/app.css';

document.addEventListener('DOMContentLoaded', () => {
    const manufacturerFilter = document.getElementById('manufacturer');
    const typeFilter = document.getElementById('type');
    const productsContainer = document.getElementById('products');
    const cartItems = document.getElementById('cart-items');
    const totalPriceElement = document.getElementById('total-price');
    let cart = [];
    
    function fetchProducts() {
        // Ovo je primjer funkcije. Trebali biste zamijeniti ovo s API pozivom za dohvat stvarnih podataka
        return [
            { id: 1, name: 'Lijek 1', description: 'Opis lijeka 1', image: 'path/to/image1.jpg', price: 100, manufacturer: 'Bosnalijek', type: 'tableta' },
            { id: 2, name: 'Lijek 2', description: 'Opis lijeka 2', image: 'path/to/image2.jpg', price: 150, manufacturer: 'Farmavita', type: 'sirup' },
            // Dodajte ostale lijekove
        ];
    }

    function renderProducts(products) {
        productsContainer.innerHTML = '';
        products.forEach(product => {
            const productDiv = document.createElement('div');
            productDiv.classList.add('bg-white', 'p-4', 'rounded-lg', 'shadow-md');
            productDiv.innerHTML = `
                <img src="${product.image}" alt="${product.name}" class="w-full h-32 object-cover rounded-md mb-2">
                <h2 class="text-xl font-bold">${product.name}</h2>
                <p class="text-gray-600">${product.description}</p>
                <div class="flex justify-between items-center mt-2">
                    <span class="bg-green-100 text-black py-1 px-2 rounded-md">${product.price} KM</span>
                    <button class="add-to-cart bg-blue-500 text-white py-1 px-2 rounded-md hover:bg-blue-600" data-id="${product.id}" data-price="${product.price}">Dodaj u košaricu</button>
                </div>
            `;
            productsContainer.appendChild(productDiv);
        });

        // Dodaj event listener za sve dugme "Dodaj u košaricu"
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', (e) => {
                const productId = e.target.getAttribute('data-id');
                const productPrice = parseFloat(e.target.getAttribute('data-price'));
                addToCart(productId, productPrice);
            });
        });
    }

    function addToCart(id, price) {
        // Ovdje možeš dodati proizvod u košaricu i ažurirati prikaz košarice
        cart.push({ id, price });
        updateCart();
    }

    function updateCart() {
        cartItems.innerHTML = '';
        let totalPrice = 0;
        cart.forEach(item => {
            totalPrice += item.price;
            const itemElement = document.createElement('li');
            itemElement.textContent = `Proizvod ID: ${item.id} - Cijena: ${item.price} KM`;
            cartItems.appendChild(itemElement);
        });
        totalPriceElement.textContent = totalPrice.toFixed(2);
    }

    // Primjer inicijalnog prikaza proizvoda
    const products = fetchProducts();
    renderProducts(products);
    
    // Filteri
    manufacturerFilter.addEventListener('change', () => {
        // Filtriraj proizvode prema proizvođaču
        const selectedManufacturer = manufacturerFilter.value;
        const filteredProducts = products.filter(p => selectedManufacturer === 'all' || p.manufacturer === selectedManufacturer);
        renderProducts(filteredProducts);
    });

    typeFilter.addEventListener('change', () => {
        // Filtriraj proizvode prema vrsti
        const selectedType = typeFilter.value;
        const filteredProducts = products.filter(p => selectedType === 'all' || p.type === selectedType);
        renderProducts(filteredProducts);
    });
});
