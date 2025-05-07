function searchProduct() {
    const keyword = document.getElementById("searchInput").value;

    fetch(`search.php?q=${encodeURIComponent(keyword)}`)
        .then(response => response.json())
        .then(data => {
            // Hapus produk lama
            document.querySelector(".mie").innerHTML = "";

            // Tambahkan produk hasil pencarian
            data.forEach(product => {
                const div = document.createElement("div");
                div.className = "satu";
                div.innerHTML = `
                    <img src="${product.gambar}" />
                    <p>${product.nama}</p>
                    <div class="bawah">
                        <p>Rp ${product.harga}</p>
                        <button>Tambah</button>
                    </div>`;
                document.querySelector(".mie").appendChild(div);
            });
        });

    return false; // cegah form submit reload
}
