document.addEventListener('DOMContentLoaded', () => {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
  
    addToCartButtons.forEach(button => {
      button.addEventListener('click', async (event) => {
        const productId = button.dataset.productId;
        try {
          const response = await fetch('/cart/add', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
          });
  
          const result = await response.json();
          alert(result.message);
  
          // For debugging
          console.log(result);
        } catch (error) {
          console.error('Error adding to cart:', error);
        }
      });
    });
  });
  