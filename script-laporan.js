document.addEventListener("DOMContentLoaded", function () {
const laporanList = JSON.parse(localStorage.getItem('LaporanList')) || [];
const tabel = document.getElementById("tabelHarian").getElementsByTagName('tbody')[0];

laporanList.forEach((item, index) => {
    const row  = tabel.insertRow();
        row.innerHTML = `
        <td>${(index) + 1}</td>
        <td>${item.noMeja || "noMeja"}</td>
        <td>${item.namaProduk || "namaProduk"}</td>
        <td>${item.jmlh || "jmlh"}</td>
        <td>${item.subtotal?.toLocaleString("id-ID") || "subtotal"}</td>
        <td>${item.tanggal || "-"}</td>
        `;
        
    });
});

const tombolHapus = document.getElementById("tombolHapus");
tombolHapus.addEventListener("click", function () {
    localStorage.removeItem('LaporanList');
    location.reload();
});
