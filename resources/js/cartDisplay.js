// resources/js/cartDisplay.js

document.addEventListener('DOMContentLoaded', () => {
    const cartButton = document.querySelector('#cart-button');
    const cartContainer = document.querySelector('#cart-container');
  
    if (cartButton) {
      cartButton.addEventListener('click', async () => {
        try {
          const response = await fetch('/cart');
          const result = await response.json();
  
          if (result.items.length > 0) {
            let html = result.items.map(item => `
              <div class="cart-item">
                <img src="${item.image}" alt="${item.name}" />
                <p>${item.name}</p>
                <p>${item.price} €</p>
                <p>Quantity: ${item.quantity}</p>
                <button class="remove-from-cart" data-product-id="${item.id}">Remove</button>
              </div>
            `).join('');
  
            html += `<h2>Total: ${result.total} €</h2>`;
            cartContainer.innerHTML = html;
  
            // Add remove item functionality
            const removeButtons = document.querySelectorAll('.remove-from-cart');
            removeButtons.forEach(button => {
              button.addEventListener('click', async (event) => {
                const productId = button.dataset.productId;
                try {
                  const response = await fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ product_id: productId })
                  });
  
                  const result = await response.json();
                  alert(result.message);
                  // Refresh cart display
                  cartButton.click();
                } catch (error) {
                  console.error('Error removing from cart:', error);
                }
              });
            });
          } else {
            cartContainer.innerHTML = '<p>Your cart is empty</p>';
          }
        } catch (error) {
          console.error('Error fetching cart:', error);
        }
      });
    }
  });
  