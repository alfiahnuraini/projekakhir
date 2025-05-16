document.addEventListener("DOMContentLoaded", function () {
  // Hapus pesanan yang sudah dibayar di awal
  const semuaPesanan = document.querySelectorAll(".pesanan1");

  semuaPesanan.forEach(function (pesanan) {
    const noMeja = pesanan.querySelector(".meja h2")?.textContent.trim();
    const sudahBayar = localStorage.getItem(`sudahBayar_${noMeja}`);
    if (sudahBayar === "true") {
      pesanan.remove();     // Hapus pesanan yang sudah dibayar
    }
  });

    const pesananList = document.querySelectorAll(".pesanan1");
  
    pesananList.forEach(function (pesanan) {
      let total = 0;
      const hargaEls = pesanan.querySelectorAll(".harga");
  
      hargaEls.forEach(function (el) {
        // Ambil teks, hapus "=", titik, dan spasi
        const hargaText = el.textContent.replace("=", "").replace(/\./g, "").trim();
        const harga = parseInt(hargaText);
        if (!isNaN(harga)) total += harga;
      });
  
      const subtotalEl = pesanan.querySelector(".subtotal");
      if (subtotalEl) subtotalEl.textContent = total.toLocaleString("id-ID");

      const tombolBayar = pesanan.querySelector("button");
      tombolBayar .addEventListener("click", () => {
        const laporanList = JSON.parse(localStorage.getItem("LaporanList")) || [];
        const tanggal = new Date();
        const waktuFormat = `${tanggal.getDate().toString().padStart(2, '0')}-${(tanggal.getMonth() + 1).toString().padStart(2, '0')}-${tanggal.getFullYear()} ${tanggal.getHours().toString().padStart(2, '0')}:${tanggal.getMinutes().toString().padStart(2, '0')}:${tanggal.getSeconds().toString().padStart(2, '0')}`;
        
        const noMeja = pesanan.querySelector(".meja")?.textContent.trim();
        const detailEls = pesanan.querySelectorAll(".detail");

        detailEls.forEach(detail => {
          const namaProduk = detail.querySelector(".produk")?.textContent.trim();
          const jumlahText = detail.querySelector(".jumlah")?.textContent.trim();
          const hargaText = detail.querySelector(".harga")?.textContent.replace("=", "").replace(/\./g, "").trim();

          const jumlah = parseInt(jumlahText?.split("x")[0]);
          const subtotal = parseInt(hargaText);
          
          if (namaProduk && !isNaN(jumlah) && !isNaN(subtotal)) {
          laporanList.push({
            noMeja: noMeja,
            namaProduk: namaProduk,
            jmlh: jumlah,
            subtotal: subtotal,
            tanggal: waktuFormat
          });
        }
        });

        localStorage.setItem("LaporanList", JSON.stringify(laporanList));
        localStorage.setItem(`sudahBayar_${noMeja}`, "true");
        localStorage.setItem(`pesanan_${noMeja}`);
        pesanan.remove();
          });
    });
        });
      