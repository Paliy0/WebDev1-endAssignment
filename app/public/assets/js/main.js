/**
 * Product Search - Fetches and displays products using the JSON API
 */

// Escape HTML to prevent XSS
function escapeHtml(text) {
  const div = document.createElement("div");
  div.textContent = text;
  return div.innerHTML;
}

// Render a single product card using template literal
function createProductCard(product) {
  const imageHTML = product.img
    ? `<img src="${escapeHtml(product.img)}" class="product-image" alt="${escapeHtml(product.name)}">`
    : `<div style="display: flex; align-items: center; justify-content: center; height: 100%; background: var(--secondary);">
         <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="color: var(--muted-foreground);"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
       </div>`;

  const stockText =
    product.stock > 0
      ? `<span style="color: var(--success, #22c55e);">In Stock (${product.stock})</span>`
      : `<span style="color: var(--muted-foreground);">Out of Stock</span>`;

  return `
        <a href="/products/${product.product_id}" class="product-card" style="text-decoration: none;">
            <div class="product-image-container">
                ${imageHTML}
                <div class="quick-add-overlay">
                    <span class="btn btn-primary btn-sm btn-full">View Details</span>
                </div>
            </div>
            <div class="product-info">
                <p class="product-shop">${escapeHtml(product.shop_name || "")}</p>
                <h3 class="product-name">${escapeHtml(product.name)}</h3>
                <p class="product-price">$${parseFloat(product.price).toFixed(2)}</p>
                <p style="font-size: 0.75rem; margin-top: var(--space-2);">
                    ${stockText}
                </p>
            </div>
        </a>
    `;
}

// Display products in the container
function displayProducts(products) {
  const container = document.getElementById("products-container");
  if (!container) return;

  if (!products || products.length === 0) {
    container.innerHTML = `
      <div class="cta-card" style="text-align: center; padding: var(--space-16);">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto var(--space-4); color: var(--muted-foreground);"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
        <p class="body-text text-muted">No products found.</p>
      </div>`;
    return;
  }

  // Use map to create HTML for each product, then join
  const html = products.map((product) => createProductCard(product)).join("");
  container.innerHTML = `<div class="product-grid">${html}</div>`;
}

// Fetch products from API using fetch
function loadProducts(searchQuery) {
  const url = searchQuery
    ? `/api/products?search=${encodeURIComponent(searchQuery)}`
    : "/api/products";

  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      displayProducts(data);
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("product-search");
  const searchForm = document.getElementById("search-form");

  if (searchInput) {
    // Handle input changes
    searchInput.addEventListener("input", function () {
      loadProducts(this.value);
    });
  }

  if (searchForm) {
    // Prevent form submission and load products
    searchForm.addEventListener("submit", function (e) {
      e.preventDefault();
      loadProducts(searchInput.value);
    });
  }
});
