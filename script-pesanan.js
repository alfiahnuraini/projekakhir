document.addEventListener("DOMContentLoaded", function () {
    const pesananList = document.querySelectorAll(".pesanan1");
  
    pesananList.forEach(function (pesanan) {
      let total = 0;
      const hargaEls = pesanan.querySelectorAll(".harga");
  
      hargaEls.forEach(function (el) {
        // Ambil teks, hapus "=", titik, dan spasi
        const hargaText = el.textContent.replace("=", "").replace(/\./g, "").trim();
        const harga = parseInt(hargaText);
  
        if (!isNaN(harga)) {
          total += harga;
        }
      });
  
      const subtotalEl = pesanan.querySelector(".subtotal");
      if (subtotalEl) {
        subtotalEl.textContent = total.toLocaleString("id-ID");
      }
    });
  });