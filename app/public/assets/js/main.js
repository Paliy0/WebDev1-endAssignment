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
    ? `<img src="${escapeHtml(product.img)}" class="card-img-top" alt="${escapeHtml(product.name)}" style="height: 200px; object-fit: contain;">`
    : `<div class="bg-light text-center p-5"><i class="fa fa-image fa-4x text-muted"></i></div>`;

  const stockButton =
    product.stock > 0
      ? `<form action="/cart/add" method="post">
               <input type="hidden" name="product_id" value="${product.product_id}">
               <input type="hidden" name="quantity" value="1">
               <button type="submit" class="btn btn-success">Add to Cart</button>
           </form>`
      : `<button class="btn btn-secondary" disabled>Out of Stock</button>`;

  return `
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                ${imageHTML}
                <div class="card-body">
                    <h5 class="card-title">${escapeHtml(product.name)}</h5>
                    <p class="card-text text-truncate">${escapeHtml(product.description || "")}</p>
                    <p class="card-text"><strong>$${parseFloat(product.price).toFixed(2)}</strong></p>
                    <p class="text-muted">Sold by: <a href="/shops/${product.store_id}">${escapeHtml(product.shop_name || "")}</a></p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="/products/${product.product_id}" class="btn btn-primary">View Details</a>
                    ${stockButton}
                </div>
            </div>
        </div>
    `;
}

// Display products in the container
function displayProducts(products) {
  const container = document.getElementById("products-container");
  if (!container) return;

  if (!products || products.length === 0) {
    container.innerHTML =
      '<div class="alert alert-info">No products found.</div>';
    return;
  }

  // Use map to create HTML for each product, then join
  const html = products.map((product) => createProductCard(product)).join("");
  container.innerHTML = `<div class="row">${html}</div>`;
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
