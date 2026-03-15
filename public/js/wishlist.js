function toggleWishlist(productId, button) {
    // Check if user is logged in by checking if auth user menu exists
    const isLoggedIn = document.querySelector('[x-data*="open"]') !== null;
    
    if (!isLoggedIn) {
        Swal.fire({
            title: 'Login Required',
            text: 'Please login to add items to your wishlist',
            icon: 'info',
            confirmButtonColor: '#4F39F6',
            confirmButtonText: 'Login'
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof Livewire !== 'undefined') {
                    Livewire.dispatch('showLoginModal');
                }
            }
        });
        return;
    }

    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        // Update button appearance
        const icon = button.querySelector('svg');
        if (data.status === 'added') {
            icon.classList.add('fill-red-500', 'text-red-500');
            Swal.fire({
                title: 'Added!',
                text: data.message,
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            icon.classList.remove('fill-red-500', 'text-red-500');
            Swal.fire({
                title: 'Removed!',
                text: data.message,
                icon: 'info',
                timer: 1500,
                showConfirmButton: false
            });
        }
        
        // Update wishlist count
        if (typeof Livewire !== 'undefined') {
            Livewire.dispatch('wishlistUpdated');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'Something went wrong. Please try again.',
            icon: 'error',
            confirmButtonColor: '#4F39F6'
        });
    });
}
